
<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800">
                Detection Events
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Riwayat aktivitas keamanan DecoyGuard
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Page Description -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                <h3 class="text-lg font-bold text-gray-800">
                    Event Monitoring
                </h3>
                <p class="text-sm text-gray-500 mt-2">
                    Menampilkan seluruh aktivitas yang terdeteksi
                    pada monitored host dan decoy assets.
                </p>
            </div>

            <!-- Search and Filter -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6">

                <form method="GET"
                      action="{{ route('detection-events.index') }}">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <!-- Search -->
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pencarian
                            </label>

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari host, file, folder, username, atau proses..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <!-- Event Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Event Type
                            </label>

                            <select
                                name="event_type"
                                class="w-full rounded-md border-gray-300 shadow-sm"
                            >
                                <option value="">Semua Aktivitas</option>
                                @foreach (['READ', 'WRITE', 'DELETE', 'RENAME', 'CREATE', 'UNKNOWN'] as $type)
                                    <option value="{{ $type }}"
                                        {{ request('event_type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Severity -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Severity
                            </label>

                            <select
                                name="severity"
                                class="w-full rounded-md border-gray-300 shadow-sm"
                            >
                                <option value="">Semua Severity</option>
                                @foreach (['LOW', 'MEDIUM', 'HIGH', 'CRITICAL'] as $severity)
                                    <option value="{{ $severity }}"
                                        {{ request('severity') == $severity ? 'selected' : '' }}>
                                        {{ $severity }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date From -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Mulai
                            </label>

                            <input
                                type="date"
                                name="date_from"
                                value="{{ request('date_from') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm"
                            >
                        </div>

                        <!-- Date To -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Akhir
                            </label>

                            <input
                                type="date"
                                name="date_to"
                                value="{{ request('date_to') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm"
                            >
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-wrap gap-3 mt-5">

                        <button
                            type="submit"
                            class="px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700"
                        >
                            Cari / Filter
                        </button>

                        <a
                            href="{{ route('detection-events.index') }}"
                            class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200"
                        >
                            Reset
                        </a>

                    </div>

                </form>
            </div>

            <!-- Events Table -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">

                <div class="p-6 border-b">
                    <h3 class="text-lg font-bold text-gray-800">
                        Detection History
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Total {{ $events->total() }} aktivitas ditemukan.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Waktu
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Host
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Aktivitas
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Decoy Asset
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    User
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Severity
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                    Detail
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">

                            @forelse ($events as $event)
                                <tr class="hover:bg-gray-50">

                                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                        {{ $event->occurred_at }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $event->host_name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                        {{ $event->event_type }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $event->file_name ?? $event->folder_name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $event->actor_username ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $severityClass = match($event->severity) {
                                                'LOW' => 'bg-green-100 text-green-700',
                                                'MEDIUM' => 'bg-yellow-100 text-yellow-700',
                                                'HIGH' => 'bg-orange-100 text-orange-700',
                                                'CRITICAL' => 'bg-red-100 text-red-700',
                                                default => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp

                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $severityClass }}">
                                            {{ $event->severity }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                     <a href="{{ route('detection-events.show', $event->id) }}"
   class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
    Detail
</a>
                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7"
                                        class="px-6 py-10 text-center text-gray-400">
                                        Tidak ada data detection event.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-5 border-t">
                    {{ $events->links() }}
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
