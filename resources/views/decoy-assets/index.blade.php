
<x-app-layout>
    <div class="min-h-screen text-slate-100" style="background:#041a2d; min-height:100vh;">
        <x-slot name="header">
            <div class="flex items-center justify-between bg-[#0b2440] border-b border-blue-800/70 px-4 py-4 shadow-sm">
                <h2 class="font-semibold text-xl text-blue-100 leading-tight">
                    Decoy Assets
                </h2>
                <a href="{{ route('decoy-folders.index') }}"
                   class="text-sm text-blue-200 hover:text-white transition-colors">
                    Kembali ke Decoy Folders
                </a>
            </div>
        </x-slot>

        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-emerald-500/15 border border-emerald-400/30 text-emerald-200 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="shadow-xl ring-1 ring-blue-900/60 sm:rounded-xl p-6" style="background:#071d32; border:1px solid #1b4d82;">
                    <div class="flex justify-between items-center mb-6 border-b border-blue-800/60 pb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-white">
                                {{ $folder->folder_name }}
                            </h3>
                            <p class="text-sm text-blue-200/80">
                                {{ $folder->folder_path }}
                            </p>
                        </div>

                        <a href="{{ route('decoy-assets.create', $folder->id) }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition-colors shadow-md shadow-blue-900/30">
                            + Tambah Asset
                        </a>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-blue-800/50" style="background:#071d32;">
                        <table class="min-w-full divide-y divide-blue-700" style="background:#071d32;">
                            <thead style="background:#0d2542;">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-100 uppercase">No.</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-100 uppercase">File Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-100 uppercase">Relative Path</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-100 uppercase">Type</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-100 uppercase">SHA-256</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-100 uppercase">Status</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-blue-700" style="background:#071d32;">
                                @forelse ($assets as $asset)
                                    <tr style="background:#071d32;">
                                        <td class="px-4 py-3 text-sm text-slate-200">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-4 py-3 text-sm font-medium text-white">
                                            {{ $asset->file_name }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-slate-300">
                                            {{ $asset->relative_path }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-slate-300">
                                            {{ $asset->decoy_type ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-xs text-slate-300 break-all">
                                            {{ $asset->sha256 ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if ($asset->is_active)
                                                <span class="px-2 py-1 text-xs rounded-full bg-emerald-500/20 text-emerald-200 border border-emerald-400/30">
                                                    Active
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-slate-600/40 text-slate-200 border border-slate-500/40">
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-slate-500">
                                            Belum ada Decoy Asset pada folder ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
