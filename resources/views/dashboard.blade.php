<x-app-layout>
    <style>
        .soc-dashboard {
            --soc-bg: #080f1c;
            --soc-panel: #0e1a2a;
            --soc-panel-raised: #122238;
            --soc-border: rgba(148, 163, 184, .14);
            --soc-text: #e8eef8;
            --soc-muted: #8291a8;
            --soc-cyan: #22d3ee;
            min-height: calc(100vh - 65px);
            background:
                radial-gradient(ellipse at 12% 0%, rgba(8, 145, 178, .12), transparent 34rem),
                var(--soc-bg);
            color: var(--soc-text);
            padding: 30px 24px 48px;
        }

        .soc-container {
            width: 100%;
            max-width: 1500px;
            margin: 0 auto;
        }

        .soc-dashboard h1,
        .soc-dashboard h2,
        .soc-dashboard h3,
        .soc-dashboard strong {
            color: var(--soc-text);
        }

        .soc-dashboard p {
            color: var(--soc-muted);
        }

        .soc-header,
        .soc-heading,
        .soc-actions,
        .soc-panel-heading,
        .soc-card-top,
        .soc-module-title,
        .soc-status {
            display: flex;
            align-items: center;
        }

        .soc-header {
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 26px;
        }

        .soc-heading {
            align-items: flex-start;
            gap: 14px;
        }

        .soc-brand-mark {
            display: grid;
            width: 46px;
            height: 46px;
            flex: 0 0 46px;
            place-items: center;
            border: 1px solid rgba(34, 211, 238, .28);
            border-radius: 13px;
            background: rgba(8, 145, 178, .12);
            color: var(--soc-cyan);
        }

        .soc-eyebrow,
        .soc-kpi-label,
        .soc-table th,
        .soc-module-tag {
            color: #8ea0b8;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .13em;
            text-transform: uppercase;
        }

        .soc-title {
            margin: 4px 0 5px;
            font-size: clamp(24px, 3vw, 32px);
            font-weight: 700;
            letter-spacing: -.035em;
            line-height: 1.15;
        }

        .soc-subtitle {
            margin: 0;
            font-size: 13px;
        }

        .soc-header-meta {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
        }

        .soc-status {
            gap: 8px;
            border: 1px solid rgba(52, 211, 153, .22);
            border-radius: 999px;
            background: rgba(16, 185, 129, .1);
            color: #6ee7b7;
            padding: 7px 11px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .soc-status.is-idle {
            border-color: rgba(251, 191, 36, .22);
            background: rgba(245, 158, 11, .08);
            color: #fcd34d;
        }

        .soc-status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
            box-shadow: 0 0 10px currentColor;
        }

        .soc-date {
            font-size: 11px;
        }

        .soc-actions {
            gap: 9px;
            margin: -8px 0 22px;
        }

        .soc-button {
            display: inline-flex;
            min-height: 38px;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1px solid var(--soc-border);
            border-radius: 8px;
            background: rgba(14, 26, 42, .8);
            color: #cbd5e1 !important;
            padding: 0 13px;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            transition: border-color .18s ease, background .18s ease, transform .18s ease;
        }

        .soc-button:hover {
            transform: translateY(-1px);
            border-color: rgba(34, 211, 238, .42);
            background: #122238;
            color: white !important;
        }

        .soc-button.is-primary {
            border-color: rgba(34, 211, 238, .35);
            background: rgba(8, 145, 178, .16);
            color: #67e8f9 !important;
        }

        .soc-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 18px;
        }

        .soc-kpi {
            position: relative;
            overflow: hidden;
            min-width: 0;
            border: 1px solid var(--soc-border);
            border-radius: 12px;
            background: linear-gradient(145deg, rgba(17, 32, 51, .98), rgba(12, 24, 40, .98));
            padding: 18px;
            text-decoration: none;
            transition: transform .18s ease, border-color .18s ease;
        }

        .soc-kpi:hover {
            transform: translateY(-2px);
            border-color: rgba(34, 211, 238, .38);
        }

        .soc-card-top {
            justify-content: space-between;
            gap: 12px;
        }

        .soc-kpi-label {
            margin: 0;
        }

        .soc-kpi-icon {
            display: grid;
            width: 34px;
            height: 34px;
            place-items: center;
            border-radius: 9px;
            background: rgba(34, 211, 238, .1);
            color: var(--soc-cyan);
        }

        .soc-kpi-icon.is-violet {
            background: rgba(167, 139, 250, .12);
            color: #c4b5fd;
        }

        .soc-kpi-icon.is-rose {
            background: rgba(251, 113, 133, .1);
            color: #fda4af;
        }

        .soc-kpi-icon.is-amber {
            background: rgba(251, 191, 36, .1);
            color: #fcd34d;
        }

        .soc-kpi-value {
            margin: 13px 0 4px;
            color: #f4f8ff;
            font-size: 30px;
            font-weight: 700;
            letter-spacing: -.04em;
            line-height: 1;
        }

        .soc-kpi-foot {
            display: flex;
            align-items: center;
            gap: 7px;
            margin: 9px 0 0;
            font-size: 11px;
        }

        .soc-kpi-foot strong {
            color: #b7c4d6;
            font-weight: 600;
        }

        .soc-live-dot {
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #34d399;
        }

        .soc-main-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.8fr) minmax(280px, .9fr);
            gap: 14px;
            margin-bottom: 18px;
        }

        .soc-panel {
            min-width: 0;
            border: 1px solid var(--soc-border);
            border-radius: 12px;
            background: rgba(14, 26, 42, .92);
            padding: 19px;
        }

        .soc-panel-heading {
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 15px;
        }

        .soc-panel-title {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
        }

        .soc-panel-note {
            margin: 5px 0 0;
            font-size: 11px;
        }

        .soc-period {
            border: 1px solid var(--soc-border);
            border-radius: 6px;
            color: #a8b6c9;
            padding: 5px 8px;
            font-size: 10px;
            white-space: nowrap;
        }

        .soc-chart-wrap {
            position: relative;
            height: 250px;
        }

        .soc-chart-fallback {
            display: none;
            height: 100%;
            align-items: center;
            justify-content: center;
            color: var(--soc-muted);
            font-size: 12px;
        }

        .soc-severity-body {
            display: grid;
            grid-template-columns: minmax(130px, .9fr) minmax(130px, 1fr);
            align-items: center;
            gap: 12px;
            min-height: 220px;
        }

        .soc-severity-chart {
            position: relative;
            width: 100%;
            height: 180px;
        }

        .soc-severity-total {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .soc-severity-total strong {
            font-size: 24px;
            line-height: 1.1;
        }

        .soc-severity-total span {
            margin-top: 4px;
            color: var(--soc-muted);
            font-size: 9px;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .soc-severity-list {
            display: grid;
            gap: 13px;
        }

        .soc-severity-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 9px;
            color: #c3ccda;
            font-size: 11px;
        }

        .soc-severity-name {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .soc-severity-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        .soc-section {
            margin-bottom: 18px;
        }

        .soc-section-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            margin: 0 0 11px;
        }

        .soc-section-heading h2 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
        }

        .soc-section-heading p {
            margin: 4px 0 0;
            font-size: 11px;
        }

        .soc-text-link {
            color: #67e8f9 !important;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
        }

        .soc-text-link:hover {
            color: white !important;
        }

        .soc-table-wrap {
            overflow-x: auto;
            border: 1px solid var(--soc-border);
            border-radius: 12px;
            background: rgba(14, 26, 42, .92);
        }

        .soc-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .soc-table th {
            background: rgba(18, 34, 56, .65);
            padding: 12px 15px;
            white-space: nowrap;
        }

        .soc-table td {
            border-top: 1px solid rgba(148, 163, 184, .1);
            color: #cbd5e1;
            padding: 13px 15px;
            font-size: 11px;
            white-space: nowrap;
        }

        .soc-table tbody tr:hover {
            background: rgba(148, 163, 184, .035);
        }

        .soc-table-primary {
            color: #e7eef8;
            font-weight: 600;
        }

        .soc-table-secondary {
            display: block;
            margin-top: 3px;
            color: #77869b;
            font-size: 10px;
        }

        .soc-severity-badge {
            display: inline-flex;
            border: 1px solid transparent;
            border-radius: 999px;
            padding: 4px 8px;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .04em;
        }

        .soc-severity-badge.is-critical {
            border-color: rgba(248, 113, 113, .22);
            background: rgba(239, 68, 68, .12);
            color: #fca5a5;
        }

        .soc-severity-badge.is-high {
            border-color: rgba(251, 146, 60, .22);
            background: rgba(249, 115, 22, .12);
            color: #fdba74;
        }

        .soc-severity-badge.is-medium {
            border-color: rgba(250, 204, 21, .22);
            background: rgba(234, 179, 8, .1);
            color: #fde047;
        }

        .soc-severity-badge.is-low {
            border-color: rgba(52, 211, 153, .2);
            background: rgba(16, 185, 129, .1);
            color: #6ee7b7;
        }

        .soc-severity-badge.is-unknown {
            border-color: var(--soc-border);
            background: rgba(148, 163, 184, .08);
            color: #a8b6c9;
        }

        .soc-empty {
            padding: 34px 20px !important;
            color: var(--soc-muted) !important;
            text-align: center;
        }

        .soc-module-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .soc-module {
            display: block;
            min-width: 0;
            border: 1px solid var(--soc-border);
            border-radius: 11px;
            background: rgba(14, 26, 42, .8);
            padding: 16px;
            text-decoration: none;
            transition: transform .18s ease, border-color .18s ease, background .18s ease;
        }

        .soc-module:hover {
            transform: translateY(-2px);
            border-color: rgba(34, 211, 238, .34);
            background: #102037;
        }

        .soc-module-title {
            justify-content: space-between;
            gap: 10px;
        }

        .soc-module-title h3 {
            margin: 0;
            font-size: 12px;
            font-weight: 700;
        }

        .soc-module-tag {
            color: #6e819b;
            font-size: 9px;
        }

        .soc-module p {
            margin: 8px 0 0;
            font-size: 10px;
            line-height: 1.5;
        }

        .soc-module-count {
            display: block;
            margin-top: 13px;
            color: #a5f3fc;
            font-size: 11px;
            font-weight: 700;
        }

        .soc-footer {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            border-top: 1px solid var(--soc-border);
            margin-top: 24px;
            padding-top: 14px;
            color: #62728a;
            font-size: 9px;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        @media (max-width: 1050px) {
            .soc-main-grid {
                grid-template-columns: minmax(0, 1.4fr) minmax(270px, 1fr);
            }

            .soc-severity-body {
                grid-template-columns: 1fr;
                gap: 2px;
            }

            .soc-severity-chart {
                max-width: 180px;
                margin: 0 auto;
            }

            .soc-severity-list {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }
        }

        @media (max-width: 760px) {
            .soc-dashboard {
                padding: 24px 16px 36px;
            }

            .soc-header {
                align-items: flex-start;
            }

            .soc-header-meta {
                align-items: flex-end;
            }

            .soc-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .soc-main-grid {
                grid-template-columns: 1fr;
            }

            .soc-severity-body {
                grid-template-columns: minmax(130px, .8fr) minmax(160px, 1fr);
                gap: 12px;
            }

            .soc-module-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 480px) {
            .soc-dashboard {
                padding: 20px 12px 30px;
            }

            .soc-header {
                flex-direction: column;
                gap: 14px;
            }

            .soc-header-meta {
                width: 100%;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }

            .soc-actions {
                flex-wrap: wrap;
            }

            .soc-button {
                flex: 1;
                padding: 0 9px;
            }

            .soc-kpi {
                padding: 14px;
            }

            .soc-kpi-value {
                font-size: 26px;
            }

            .soc-panel {
                padding: 15px;
            }

            .soc-chart-wrap {
                height: 210px;
            }

            .soc-severity-body {
                grid-template-columns: minmax(110px, .8fr) minmax(130px, 1fr);
            }

            .soc-module-grid {
                grid-template-columns: 1fr;
            }

            .soc-section-heading {
                align-items: flex-start;
            }

            .soc-footer {
                flex-direction: column;
            }
        }
    </style>

    @php
        $severityOrder = ['CRITICAL', 'HIGH', 'MEDIUM', 'LOW'];
        $severityColors = [
            'CRITICAL' => '#f87171',
            'HIGH' => '#fb923c',
            'MEDIUM' => '#facc15',
            'LOW' => '#34d399',
        ];
        $severityTotal = (int) $severityCounts->sum();
        $severityValues = array_map(
            fn ($severity) => (int) $severityCounts->get($severity, 0),
            $severityOrder
        );
    @endphp

    <div class="soc-dashboard">
        <div class="soc-container">
            <header class="soc-header">
                <div class="soc-heading">
                    <div class="soc-brand-mark" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="23" height="23" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path d="M12 3 19 6v5c0 4.7-2.9 8.2-7 10-4.1-1.8-7-5.3-7-10V6l7-3Z" />
                            <path d="m9 12 2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <div class="soc-eyebrow">DecoyGuard / Security Center</div>
                        <h1 class="soc-title">Security Operations Center</h1>
                        <p class="soc-subtitle">A clear view of your monitored environment and recent threats.</p>
                    </div>
                </div>

                <div class="soc-header-meta">
                    <span class="soc-status {{ $onlineHosts === 0 ? 'is-idle' : '' }}">
                        <span class="soc-status-dot"></span>
                        {{ $onlineHosts > 0 ? 'Monitoring active' : 'No endpoints online' }}
                    </span>
                    <span class="soc-date">{{ now()->format('l, M j, Y') }}</span>
                </div>
            </header>

            <div class="soc-actions" aria-label="Quick actions">
                <a class="soc-button is-primary" href="{{ route('monitored-hosts.create') }}">
                    <span aria-hidden="true">＋</span> Register endpoint
                </a>
                <a class="soc-button" href="{{ route('decoy-folders.create') }}">
                    <span aria-hidden="true">＋</span> Create decoy folder
                </a>
                <a class="soc-button" href="{{ route('alerts.index') }}">Review alerts <span aria-hidden="true">→</span></a>
            </div>

            <section class="soc-kpi-grid" aria-label="Security metrics">
                <a class="soc-kpi" href="{{ route('monitored-hosts.index') }}">
                    <div class="soc-card-top">
                        <p class="soc-kpi-label">Monitored endpoints</p>
                        <span class="soc-kpi-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.7">
                                <rect x="3" y="4" width="18" height="13" rx="2" />
                                <path d="M8 21h8m-4-4v4" />
                            </svg>
                        </span>
                    </div>
                    <div class="soc-kpi-value">{{ number_format($onlineHosts) }} <span style="color:#72829a;font-size:16px;font-weight:500">/ {{ number_format($totalHosts) }}</span></div>
                    <p class="soc-kpi-foot"><span class="soc-live-dot"></span><strong>Online</strong><span>of {{ number_format($totalHosts) }} registered</span></p>
                </a>

                <a class="soc-kpi" href="{{ route('decoy-folders.index') }}">
                    <div class="soc-card-top">
                        <p class="soc-kpi-label">Active decoy folders</p>
                        <span class="soc-kpi-icon is-violet" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z" />
                            </svg>
                        </span>
                    </div>
                    <div class="soc-kpi-value">{{ number_format($totalFolders) }}</div>
                    <p class="soc-kpi-foot"><strong>{{ number_format($totalAssets) }} active assets</strong><span>deployed</span></p>
                </a>

                <a class="soc-kpi" href="{{ route('detection-events.index') }}">
                    <div class="soc-card-top">
                        <p class="soc-kpi-label">Detection events</p>
                        <span class="soc-kpi-icon is-rose" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M3 12h4l3-8 4 16 3-8h4" />
                            </svg>
                        </span>
                    </div>
                    <div class="soc-kpi-value">{{ number_format($totalEvents) }}</div>
                    <p class="soc-kpi-foot"><strong>{{ number_format($eventsLast24Hours) }}</strong><span>in the last 24 hours</span></p>
                </a>

                <a class="soc-kpi" href="{{ route('alerts.index', ['status' => 'NEW']) }}">
                    <div class="soc-card-top">
                        <p class="soc-kpi-label">New alerts</p>
                        <span class="soc-kpi-icon is-amber" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                                <path d="M10 21h4" />
                            </svg>
                        </span>
                    </div>
                    <div class="soc-kpi-value">{{ number_format($newAlerts) }}</div>
                    <p class="soc-kpi-foot"><strong>Awaiting triage</strong><span>review required</span></p>
                </a>
            </section>

            <section class="soc-main-grid" aria-label="Detection analytics">
                <div class="soc-panel">
                    <div class="soc-panel-heading">
                        <div>
                            <h2 class="soc-panel-title">Detection activity</h2>
                            <p class="soc-panel-note">Event volume across the last seven days</p>
                        </div>
                        <span class="soc-period">LAST 7 DAYS</span>
                    </div>
                    <div class="soc-chart-wrap">
                        <canvas id="activityChart" aria-label="Detection events during the last seven days"></canvas>
                        <div id="activityFallback" class="soc-chart-fallback">Chart unavailable. Recent detections are listed below.</div>
                    </div>
                </div>

                <div class="soc-panel">
                    <div class="soc-panel-heading">
                        <div>
                            <h2 class="soc-panel-title">Severity overview</h2>
                            <p class="soc-panel-note">All recorded detection events</p>
                        </div>
                        <span class="soc-period">{{ number_format($severityTotal) }} TOTAL</span>
                    </div>
                    <div class="soc-severity-body">
                        <div class="soc-severity-chart">
                            <canvas id="severityChart" aria-label="Detection event severity breakdown"></canvas>
                            <div class="soc-severity-total">
                                <strong>{{ number_format($severityTotal) }}</strong>
                                <span>events</span>
                            </div>
                        </div>
                        <div class="soc-severity-list">
                            @foreach ($severityOrder as $severity)
                                <div class="soc-severity-row">
                                    <span class="soc-severity-name">
                                        <span class="soc-severity-dot" style="background: {{ $severityColors[$severity] }}"></span>
                                        {{ $severity }}
                                    </span>
                                    <strong>{{ number_format((int) $severityCounts->get($severity, 0)) }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section class="soc-section">
                <div class="soc-section-heading">
                    <div>
                        <h2>Recent detection events</h2>
                        <p>Latest activity reported by your monitored endpoints.</p>
                    </div>
                    <a class="soc-text-link" href="{{ route('detection-events.index') }}">View all events <span aria-hidden="true">→</span></a>
                </div>

                <div class="soc-table-wrap">
                    <table class="soc-table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Endpoint</th>
                                <th>Detection</th>
                                <th>Actor / source</th>
                                <th>Severity</th>
                                <th><span class="sr-only">Details</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentEvents as $event)
                                @php
                                    $severity = strtoupper($event->severity ?? '');
                                    $severityClass = in_array($severity, $severityOrder, true)
                                        ? strtolower($severity)
                                        : 'unknown';
                                @endphp
                                <tr>
                                    <td>{{ \Illuminate\Support\Carbon::parse($event->occurred_at)->format('M j, H:i:s') }}</td>
                                    <td>
                                        <span class="soc-table-primary">{{ $event->host_name ?? 'Unknown endpoint' }}</span>
                                    </td>
                                    <td>
                                        <span class="soc-table-primary">{{ $event->event_type }}</span>
                                        <span class="soc-table-secondary">{{ $event->file_name ?? $event->folder_name ?? 'Decoy resource' }}</span>
                                    </td>
                                    <td>
                                        <span class="soc-table-primary">{{ $event->actor_username ?? 'Unknown user' }}</span>
                                        <span class="soc-table-secondary">{{ $event->source_ip ?? $event->process_name ?? 'Source unavailable' }}</span>
                                    </td>
                                    <td><span class="soc-severity-badge is-{{ $severityClass }}">{{ $severity ?: 'UNKNOWN' }}</span></td>
                                    <td><a class="soc-text-link" href="{{ route('detection-events.show', $event->id) }}">Details <span aria-hidden="true">→</span></a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="soc-empty" colspan="6">
                                        No detections recorded yet. Events will appear here when an endpoint interacts with a decoy.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="soc-section">
                <div class="soc-section-heading">
                    <div>
                        <h2>Security modules</h2>
                        <p>Access and manage every part of your monitoring environment.</p>
                    </div>
                </div>

                <div class="soc-module-grid">
                    <a class="soc-module" href="{{ route('monitored-hosts.index') }}">
                        <div class="soc-module-title"><h3>Monitored endpoints</h3><span class="soc-module-tag">01 / HOSTS</span></div>
                        <p>Register devices, check agent status, and rotate agent tokens.</p>
                        <span class="soc-module-count">{{ number_format($onlineHosts) }} online · {{ number_format($totalHosts) }} registered</span>
                    </a>
                    <a class="soc-module" href="{{ route('decoy-folders.index') }}">
                        <div class="soc-module-title"><h3>Decoy folders</h3><span class="soc-module-tag">02 / DECOY</span></div>
                        <p>Configure monitored decoy directories for each endpoint.</p>
                        <span class="soc-module-count">{{ number_format($totalFolders) }} active folders</span>
                    </a>
                    <a class="soc-module" href="{{ route('decoy-folders.index') }}">
                        <div class="soc-module-title"><h3>Decoy assets</h3><span class="soc-module-tag">03 / ASSETS</span></div>
                        <p>Manage decoy files from their assigned folder.</p>
                        <span class="soc-module-count">{{ number_format($totalAssets) }} active assets</span>
                    </a>
                    <a class="soc-module" href="{{ route('detection-events.index') }}">
                        <div class="soc-module-title"><h3>Detection events</h3><span class="soc-module-tag">04 / EVENTS</span></div>
                        <p>Search, filter, and investigate endpoint activity.</p>
                        <span class="soc-module-count">{{ number_format($totalEvents) }} recorded events</span>
                    </a>
                    <a class="soc-module" href="{{ route('alerts.index') }}">
                        <div class="soc-module-title"><h3>Security alerts</h3><span class="soc-module-tag">05 / TRIAGE</span></div>
                        <p>Review, acknowledge, and resolve security alerts.</p>
                        <span class="soc-module-count">{{ number_format($newAlerts) }} awaiting review</span>
                    </a>
                    <a class="soc-module" href="{{ route('profile.edit') }}">
                        <div class="soc-module-title"><h3>Account &amp; access</h3><span class="soc-module-tag">06 / PROFILE</span></div>
                        <p>Update your account profile and security credentials.</p>
                        <span class="soc-module-count">Signed in as {{ Auth::user()->name }}</span>
                    </a>
                </div>
            </section>

            <footer class="soc-footer">
                <span>DecoyGuard · Security monitoring platform</span>
                <span>{{ now()->format('Y') }} · Monitoring overview</span>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (!window.Chart) {
                document.getElementById('activityFallback').style.display = 'flex';
                return;
            }

            const activityLabels = @json($activity->pluck('label')->values());
            const activityValues = @json($activity->pluck('total')->values());
            const activityDates = @json($activity->pluck('date')->values());
            const severityLabels = @json($severityOrder);
            const severityValues = @json($severityValues);
            const severityColors = @json(array_values($severityColors));

            Chart.defaults.color = '#8291a8';
            Chart.defaults.font.family = 'Figtree, Arial, sans-serif';

            new Chart(document.getElementById('activityChart'), {
                type: 'line',
                data: {
                    labels: activityLabels,
                    datasets: [{
                        label: 'Detections',
                        data: activityValues,
                        borderColor: '#22d3ee',
                        backgroundColor: 'rgba(34, 211, 238, .12)',
                        pointBackgroundColor: '#67e8f9',
                        pointBorderColor: '#0e1a2a',
                        pointBorderWidth: 3,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        borderWidth: 2,
                        fill: true,
                        tension: .35
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#07111f',
                            borderColor: 'rgba(148, 163, 184, .2)',
                            borderWidth: 1,
                            callbacks: {
                                title: function (items) { return activityDates[items[0].dataIndex]; }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { color: '#8291a8', maxRotation: 0 }
                        },
                        y: {
                            beginAtZero: true,
                            grace: '10%',
                            border: { display: false },
                            grid: { color: 'rgba(148, 163, 184, .1)' },
                            ticks: { precision: 0, color: '#718198' }
                        }
                    }
                }
            });

            new Chart(document.getElementById('severityChart'), {
                type: 'doughnut',
                data: {
                    labels: severityLabels,
                    datasets: [{
                        data: severityValues,
                        backgroundColor: severityColors,
                        borderColor: '#0e1a2a',
                        borderWidth: 4,
                        hoverOffset: 4
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: '76%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#07111f',
                            borderColor: 'rgba(148, 163, 184, .2)',
                            borderWidth: 1
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
