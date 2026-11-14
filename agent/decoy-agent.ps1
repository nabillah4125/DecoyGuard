
# ==========================================
# DECOYGUARD - POWERSHELL AGENT
# Tahap 2: Kirim Event Windows ke Laravel API
# ==========================================

$DecoyFile = "C:\xampp\htdocs\decoyguard\DecoyAssets\Finance\Payroll_2026.txt"
$ApiUrl = "http://127.0.0.1:8000/api/events"
$TokenPath = Join-Path $env:APPDATA "DecoyGuard\agent-token.txt"

$FolderId = 1
$AssetId = 1

Write-Host "==================================" -ForegroundColor Cyan
Write-Host "       DECOYGUARD AGENT"
Write-Host "==================================" -ForegroundColor Cyan

# 1. Membaca token
if (-not (Test-Path $TokenPath)) {
    Write-Host "Token tidak ditemukan." -ForegroundColor Red
    exit
}

try {
    $Encrypted = (Get-Content $TokenPath -Raw).Trim()
    $SecureToken = ConvertTo-SecureString $Encrypted
    $BSTR = [Runtime.InteropServices.Marshal]::SecureStringToBSTR($SecureToken)

    try {
        $Token = [Runtime.InteropServices.Marshal]::PtrToStringBSTR($BSTR)
    }
    finally {
        [Runtime.InteropServices.Marshal]::ZeroFreeBSTR($BSTR)
    }

    $SecureToken.Dispose()
    Remove-Variable Encrypted -ErrorAction SilentlyContinue
    Remove-Variable SecureToken -ErrorAction SilentlyContinue
}
catch {
    Write-Host "Token gagal dibaca: $($_.Exception.Message)" -ForegroundColor Red
    exit
}

if ([string]::IsNullOrWhiteSpace($Token)) {
    Write-Host "Token kosong." -ForegroundColor Red
    exit
}

$Headers = @{
    Authorization = "Bearer $Token"
}

Write-Host "File decoy : $DecoyFile"
Write-Host "API        : $ApiUrl"
Write-Host "Agent siap memantau..." -ForegroundColor Green
Write-Host ""

# 2. Menyimpan Record ID yang sudah diproses
$ProcessedEvents = @{}

# 3. Memantau Windows Security Event
while ($true) {
    try {
        $StartTime = (Get-Date).AddSeconds(-30)

        $Events = Get-WinEvent -FilterHashtable @{
            LogName = 'Security'
            Id = 4663
            StartTime = $StartTime
        } -ErrorAction SilentlyContinue

        foreach ($Event in $Events) {

            $RecordId = [string]$Event.RecordId

            if ($ProcessedEvents.ContainsKey($RecordId)) {
                continue
            }

            # Tandai agar tidak dikirim berulang
            $ProcessedEvents[$RecordId] = $true

            # Membaca XML event
            [xml]$Xml = $Event.ToXml()
            $Data = @{}

            foreach ($Item in $Xml.Event.EventData.Data) {
                $Data[$Item.Name] = [string]$Item.'#text'
            }

            $ObjectName = $Data['ObjectName']
            $AccessMask = $Data['AccessMask']
            $AccessList = $Data['AccessList']

            # Hanya file decoy yang dipantau
            if ($ObjectName -ine $DecoyFile) {
                continue
            }

            # Hanya aktivitas ReadData
            if (($AccessMask -notmatch '^(0x)?0*1$') -and
                ($AccessList -notmatch 'ReadData')) {
                continue
            }

            $Username = $Data['SubjectUserName']
            $Process = $Data['ProcessName']

            if ([string]::IsNullOrWhiteSpace($Username)) {
                $Username = "Unknown"
            }

            if ([string]::IsNullOrWhiteSpace($Process)) {
                $Process = "Unknown"
            }

            # Data yang dikirim ke Laravel
            $Payload = @{
                event_uuid = [guid]::NewGuid().ToString()
                event_type = "READ"
                folder_id = $FolderId
                asset_id = $AssetId
                actor_username = $Username
                process_name = $Process
                occurred_at = $Event.TimeCreated.ToString("o")
                raw_event = $Event.Message
            }

            try {
                $Body = $Payload | ConvertTo-Json -Depth 5

                $Response = Invoke-RestMethod `
                    -Uri $ApiUrl `
                    -Method Post `
                    -Headers $Headers `
                    -ContentType "application/json" `
                    -Body $Body `
                    -ErrorAction Stop

                Write-Host "[EVENT TERKIRIM]" -ForegroundColor Green
                Write-Host "Record ID : $RecordId"
                Write-Host "Waktu     : $($Event.TimeCreated)"
                Write-Host "User      : $Username"
                Write-Host "Process   : $Process"
                Write-Host "API       : $($Response.message)"
                Write-Host "----------------------------------"
            }
            catch {
    Write-Host "[GAGAL KIRIM KE API]" -ForegroundColor Red
    Write-Host "Pesan error : $($_.Exception.Message)"

    if ($_.Exception.Response) {
        Write-Host "Status Code : $([int]$_.Exception.Response.StatusCode)"
        Write-Host "Status      : $($_.Exception.Response.StatusDescription)"

        try {
            $Reader = New-Object System.IO.StreamReader(
                $_.Exception.Response.GetResponseStream()
            )
            $ResponseBody = $Reader.ReadToEnd()
            $Reader.Close()

            Write-Host "Response API:"
            Write-Host $ResponseBody
        }
        catch {
            Write-Host "Tidak dapat membaca detail response API."
        }
    }

    Write-Host "----------------------------------"
}
        }
    }
    catch {
        Write-Host "Gagal membaca Windows Event: $($_.Exception.Message)" -ForegroundColor Red
    }

    Start-Sleep -Seconds 3
}
