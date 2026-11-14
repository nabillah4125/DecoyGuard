<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="mb-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-gray-400">
                DecoyGuard / Security Center
            </p>
            <h2 class="text-xl font-semibold text-gray-100">Security Alerts</h2>
            <p class="mt-1 text-sm text-gray-400">Tinjau dan tindak lanjuti alert keamanan.</p>
        </div>
    </x-slot>

    <style>
        .alerts-page nav[role="navigation"] {
            border: 0 !important;
            background: transparent !important;
        }

        .alerts-page nav[role="navigation"] a,
        .alerts-page nav[role="navigation"] [aria-current="page"] span,
        .alerts-page nav[role="navigation"] [aria-disabled="true"] span {
            border-color: #33465e !important;
            background: #0b1422 !important;
            color: #cbd5e1 !important;
        }

        .alerts-page nav[role="navigation"] [aria-current="page"] span {
            border-color: #0891b2 !important;
            background: #0891b2 !important;
            color: #ffffff !important;
        }

        .alerts-page nav[role="navigation"] p {
            color: #9aabc1 !important;
        }
    </style>

    <div class="alerts-page min-h-screen px-4 py-7 sm:px-6 sm:py-9">
        <div class="mx-auto max-w-7xl">
            <section class="mb-5 rounded-xl border border-[#26364b] bg-[#0e1a2a] p-5 shadow-lg sm:p-6">
                <form method="GET" action="{{ route('alerts.index') }}"
                      class="grid grid-cols-1 items-end gap-4 md:grid-cols-4">
                    <div>
                        <label for="alert-search" class="mb-2 block text-sm font-medium text-gray-200">
                            Search
                        </label>
                        <input id="alert-search" type="text" name="search"
                               value="{{ request('search') }}"
                               placeholder="Search alert..."
                               class="w-full rounded-lg border border-[#33465e] bg-[#0b1422] px-3.5 py-3 text-sm text-gray-100 placeholder-gray-500 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
                    </div>

                    <div>
                        <label for="alert-severity" class="mb-2 block text-sm font-medium text-gray-200">
                            Severity
                        </label>
                        <select id="alert-severity" name="severity"
                                class="w-full rounded-lg border border-[#33465e] bg-[#0b1422] px-3.5 py-3 text-sm text-gray-100 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
                            <option value="">All severity</option>
                            @foreach (['LOW', 'MEDIUM', 'HIGH', 'CRITICAL'] as $severity)
                                <option value="{{ $severity }}" @selected(request('severity') === $severity)>
                                    {{ $severity }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="alert-status" class="mb-2 block text-sm font-medium text-gray-200">
                            Status
                        </label>
                        <select id="alert-status" name="status"
                                class="w-full rounded-lg border border-[#33465e] bg-[#0b1422] px-3.5 py-3 text-sm text-gray-100 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
                            <option value="">All status</option>
                            @foreach (['NEW', 'ACKNOWLEDGED', 'RESOLVED'] as $status)
                                <option value="{{ $status }}" @selected(request('status') === $status)>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                                class="inline-flex min-h-11 flex-1 items-center justify-center rounded-lg bg-cyan-600 px-4 text-sm font-semibold text-white transition hover:bg-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-[#0e1a2a]">
                            Filter
                        </button>
                        <a href="{{ route('alerts.index') }}"
                           class="inline-flex min-h-11 items-center justify-center rounded-lg border border-[#33465e] px-4 text-sm font-medium text-gray-300 transition hover:bg-[#16263b] hover:text-white">
                            Reset
                        </a>
                    </div>
                </form>
            </section>

            <section class="overflow-hidden rounded-xl border border-[#26364b] bg-[#0e1a2a] shadow-lg">
                <div class="border-b border-[#26364b] px-5 py-5 sm:px-6">
                    <h3 class="text-base font-semibold text-gray-100">Alert history</h3>
                    <p class="mt-1 text-sm text-gray-400">Daftar alert yang dihasilkan oleh aktivitas terdeteksi.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#26364b] text-left">
                        <thead class="bg-[#0b1422]">
                            <tr>
                                <th class="whitespace-nowrap px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Time</th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Alert</th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Host</th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Asset</th>
                                <th class="whitespace-nowrap px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Severity</th>
                                <th class="whitespace-nowrap px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Status</th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#26364b]">
                            @forelse ($alerts as $alert)
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
                                <tr class="transition hover:bg-[#122238]">
                                    <td class="whitespace-nowrap px-5 py-4 text-xs text-gray-400">
                                        {{ $alert->created_at ?? '-' }}
                                    </td>
                                    <td class="min-w-[220px] px-5 py-4">
                                        <div class="text-sm font-semibold text-gray-100">{{ $alert->title }}</div>
                                        <div class="mt-1 text-xs leading-5 text-gray-400">
                                            {{ \Illuminate\Support\Str::limit($alert->message, 70) }}
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-sm text-gray-300">{{ $alert->host_name ?? '-' }}</td>
                                    <td class="px-5 py-4 text-sm text-gray-300">{{ $alert->file_name ?? '-' }}</td>
                                    <td class="whitespace-nowrap px-5 py-4">
                                        <span class="inline-flex rounded-full border px-2.5 py-1 text-[10px] font-bold {{ $severityClass }}">
                                            {{ $alert->severity }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4">
                                        <span class="inline-flex rounded-full border px-2.5 py-1 text-[10px] font-bold {{ $statusClass }}">
                                            {{ $alert->status }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4">
                                        <a href="{{ route('alerts.show', $alert->id) }}"
                                           class="text-sm font-semibold text-cyan-300 transition hover:text-white">
                                            Detail <span aria-hidden="true">→</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-12 text-center text-sm text-gray-400">
                                        No alerts found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-[#26364b] p-4">
                    {{ $alerts->links() }}
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
