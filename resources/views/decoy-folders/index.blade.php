
<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="mb-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-gray-400">
                DecoyGuard / Decoy Management
            </p>
            <h2 class="text-xl font-semibold text-gray-100">Decoy Folders</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-5 rounded-lg border border-emerald-900 bg-[#1f332b] px-5 py-4 text-sm text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-xl border border-[#41454c] bg-[#292c31] p-5 shadow-lg sm:p-7">

                <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-100">
                            Daftar Decoy Folders
                        </h3>
                        <p class="mt-1 text-sm text-gray-400">
                            Kelola folder umpan pada komputer yang dipantau.
                        </p>
                    </div>

                    <a href="{{ route('decoy-folders.create') }}"
                       class="inline-flex min-h-10 items-center justify-center rounded-lg bg-gray-200 px-4 text-sm font-semibold text-gray-900 transition hover:bg-white">
                        + Tambah Folder
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#41454c]">
                        <thead class="bg-[#202328]">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-400">No.</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-400">Folder</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-400">Host</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-400">Path</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-400">Assets</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-400">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-400">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#383c43]">
                            @forelse ($folders as $folder)
                                <tr class="transition hover:bg-[#32353b]">
                                    <td class="px-4 py-3 text-sm text-gray-400">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-4 py-3 text-sm font-medium text-gray-100">
                                        {{ $folder->folder_name }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-300">
                                        {{ $folder->host_name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-400">
                                        {{ $folder->folder_path }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-300">
                                        {{ $folder->total_assets }}
                                    </td>

                                    <td class="px-4 py-3 text-sm">
                                        @if ($folder->status === 'active')
                                            <span class="rounded-full border border-emerald-900 bg-[#1f332b] px-2.5 py-1 text-xs font-medium text-emerald-300">
                                                Active
                                            </span>
                                        @else
                                            <span class="rounded-full border border-[#50545c] bg-[#383c43] px-2.5 py-1 text-xs font-medium text-gray-300">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <a href="{{ route('decoy-assets.index', $folder->id) }}"
                                           class="font-medium text-gray-300 transition hover:text-white">
                                            Manage Assets
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-10 text-center text-sm text-gray-400">
                                        Belum ada Decoy Folder.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
