
<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800">
                Detail Detection Event
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Informasi lengkap aktivitas keamanan yang terdeteksi.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Back Button -->
            <div class="mb-5">
                <a href="{{ route('detection-events.index') }}"
                   class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                    &larr; Kembali ke Detection Events
                </a>
            </div>

            <!-- Event Header -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex flex-wrap justify-between items-center gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Event ID</p>
                        <h3 class="text-xl font-bold text-gray-800">
                            #{{ $event->id }}
                        </h3>
                    </div>

                    @php
                        $severityClass = match($event->severity) {
                            'LOW' => 'bg-green-100 text-green-700',
                            'MEDIUM' => 'bg-yellow-100 text-yellow-700',
                            'HIGH' => 'bg-orange-100 text-orange-700',
                            'CRITICAL' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp

                    <span class="px-4 py-2 rounded-full text-sm font-bold {{ $severityClass }}">
                        {{ $event->severity }}
                    </span>
                </div>
            </div>

            <!-- Event Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Detection Information -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-5 border-b">
                        <h3 class="font-bold text-gray-800">
                            Detection Information
                        </h3>
                    </div>

                    <div class="p-6 space-y-5">

                        <div>
                            <p class="text-sm text-gray-500">Event UUID</p>
                            <p class="text-sm font-medium text-gray-800 break-all mt-1">
                                {{ $event->event_uuid }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Event Type</p>
                            <p class="text-sm font-semibold text-gray-800 mt-1">
                                {{ $event->event_type }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Severity</p>
                            <p class="text-sm font-semibold text-gray-800 mt-1">
                                {{ $event->severity }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Occurred At</p>
                            <p class="text-sm text-gray-800 mt-1">
                                {{ $event->occurred_at ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Received At</p>
                            <p class="text-sm text-gray-800 mt-1">
                                {{ $event->received_at ?? '-' }}
                            </p>
                        </div>

                    </div>
                </div>

                <!-- Host Information -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-5 border-b">
                        <h3 class="font-bold text-gray-800">
                            Host & Asset Information
                        </h3>
                    </div>

                    <div class="p-6 space-y-5">

                        <div>
                            <p class="text-sm text-gray-500">Host Name</p>
                            <p class="text-sm font-medium text-gray-800 mt-1">
                                {{ $event->host_name ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Folder</p>
                            <p class="text-sm text-gray-800 mt-1">
                                {{ $event->folder_name ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Decoy Asset</p>
                            <p class="text-sm text-gray-800 mt-1">
                                {{ $event->file_name ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Actor Username</p>
                            <p class="text-sm text-gray-800 mt-1">
                                {{ $event->actor_username ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Source IP</p>
                            <p class="text-sm text-gray-800 mt-1">
                                {{ $event->source_ip ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Process Name</p>
                            <p class="text-sm text-gray-800 mt-1 break-all">
                                {{ $event->process_name ?? '-' }}
                            </p>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Raw Event -->
            <div class="bg-white rounded-lg shadow-sm mt-6 overflow-hidden">
                <div class="p-5 border-b">
                    <h3 class="font-bold text-gray-800">
                        Raw Event Data
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Data asli event yang diterima dari Windows Audit.
                    </p>
                </div>

                <div class="p-6">
                    <pre class="bg-gray-900 text-green-300 p-5 rounded-lg text-xs overflow-x-auto whitespace-pre-wrap break-all">{{ $event->raw_event ?? 'Tidak ada raw event.' }}</pre>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
