# DecoyGuard
### Intelligent Cyber Intrusion Detection Through Cyber Decoys

DecoyGuard adalah sistem deteksi intrusi siber berbasis **Cyber Deception** yang memanfaatkan file umpan (*decoy file*) untuk mendeteksi aktivitas akses mencurigakan pada sistem Windows. Sistem memantau aktivitas akses file, mengirimkan data deteksi ke server, dan menghasilkan peringatan agar administrator dapat memantau potensi ancaman keamanan.

## Fitur Utama

- **Decoy File Monitoring** – Memantau aktivitas akses terhadap file umpan.
- **Intrusion Detection** – Mendeteksi aktivitas pembacaan file melalui Windows Security Event Log.
- **Automated Event Reporting** – Mengirimkan informasi deteksi ke server melalui API.
- **Alert Notification** – Membuat peringatan ketika aktivitas mencurigakan terdeteksi.
- **Alert Management** – Memungkinkan administrator memantau dan mengelola status peringatan.
- **Asset Monitoring** – Mengelola informasi folder dan aset decoy yang dipantau.

## Cara Kerja Sistem

1. Administrator menyiapkan folder dan file decoy.
2. Agent Windows memantau aktivitas akses terhadap file decoy.
3. Ketika file diakses, Windows mencatat aktivitas tersebut pada Security Event Log.
4. Agent membaca event yang sesuai dan mengirimkan data ke server DecoyGuard.
5. Server memvalidasi data dan menyimpan event deteksi.
6. Sistem membuat alert yang dapat dipantau oleh administrator melalui dashboard.

## Arsitektur Sistem

```text
Windows System
      |
      v
Decoy File
      |
      v
Windows Security Event Log
      |
      v
PowerShell Monitoring Agent
      |
      v
DecoyGuard REST API
      |
      v
Event Validation & Processing
      |
      v
MySQL Database
      |
      v
Alert & Monitoring Dashboard
```

## Teknologi yang Digunakan

| Komponen | Teknologi |
|---|---|
| Backend | Laravel 12 |
| Programming Language | PHP 8.2 |
| Database | MySQL |
| Frontend | Blade, HTML, CSS, JavaScript |
| Monitoring Agent | PowerShell |
| Detection Source | Windows Security Event Log |
| Communication | REST API |

## Persyaratan Sistem

- PHP 8.2 atau lebih baru
- Composer
- MySQL
- Node.js dan NPM
- Git
- Windows untuk menjalankan monitoring agent

## Instalasi

1. Clone repository:

```bash
git clone https://github.com/nabillah4125/DecoyGuard.git
```

2. Masuk ke direktori proyek:

```bash
cd DecoyGuard
```

3. Install dependency:

```bash
composer install
npm install
```

4. Salin file konfigurasi:

```bash
cp .env.example .env
```

Untuk Windows Command Prompt:

```cmd
copy .env.example .env
```

5. Generate application key:

```bash
php artisan key:generate
```

6. Atur konfigurasi database pada file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=decoyguard
DB_USERNAME=root
DB_PASSWORD=
```

7. Jalankan aplikasi:

```bash
npm run build
php artisan serve
```

Buka aplikasi melalui:

```text
http://127.0.0.1:8000
```

## Monitoring Agent

DecoyGuard menggunakan PowerShell Agent pada Windows untuk memantau aktivitas akses terhadap file decoy.

Agent bertugas untuk:
- Membaca Windows Security Event Log.
- Memfilter event akses file dengan Event ID 4663.
- Memeriksa apakah file yang diakses merupakan file decoy.
- Mengirimkan informasi event ke endpoint API DecoyGuard menggunakan Bearer Token.

Agent memerlukan konfigurasi alamat API, identitas folder dan aset, lokasi file decoy, serta token autentikasi yang sesuai dengan konfigurasi server.

**Catatan:** Monitoring agent membutuhkan konfigurasi Windows Audit File System dan izin akses Security Event Log agar dapat membaca event yang diperlukan.

## API Endpoint

| Method | Endpoint | Fungsi |
|---|---|---|
| GET | `/api/test` | Menguji koneksi API |
| POST | `/api/events` | Mengirimkan event deteksi dari agent |

Endpoint pengiriman event menggunakan autentikasi Bearer Token.

## Catatan Keamanan

- Jangan mengunggah file `.env` ke repository publik.
- Jangan membagikan API token atau kredensial database.
- Gunakan file `.env.example` sebagai template konfigurasi.
- Folder dan file decoy yang digunakan dalam lingkungan pengujian tidak disertakan dalam repository publik.
- Pastikan konfigurasi database dan riwayat migration disesuaikan sebelum melakukan instalasi pada lingkungan baru.

## Developer

**Nabillah Usti Humairaa**

Project: DecoyGuard  
Category: Penangkalan  
Event: Kartika Cyber Hackathon 2026
