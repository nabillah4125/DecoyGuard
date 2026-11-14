
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DecoyGuard | Cybersecurity Monitoring</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #080d18;
            color: #e5edf8;
            min-height: 100vh;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(40, 120, 180, .045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(40, 120, 180, .045) 1px, transparent 1px);
            background-size: 42px 42px;
            pointer-events: none;
        }

        .glow {
            position: fixed;
            width: 420px;
            height: 420px;
            background: rgba(0, 153, 255, .12);
            filter: blur(120px);
            border-radius: 50%;
            top: 15%;
            left: 35%;
            pointer-events: none;
        }

        .container {
            position: relative;
            z-index: 1;
            width: min(1120px, 90%);
            margin: auto;
        }

        nav {
            height: 88px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(148, 163, 184, .13);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .brand-icon {
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            border-radius: 11px;
            background: linear-gradient(135deg, #0878d1, #14b8a6);
            box-shadow: 0 0 25px rgba(0, 153, 255, .25);
            font-size: 20px;
        }

        .brand span {
            color: #38bdf8;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .status {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #94a3b8;
            font-size: 12px;
            font-family: 'JetBrains Mono', monospace;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 10px #22c55e;
        }

        .nav-button {
            text-decoration: none;
            color: white;
            background: #0878d1;
            padding: 11px 19px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            transition: .2s;
        }

        .nav-button:hover {
            background: #0b91f5;
            box-shadow: 0 0 20px rgba(8, 120, 209, .3);
        }

        .hero {
            min-height: 590px;
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            align-items: center;
            gap: 55px;
            padding: 65px 0;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, .25);
            background: rgba(8, 120, 209, .09);
            border-radius: 30px;
            padding: 8px 13px;
            font-size: 11px;
            font-family: 'JetBrains Mono', monospace;
            margin-bottom: 25px;
        }

        .hero h1 {
            font-size: clamp(42px, 5vw, 65px);
            line-height: 1.1;
            letter-spacing: -2.5px;
            margin-bottom: 22px;
        }

        .hero h1 span {
            color: #38bdf8;
        }

        .hero p {
            color: #94a3b8;
            line-height: 1.9;
            font-size: 15px;
            max-width: 530px;
            margin-bottom: 32px;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .primary {
            background: #0878d1;
            color: white;
            text-decoration: none;
            padding: 14px 23px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
        }

        .secondary {
            border: 1px solid #334155;
            color: #cbd5e1;
            text-decoration: none;
            padding: 14px 23px;
            border-radius: 8px;
            font-size: 13px;
        }

        .visual {
            border: 1px solid rgba(56, 189, 248, .2);
            background: linear-gradient(145deg, #111d30, #0b1322);
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 20px 70px rgba(0, 0, 0, .35);
        }

        .visual-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 17px;
            border-bottom: 1px solid #26364c;
            font-size: 12px;
            font-weight: 600;
        }

        .live {
            color: #4ade80;
            font-size: 10px;
            font-family: 'JetBrains Mono', monospace;
        }

        .monitor {
            margin-top: 20px;
            border: 1px solid #26364c;
            background: #0a1220;
            border-radius: 11px;
            padding: 17px;
        }

        .monitor-label {
            color: #64748b;
            font-size: 10px;
            font-family: 'JetBrains Mono', monospace;
            margin-bottom: 12px;
        }

        .event {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(51, 65, 85, .5);
            font-size: 11px;
        }

        .event:last-child {
            border: none;
        }

        .event-name {
            color: #cbd5e1;
        }

        .event-time {
            color: #64748b;
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
        }

        .tag {
            color: #fca5a5;
            background: rgba(239, 68, 68, .12);
            border: 1px solid rgba(239, 68, 68, .2);
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 9px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            padding: 25px 0 70px;
        }

        .feature {
            border: 1px solid #1e3047;
            background: rgba(17, 29, 48, .65);
            border-radius: 12px;
            padding: 22px;
        }

        .feature-icon {
            color: #38bdf8;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .feature h3 {
            font-size: 14px;
            margin-bottom: 9px;
        }

        .feature p {
            color: #8495aa;
            font-size: 12px;
            line-height: 1.7;
        }

        footer {
            border-top: 1px solid rgba(148, 163, 184, .13);
            padding: 23px 0;
            color: #64748b;
            font-size: 11px;
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        @media (max-width: 760px) {
            .hero {
                grid-template-columns: 1fr;
                gap: 35px;
                padding: 55px 0;
            }

            .features {
                grid-template-columns: 1fr;
            }

            .status {
                display: none;
            }

            .hero h1 {
                letter-spacing: -1.5px;
            }

            footer {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="glow"></div>

    <div class="container">
        <nav>
            <div class="brand">
                <div class="brand-icon">⌑</div>
                DECOY<span>GUARD</span>
            </div>

            <div class="nav-right">
                <div class="status">
                    <span class="status-dot"></span>
                    SECURITY MONITORING
                </div>

                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-button">
                        Open Dashboard →
                    </a>
                @else
                    <a href="{{ route('login') }}" class="nav-button">
                        Sign In →
                    </a>
                @endauth
            </div>
        </nav>

        <main class="hero">
            <div>
                <div class="eyebrow">
                    <span class="status-dot"></span>
                    DECEPTION-BASED SECURITY SYSTEM
                </div>

                <h1>
                    Detect Threats.<br>
                    <span>Protect Assets.</span>
                </h1>

                <p>
                    DecoyGuard is a deception-based security monitoring
                    platform designed to detect suspicious access through
                    decoy files and provide real-time security alerts.
                </p>

                <div class="actions">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="primary">
                            Go to Dashboard →
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="primary">
                            Access System →
                        </a>
                    @endauth

                    <a href="#features" class="secondary">
                        Explore Features
                    </a>
                </div>
            </div>

            <div class="visual">
                <div class="visual-header">
                    <span>DETECTION OVERVIEW</span>
                    <span class="live">● SYSTEM READY</span>
                </div>

                <div class="monitor">
                    <div class="monitor-label">MONITORING ACTIVITY</div>

                    <div class="event">
                        <span class="event-name">Host Monitoring</span>
                        <span class="live">ACTIVE</span>
                    </div>

                    <div class="event">
                        <span class="event-name">Decoy File Access</span>
                        <span class="tag">DETECTED</span>
                    </div>

                    <div class="event">
                        <span class="event-name">Event Collection</span>
                        <span class="live">ENABLED</span>
                    </div>

                    <div class="event">
                        <span class="event-name">Alert Management</span>
                        <span class="live">READY</span>
                    </div>
                </div>

                <div class="monitor">
                    <div class="monitor-label">SECURITY EVENT</div>
                    <div style="font-family:'JetBrains Mono';font-size:11px;color:#38bdf8;line-height:2">
                        &gt; Decoy access detected<br>
                        &gt; Event type: READ<br>
                        &gt; Severity: HIGH<br>
                        &gt; Alert status: NEW
                    </div>
                </div>
            </div>
        </main>

        <section class="features" id="features">
            <div class="feature">
                <div class="feature-icon">◈</div>
                <h3>Host Monitoring</h3>
                <p>Monitor registered devices and track agent connectivity.</p>
            </div>

            <div class="feature">
                <div class="feature-icon">⌕</div>
                <h3>Decoy Detection</h3>
                <p>Identify access to monitored decoy files through endpoint events.</p>
            </div>

            <div class="feature">
                <div class="feature-icon">⚑</div>
                <h3>Security Alerts</h3>
                <p>Review detected activities and manage incident alert status.</p>
            </div>
        </section>

        <footer>
            <span>© {{ date('Y') }} DecoyGuard. Cybersecurity Monitoring Platform.</span>
            <span>DECEPTION • DETECTION • RESPONSE</span>
        </footer>
    </div>
</body>
</html>
