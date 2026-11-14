
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-100">
            Monitored Hosts
        </h2>
    </x-slot>

    <style>
        .host-page {
            color: #e5e7eb;
        }

        .host-page .host-card {
            background: #292c31;
            border: 1px solid #41454c;
            border-radius: 10px;
        }

        .host-page .host-table {
            width: 100%;
            border-collapse: collapse;
        }

        .host-page .host-table th {
            padding: 13px 18px;
            color: #a1a1aa;
            font-size: 11px;
            font-weight: 600;
            text-align: left;
            text-transform: uppercase;
            white-space: nowrap;
            border-bottom: 1px solid #41454c;
        }

        .host-page .host-table td {
            padding: 17px 18px;
            color: #d1d5db;
            font-size: 13px;
            border-bottom: 1px solid #383c43;
            white-space: nowrap;
        }

        .host-page .host-table tbody tr:last-child td {
            border-bottom: none;
        }

        .host-page .host-table tbody tr:hover {
            background: #32353b;
        }

        .host-page .host-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            padding: 0 17px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 600;
            transition: .2s;
        }

        .host-page .button-primary {
            background: #e5e7eb;
            color: #202328;
        }

        .host-page .button-primary:hover {
            background: #ffffff;
        }

        .host-page .button-secondary {
            background: #383c43;
            border: 1px solid #555a62;
            color: #e5e7eb;
        }

        .host-page .button-secondary:hover {
            background: #4b5058;
        }

        .host-page .token-input {
            width: 100%;
            min-width: 0;
            min-height: 40px;
            padding: 9px 12px;
            border: 1px solid #50545c;
            border-radius: 7px;
            background: #202328;
            color: #e5e7eb;
            font-size: 12px;
        }

        .host-page .status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 12px;
            font-weight: 600;
        }

        .host-page .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        .host-page .notice {
            background: #302c25;
            border: 1px solid #665333;
            border-radius: 9px;
        }
    </style>

    <div class="host-page min-h-screen px-4 py-7 sm:px-6">
        <div class="mx-auto max-w-7xl">

            {{-- NOTIFICATION --}}
            @if(session('success'))
                <div class="mb-5 rounded-lg border border-[#555a62] bg-[#292c31] px-5 py-4">
                    <p class="text-sm font-semibold text-gray-100">Berhasil</p>
                    <p class="mt-1 text-xs text-gray-400">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            {{-- NEW AGENT TOKEN --}}
            @if(session('agent_token'))
                <div class="notice mb-5 p-5">
                    <h3 class="text-sm font-semibold text-amber-200">
                        Agent Token Baru
                    </h3>

                    <p class="mt-2 text-xs leading-5 text-amber-100/70">
                        Salin token ini dan simpan dengan aman. Token asli tidak akan ditampilkan kembali.
                    </p>

                    <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                        <input
                            id="agentToken"
                            type="password"
                            readonly
                            value="{{ session('agent_token') }}"
                            class="token-input"
                        >

                        <button
                            type="button"
                            onclick="
                                const field = document.getElementById('agentToken');
                                field.type = field.type === 'password' ? 'text' : 'password';
                                this.textContent = field.type === 'password' ? 'Lihat' : 'Sembunyikan';
                            "
                            class="host-button button-secondary"
                        >
                            Lihat
                        </button>

                        <button
                            type="button"
                            onclick="
                                const field = document.getElementById('agentToken');
                                navigator.clipboard.writeText(field.value).then(() => {
                                    this.textContent = 'Tersalin';
                                    setTimeout(() => this.textContent = 'Salin', 1800);
                                }).catch(() => alert('Gagal menyalin token.'));
                            "
                            class="host-button button-secondary"
                        >
                            Salin
                        </button>
                    </div>
                </div>
            @endif

            {{-- HOST LIST CARD --}}
            <section class="host-card p-5 sm:p-7">

                {{-- CARD HEADER --}}
                <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-100">
                            Daftar Host
                        </h3>
                        <p class="mt-1 text-sm text-gray-400">
                            Komputer yang terdaftar dalam pemantauan DecoyGuard.
                        </p>
                    </div>

                    <a href="{{ route('monitored-hosts.create') }}"
                       class="host-button button-primary">
                        + Tambah Host
                    </a>
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table class="host-table">
                        <thead>
                            <tr>
                                <th>Host Identifier</th>
                                <th>Host Name</th>
                                <th>Operating System</th>
                                <th>Status</th>
                                <th>Last Seen</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($hosts as $host)
                                <tr>
                                    <td class="font-semibold text-gray-100">
                                        {{ $host->host_identifier }}
                                    </td>

                                    <td>
                                        {{ $host->host_name }}
                                    </td>

                                    <td>
                                        {{ $host->os_type }} {{ $host->os_version }}
                                    </td>

                                    <td>
                                        @if($host->status === 'online')
                                            <span class="status text-emerald-400">
                                                <span class="status-dot bg-emerald-400"></span>
                                                Online
                                            </span>
                                        @elseif($host->status === 'maintenance')
                                            <span class="status text-amber-400">
                                                <span class="status-dot bg-amber-400"></span>
                                                Maintenance
                                            </span>
                                        @else
                                            <span class="status text-gray-400">
                                                <span class="status-dot bg-gray-500"></span>
                                                Offline
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-gray-400">
                                        {{ $host->last_seen_at ?? 'Belum pernah terhubung' }}
                                    </td>

                                    <td>
                                        <form
                                            action="{{ route('monitored-hosts.regenerate-token', $host->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Terbitkan token baru untuk host {{ $host->host_identifier }}? Token lama akan langsung tidak berlaku.');"
                                        >
                                            @csrf

                                            <button type="submit"
                                                    class="host-button button-secondary">
                                                Regenerate Token
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center">
                                        <p class="text-sm font-medium text-gray-300">
                                            Belum ada komputer yang terdaftar.
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">
                                            Klik Tambah Host untuk mendaftarkan perangkat.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </section>

            <div class="mt-7 border-t border-[#35383e] pt-5 text-center">
                <p class="text-[10px] uppercase tracking-widest text-gray-500">
                    DECOYGUARD · SECURITY MONITORING SYSTEM
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
