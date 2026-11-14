<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="mb-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-gray-400">
                DecoyGuard / Security Center
            </p>
            <h2 class="text-xl font-semibold text-gray-100">Alert detail</h2>
        </div>
    </x-slot>

    @php
        $severityClass = match($alert->severity) {
            'CRITICAL' => 'border-red-400/20 bg-red-400/10 text-red-300',
            'HIGH' => 'border-orange-400/20 bg-orange-400/10 text-orange-300',
            'MEDIUM' => 'border-amber-400/20 bg-amber-400/10 text-amber-300',
            default => 'border-emerald-400/20 bg-emerald-400/10 text-emerald-300',
        };
        $statusClass = match($alert->status) {
            'NEW' => 'border-cyan-400/20 bg-cyan-400/10 text-cyan-300',
            'ACKNOWLEDGED' => 'border-amber-400/20 bg-amber-400/10 text-amber-300',
            'RESOLVED' => 'border-emerald-400/20 bg-emerald-400/10 text-emerald-300',
            default => 'border-slate-400/20 bg-slate-400/10 text-slate-300',
        };
    @endphp

    <div class="min-h-screen px-4 py-7 sm:px-6 sm:py-9">
        <div class="mx-auto max-w-5xl">
            <div class="mb-5">
                <a href="{{ route('alerts.index') }}"
                   class="inline-flex items-center gap-2 text-sm font-medium text-cyan-300 transition hover:text-white">
                    <span aria-hidden="true">←</span> Back to alerts
                </a>
            </div>

            <section class="mb-5 overflow-hidden rounded-xl border border-[#26364b] bg-[#0e1a2a] shadow-lg">
                <div class="flex flex-col gap-4 border-b border-[#26364b] px-5 py-5 sm:flex-row sm:items-start sm:justify-between sm:px-6">
                    <div class="min-w-0">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-gray-400">
                            Alert #{{ $alert->id }}
                        </p>
                        <h3 class="mt-2 break-words text-lg font-semibold text-gray-100">{{ $alert->title }}</h3>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex rounded-full border px-3 py-1 text-[10px] font-bold {{ $severityClass }}">
                            {{ $alert->severity }}
                        </span>
                        <span class="inline-flex rounded-full border px-3 py-1 text-[10px] font-bold {{ $statusClass }}">
                            {{ $alert->status }}
                        </span>
                    </div>
                </div>

                <div class="p-5 sm:p-6">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-gray-400">Alert message</h4>
                    <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-200">{{ $alert->message }}</p>

                    <dl class="mt-6 grid grid-cols-1 gap-5 border-t border-[#26364b] pt-5 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs text-gray-400">Created at</dt>
                            <dd class="mt-1 text-sm text-gray-200">{{ $alert->created_at ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-400">Acknowledged at</dt>
                            <dd class="mt-1 text-sm text-gray-200">{{ $alert->acknowledged_at ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-400">Resolved at</dt>
                            <dd class="mt-1 text-sm text-gray-200">{{ $alert->resolved_at ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-400">Acknowledged by (user ID)</dt>
                            <dd class="mt-1 text-sm text-gray-200">{{ $alert->acknowledged_by ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </section>

            <section class="mb-5 overflow-hidden rounded-xl border border-[#26364b] bg-[#0e1a2a] shadow-lg">
                <div class="border-b border-[#26364b] px-5 py-5 sm:px-6">
                    <h3 class="text-base font-semibold text-gray-100">Source detection event</h3>
                    <p class="mt-1 text-sm text-gray-400">
                        Information about the event that generated this alert.
                    </p>
                </div>

                <dl class="grid grid-cols-1 gap-x-8 gap-y-5 p-5 sm:grid-cols-2 sm:p-6">
                    <div>
                        <dt class="text-xs text-gray-400">Event ID</dt>
                        <dd class="mt-1 text-sm text-gray-200">#{{ $alert->event_id }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Event UUID</dt>
                        <dd class="mt-1 break-all text-sm text-gray-200">{{ $alert->event_uuid }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Event type</dt>
                        <dd class="mt-1 text-sm text-gray-200">{{ $alert->event_type }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Occurred at</dt>
                        <dd class="mt-1 text-sm text-gray-200">{{ $alert->occurred_at ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Host</dt>
                        <dd class="mt-1 text-sm text-gray-200">{{ $alert->host_name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Decoy folder</dt>
                        <dd class="mt-1 text-sm text-gray-200">{{ $alert->folder_name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Decoy asset</dt>
                        <dd class="mt-1 text-sm text-gray-200">{{ $alert->file_name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Actor username</dt>
                        <dd class="mt-1 text-sm text-gray-200">{{ $alert->actor_username ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Process name</dt>
                        <dd class="mt-1 text-sm text-gray-200">{{ $alert->process_name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Source IP</dt>
                        <dd class="mt-1 text-sm text-gray-200">{{ $alert->source_ip ?? '-' }}</dd>
                    </div>
                </dl>
            </section>

            <section class="mb-5 rounded-xl border border-[#26364b] bg-[#0e1a2a] p-5 shadow-lg sm:p-6">
                <h3 class="text-base font-semibold text-gray-100">Alert actions</h3>

                @if (session('success'))
                    <div class="mt-4 rounded-lg border border-emerald-400/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mt-4 rounded-lg border border-red-400/20 bg-red-400/10 px-4 py-3 text-sm text-red-200">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mt-4 flex flex-wrap gap-3">
                    @if ($alert->status === 'NEW')
                        <form method="POST" action="{{ route('alerts.acknowledge', $alert->id) }}">
                            @csrf
                            <button type="submit"
                                    class="inline-flex min-h-10 items-center justify-center rounded-lg border border-amber-400/25 bg-amber-400/10 px-4 text-sm font-semibold text-amber-200 transition hover:bg-amber-400/20">
                                Acknowledge
                            </button>
                        </form>
                    @endif

                    @if ($alert->status !== 'RESOLVED')
                        <form method="POST"
                              action="{{ route('alerts.resolve', $alert->id) }}"
                              onsubmit="return confirm('Are you sure you want to resolve this alert?')">
                            @csrf
                            <button type="submit"
                                    class="inline-flex min-h-10 items-center justify-center rounded-lg bg-emerald-600 px-4 text-sm font-semibold text-white transition hover:bg-emerald-500">
                                Resolve
                            </button>
                        </form>
                    @endif

                    @if ($alert->status === 'RESOLVED')
                        <p class="self-center text-sm text-emerald-300">This alert has been resolved.</p>
                    @endif
                </div>
            </section>

            <section class="overflow-hidden rounded-xl border border-[#26364b] bg-[#0e1a2a] shadow-lg">
                <div class="border-b border-[#26364b] px-5 py-5 sm:px-6">
                    <h3 class="text-base font-semibold text-gray-100">Raw event data</h3>
                </div>
                <div class="p-5 sm:p-6">
                    <pre class="overflow-x-auto whitespace-pre-wrap break-all rounded-lg border border-[#26364b] bg-[#080f1c] p-4 text-xs leading-5 text-cyan-100">{{ $alert->raw_event ?? 'No raw event data available.' }}</pre>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
