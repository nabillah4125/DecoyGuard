<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="mb-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-gray-400">
                    DecoyGuard / Asset Management
                </p>
                <h2 class="text-xl font-semibold text-gray-100">Tambah Decoy Asset</h2>
                <p class="mt-1 text-sm text-gray-400">
                    Daftarkan file umpan pada folder yang dipilih.
                </p>
            </div>

            <a href="{{ route('decoy-assets.index', $folder->id) }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-gray-300 transition hover:text-white">
                <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path d="m15 18-6-6 6-6" />
                    <path d="M9 12h11" />
                </svg>
                Kembali ke assets
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen px-4 py-7 sm:px-6 sm:py-9">
        <div class="mx-auto max-w-3xl">
            <section class="overflow-hidden rounded-xl border border-[#26364b] bg-[#0e1a2a] shadow-lg">
                <div class="border-b border-[#26364b] px-5 py-5 sm:px-7">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-gray-400">
                        Folder tujuan
                    </p>
                    <h3 class="mt-2 text-base font-semibold text-gray-100">{{ $folder->folder_name }}</h3>
                    <p class="mt-1 break-all text-sm text-gray-400">{{ $folder->folder_path }}</p>
                </div>

                <form method="POST" action="{{ route('decoy-assets.store', $folder->id) }}" class="p-5 sm:p-7">
                    @csrf

                    <div class="mb-5">
                        <label for="file_name" class="mb-2 block text-sm font-medium text-gray-200">
                            Nama file <span class="text-red-400">*</span>
                        </label>
                        <input id="file_name" type="text" name="file_name"
                               value="{{ old('file_name') }}"
                               maxlength="255" required
                               placeholder="Payroll_2026.txt"
                               class="w-full rounded-lg border border-[#33465e] bg-[#0b1422] px-3.5 py-3 text-sm text-gray-100 placeholder-gray-500 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
                        @error('file_name')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="relative_path" class="mb-2 block text-sm font-medium text-gray-200">
                            Jalur relatif <span class="text-red-400">*</span>
                        </label>
                        <input id="relative_path" type="text" name="relative_path"
                               value="{{ old('relative_path') }}"
                               maxlength="500" required
                               placeholder="Finance\Payroll_2026.txt"
                               class="w-full rounded-lg border border-[#33465e] bg-[#0b1422] px-3.5 py-3 text-sm text-gray-100 placeholder-gray-500 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
                        @error('relative_path')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="decoy_type" class="mb-2 block text-sm font-medium text-gray-200">
                            Tipe decoy
                        </label>
                        <select id="decoy_type" name="decoy_type"
                                class="w-full rounded-lg border border-[#33465e] bg-[#0b1422] px-3.5 py-3 text-sm text-gray-100 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
                            <option value="">Pilih tipe</option>
                            <option value="Document" {{ old('decoy_type') === 'Document' ? 'selected' : '' }}>Document</option>
                            <option value="Spreadsheet" {{ old('decoy_type') === 'Spreadsheet' ? 'selected' : '' }}>Spreadsheet</option>
                            <option value="Database" {{ old('decoy_type') === 'Database' ? 'selected' : '' }}>Database</option>
                            <option value="Configuration" {{ old('decoy_type') === 'Configuration' ? 'selected' : '' }}>Configuration</option>
                            <option value="Other" {{ old('decoy_type') === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('decoy_type')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-7">
                        <label for="sha256" class="mb-2 block text-sm font-medium text-gray-200">
                            SHA-256 <span class="text-gray-500">(opsional)</span>
                        </label>
                        <input id="sha256" type="text" name="sha256"
                               value="{{ old('sha256') }}"
                               maxlength="64"
                               placeholder="64 karakter hash SHA-256"
                               class="w-full rounded-lg border border-[#33465e] bg-[#0b1422] px-3.5 py-3 text-sm text-gray-100 placeholder-gray-500 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
                        @error('sha256')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-[#26364b] pt-5 sm:flex-row sm:justify-end">
                        <a href="{{ route('decoy-assets.index', $folder->id) }}"
                           class="inline-flex min-h-11 items-center justify-center rounded-lg border border-[#33465e] px-5 text-sm font-medium text-gray-300 transition hover:bg-[#16263b] hover:text-white">
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex min-h-11 items-center justify-center rounded-lg bg-cyan-600 px-5 text-sm font-semibold text-white transition hover:bg-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-[#0e1a2a]">
                            Simpan asset
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
