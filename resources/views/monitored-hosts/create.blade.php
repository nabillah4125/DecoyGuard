
<x-app-layout>
    <style>
        .host-create {
            color: #e5e7eb;
        }

        .host-create .host-card {
            background: #0e1a2a;
            border: 1px solid #26364b;
            border-radius: 12px;
        }

        .host-create .host-input {
            width: 100%;
            min-height: 44px;
            padding: 10px 13px;
            background: #0b1422;
            border: 1px solid #33465e;
            border-radius: 7px;
            color: #e8eef8;
            font-size: 13px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .host-create .host-input:focus {
            border-color: #22d3ee;
            box-shadow: 0 0 0 2px rgba(34,211,238,.15);
        }

        .host-create .host-input::placeholder {
            color: #8291a8;
        }

        .host-create .host-label {
            display: block;
            margin-bottom: 8px;
            color: #e8eef8;
            font-size: 13px;
            font-weight: 600;
        }

        .host-create .host-help {
            margin-top: 7px;
            color: #8291a8;
            font-size: 11px;
            line-height: 1.5;
        }

        .host-create .host-section-title {
            color: #e8eef8;
            font-size: 14px;
            font-weight: 600;
        }

        .host-create .host-muted {
            color: #9aabc1;
            font-size: 12px;
            line-height: 1.7;
        }

        .host-create .host-button {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 18px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 600;
            transition: .2s;
        }

        .host-create .host-button-secondary {
            color: #cbd5e1;
            background: #122238;
            border: 1px solid #2b3b51;
        }

        .host-create .host-button-secondary:hover {
            background: #1a2d45;
            color: #fff;
        }

        .host-create .host-button-primary {
            color: #ffffff;
            background: #0891b2;
        }

        .host-create .host-button-primary:hover {
            background: #0e7490;
        }

        .host-create .host-error {
            margin-top: 7px;
            color: #fca5a5;
            font-size: 11px;
        }

        @media (max-width: 900px) {
            .host-create .host-layout {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

    <div class="host-create min-h-screen px-4 py-8 sm:px-6">
        <div class="mx-auto max-w-6xl">

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-[minmax(0,1.7fr)_minmax(260px,.8fr)] host-layout">

                {{-- FORM --}}
                <section class="host-card overflow-hidden">

                    <div class="border-b border-[#26364b] px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="grid h-10 w-10 shrink-0 place-items-center rounded-lg border border-[#2b3b51] bg-[#0b1422]">
                                <svg viewBox="0 0 24 24" width="20" height="20"
                                     fill="none" stroke="currentColor" stroke-width="1.7">
                                    <rect x="3" y="4" width="18" height="13" rx="2"/>
                                    <path d="M8 21h8m-4-4v4"/>
                                </svg>
                            </div>

                            <div>
                                <h3 class="host-section-title">Informasi Perangkat</h3>
                                <p class="host-muted mt-1">
                                    Lengkapi identitas dan sistem operasi endpoint.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('monitored-hosts.store') }}"
                          method="POST" class="p-6 sm:p-7">
                        @csrf

                        <div class="grid grid-cols-1 gap-x-5 gap-y-5 sm:grid-cols-2">

                            {{-- HOST IDENTIFIER --}}
                            <div>
                                <label for="host_identifier" class="host-label">
                                    ID Host <span class="text-red-400">*</span>
                                </label>

                                <input
                                    id="host_identifier"
                                    type="text"
                                    name="host_identifier"
                                    value="{{ old('host_identifier') }}"
                                    placeholder="Contoh: PC-DECOY-001"
                                    maxlength="100"
                                    autocomplete="off"
                                    required
                                    class="host-input"
                                >

                                @error('host_identifier')
                                    <p class="host-error">{{ $message }}</p>
                                @enderror

                                <p class="host-help">
                                    Identitas unik untuk membedakan setiap perangkat.
                                </p>
                            </div>

                            {{-- HOST NAME --}}
                            <div>
                                <label for="host_name" class="host-label">
                                    Nama Perangkat <span class="text-red-400">*</span>
                                </label>

                                <input
                                    id="host_name"
                                    type="text"
                                    name="host_name"
                                    value="{{ old('host_name') }}"
                                    placeholder="Contoh: DESKTOP-ABC123"
                                    maxlength="150"
                                    required
                                    class="host-input"
                                >

                                @error('host_name')
                                    <p class="host-error">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- OS TYPE --}}
                            <div>
                                <label for="os_type" class="host-label">
                                    Sistem Operasi <span class="text-red-400">*</span>
                                </label>

                                <select id="os_type" name="os_type"
                                        required class="host-input">
                                    <option value="Windows"
                                        {{ old('os_type', 'Windows') === 'Windows' ? 'selected' : '' }}>
                                        Windows
                                    </option>
                                </select>

                                @error('os_type')
                                    <p class="host-error">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- OS VERSION --}}
                            <div>
                                <label for="os_version" class="host-label">
                                    Versi Windows <span class="text-red-400">*</span>
                                </label>

                                <select id="os_version" name="os_version"
                                        required class="host-input">
                                    <option value="">Pilih versi Windows</option>
                                    <option value="Windows 10"
                                        {{ old('os_version') === 'Windows 10' ? 'selected' : '' }}>
                                        Windows 10
                                    </option>
                                    <option value="Windows 11"
                                        {{ old('os_version') === 'Windows 11' ? 'selected' : '' }}>
                                        Windows 11
                                    </option>
                                </select>

                                @error('os_version')
                                    <p class="host-error">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- BUTTONS --}}
                        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-[#26364b] pt-5 sm:flex-row sm:justify-end">

                            <a href="{{ route('monitored-hosts.index') }}"
                               class="host-button host-button-secondary">
                                Batal
                            </a>

                            <button type="submit"
                                    class="host-button host-button-primary">
                                Daftarkan Host

                                <svg viewBox="0 0 24 24" width="16" height="16"
                                     fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14m-6-6 6 6-6 6"/>
                                </svg>
                            </button>

                        </div>
                    </form>
                </section>

                {{-- INFORMATION PANEL --}}
                <aside class="space-y-5">

                    <section class="host-card p-5 sm:p-6">
                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">
                            Registration Guide
                        </p>

                        <h3 class="mt-3 text-base font-semibold text-gray-100">
                            Sebelum Mendaftar
                        </h3>

                        <p class="host-muted mt-2">
                            Pastikan informasi perangkat sudah sesuai sebelum endpoint didaftarkan.
                        </p>

                        <div class="mt-5 space-y-4">

                            <div class="flex gap-3">
                                <span class="text-xs font-semibold text-gray-300">01</span>
                                <div>
                                    <p class="text-sm font-medium text-gray-200">
                                        ID Host Unik
                                    </p>
                                    <p class="host-muted mt-1">
                                        Gunakan identitas berbeda untuk setiap perangkat.
                                    </p>
                                </div>
                            </div>

                            <div class="border-t border-[#26364b]"></div>

                            <div class="flex gap-3">
                                <span class="text-xs font-semibold text-gray-300">02</span>
                                <div>
                                    <p class="text-sm font-medium text-gray-200">
                                        Sistem Operasi
                                    </p>
                                    <p class="host-muted mt-1">
                                        Pastikan versi Windows sesuai dengan perangkat yang dipantau.
                                    </p>
                                </div>
                            </div>

                            <div class="border-t border-[#26364b]"></div>

                            <div class="flex gap-3">
                                <span class="text-xs font-semibold text-gray-300">03</span>
                                <div>
                                    <p class="text-sm font-medium text-gray-200">
                                        Agent DecoyGuard
                                    </p>
                                    <p class="host-muted mt-1">
                                        Pastikan agent dipasang dan dikonfigurasi pada endpoint.
                                    </p>
                                </div>
                            </div>

                        </div>
                    </section>

                    {{-- TOKEN NOTICE --}}
                    <section class="rounded-xl border border-[#26364b] bg-[#0b1422] p-5">
                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 shrink-0 text-gray-300"
                                 viewBox="0 0 24 24" width="19" height="19"
                                 fill="none" stroke="currentColor" stroke-width="1.7">
                                <rect x="5" y="10" width="14" height="11" rx="2"/>
                                <path d="M8 10V7a4 4 0 1 1 8 0v3"/>
                            </svg>

                            <div>
                                <h3 class="text-sm font-semibold text-gray-100">
                                    Keamanan Agent Token
                                </h3>

                                <p class="host-muted mt-2">
                                    Jika token agent ditampilkan setelah pendaftaran, salin dan simpan di tempat aman. Jangan membagikan token kepada pihak lain.
                                </p>
                            </div>
                        </div>
                    </section>

                </aside>
            </div>

            <div class="mt-7 border-t border-[#26364b] pt-5 text-center">
                <p class="text-[10px] uppercase tracking-widest text-gray-500">
                    DECOYGUARD · SECURITY MONITORING SYSTEM
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
