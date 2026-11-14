
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="mb-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-gray-400">
                    DecoyGuard / Decoy Management
                </p>
                <h2 class="text-xl font-semibold text-gray-100">Tambah Decoy Folder</h2>
                <p class="mt-1 text-sm text-gray-400">
                    Pilih host dan tentukan folder yang akan dipantau.
                </p>
            </div>

            <a href="{{ route('decoy-folders.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-gray-300 transition hover:text-white">
                <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path d="m15 18-6-6 6-6" />
                    <path d="M9 12h11" />
                </svg>
                Kembali ke daftar folder
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen px-4 py-7 sm:px-6 sm:py-9">
        <div class="mx-auto max-w-3xl">
            <section class="overflow-hidden rounded-xl border border-[#26364b] bg-[#0e1a2a] shadow-lg">
                <div class="border-b border-[#26364b] px-5 py-5 sm:px-7">
                    <h3 class="text-base font-semibold text-gray-100">Informasi decoy folder</h3>
                    <p class="mt-1 text-sm text-gray-400">
                        Lengkapi lokasi dan detail folder umpan.
                    </p>
                </div>

                <form method="POST" action="{{ route('decoy-folders.store') }}" class="p-5 sm:p-7">
                    @csrf

                    <div class="mb-5">
                        <label for="host_id" class="mb-2 block text-sm font-medium text-gray-200">
                            Monitored host <span class="text-red-400">*</span>
                        </label>

                        <select id="host_id" name="host_id" required
                                class="w-full rounded-lg border border-[#33465e] bg-[#0b1422] px-3.5 py-3 text-sm text-gray-100 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
                            <option value="">Pilih host yang dipantau</option>

                            @foreach ($hosts as $host)
                                <option value="{{ $host->id }}" {{ old('host_id') == $host->id ? 'selected' : '' }}>
                                    {{ $host->host_name }}
                                </option>
                            @endforeach
                        </select>

                        @error('host_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="folder_name" class="mb-2 block text-sm font-medium text-gray-200">
                            Nama folder <span class="text-red-400">*</span>
                        </label>

                        <input id="folder_name" type="text" name="folder_name"
                               value="{{ old('folder_name') }}" maxlength="150" required
                               placeholder="Contoh: Finance"
                               class="w-full rounded-lg border border-[#33465e] bg-[#0b1422] px-3.5 py-3 text-sm text-gray-100 placeholder-gray-500 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">

                        @error('folder_name')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="folder_path" class="mb-2 block text-sm font-medium text-gray-200">
                            Lokasi folder <span class="text-red-400">*</span>
                        </label>

                        <input id="folder_path" type="text" name="folder_path"
                               value="{{ old('folder_path') }}" maxlength="500" required
                               placeholder="C:\DecoyGuard\Finance"
                               class="w-full rounded-lg border border-[#33465e] bg-[#0b1422] px-3.5 py-3 text-sm text-gray-100 placeholder-gray-500 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">

                        @error('folder_path')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-7">
                        <label for="description" class="mb-2 block text-sm font-medium text-gray-200">
                            Deskripsi <span class="text-gray-500">(opsional)</span>
                        </label>

                        <textarea id="description" name="description" rows="3"
                                  placeholder="Tambahkan keterangan untuk folder ini"
                                  class="w-full resize-y rounded-lg border border-[#33465e] bg-[#0b1422] px-3.5 py-3 text-sm text-gray-100 placeholder-gray-500 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">{{ old('description') }}</textarea>

                        @error('description')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-[#26364b] pt-5 sm:flex-row sm:justify-end">
                        <a href="{{ route('decoy-folders.index') }}"
                           class="inline-flex min-h-11 items-center justify-center rounded-lg border border-[#33465e] px-5 text-sm font-medium text-gray-300 transition hover:bg-[#16263b] hover:text-white">
                            Batal
                        </a>

                        <button type="submit"
                                class="inline-flex min-h-11 items-center justify-center rounded-lg bg-cyan-600 px-5 text-sm font-semibold text-white transition hover:bg-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-[#0e1a2a]">
                            Simpan folder
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
