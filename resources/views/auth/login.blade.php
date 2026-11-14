
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | DecoyGuard</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: #080d18;
            color: #e5edf8;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
            position: relative;
            overflow: hidden;
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
            width: 400px;
            height: 400px;
            background: rgba(0, 153, 255, .13);
            filter: blur(120px);
            border-radius: 50%;
            pointer-events: none;
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 32px;
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -.7px;
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: linear-gradient(135deg, #0878d1, #14b8a6);
            box-shadow: 0 0 25px rgba(0, 153, 255, .25);
            font-size: 23px;
        }

        .brand span {
            color: #38bdf8;
        }

        .login-card {
            background: linear-gradient(145deg, #111d30, #0b1322);
            border: 1px solid rgba(56, 189, 248, .2);
            border-radius: 17px;
            padding: 38px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, .4);
        }

        .heading {
            text-align: center;
            margin-bottom: 30px;
        }

        .heading .label {
            display: inline-block;
            color: #38bdf8;
            background: rgba(8, 120, 209, .1);
            border: 1px solid rgba(56, 189, 248, .2);
            border-radius: 30px;
            padding: 7px 12px;
            font-size: 10px;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 17px;
        }

        .heading h1 {
            font-size: 25px;
            margin-bottom: 10px;
        }

        .heading p {
            color: #8495aa;
            font-size: 12px;
            line-height: 1.7;
        }

        .form-group {
            margin-bottom: 21px;
        }

        .form-group label {
            display: block;
            color: #cbd5e1;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 9px;
        }

        .form-control {
            width: 100%;
            padding: 13px 14px;
            background: #080f1d;
            border: 1px solid #2b3d54;
            border-radius: 8px;
            color: #e5edf8;
            font-family: inherit;
            font-size: 13px;
            outline: none;
            transition: .2s;
        }

        .form-control:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, .1);
        }

        .form-control::placeholder {
            color: #52647b;
        }

        .error {
            color: #fca5a5;
            font-size: 11px;
            margin-top: 7px;
        }

        .session-status {
            color: #86efac;
            background: rgba(34, 197, 94, .1);
            border: 1px solid rgba(34, 197, 94, .2);
            border-radius: 7px;
            padding: 11px;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin: 5px 0 25px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #94a3b8;
            font-size: 11px;
            cursor: pointer;
        }

        .remember input {
            accent-color: #0ea5e9;
            width: 14px;
            height: 14px;
        }

        .forgot {
            color: #38bdf8;
            text-decoration: none;
            font-size: 11px;
        }

        .forgot:hover {
            color: #7dd3fc;
        }

        .login-button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(90deg, #0878d1, #0891b2);
            color: white;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .login-button:hover {
            box-shadow: 0 0 25px rgba(8, 145, 178, .3);
            transform: translateY(-1px);
        }

        .security-note {
            text-align: center;
            margin-top: 25px;
            color: #64748b;
            font-size: 10px;
        }

        .security-note span {
            color: #4ade80;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 12px;
        }

        .back-link:hover {
            color: #38bdf8;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 27px 22px;
            }
        }
    </style>
</head>

<body>
    <div class="glow"></div>

    <main class="login-container">

        <div class="brand">
            <div class="brand-icon">⌑</div>
            DECOY<span>GUARD</span>
        </div>

        <section class="login-card">

            <div class="heading">
                <div class="label">SECURE ACCESS PORTAL</div>
                <h1>Welcome Back</h1>
                <p>Sign in to access the DecoyGuard security monitoring platform.</p>
            </div>

            @if (session('status'))
                <div class="session-status">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>

                    <input
                        id="email"
                        class="form-control"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email address"
                        required
                        autofocus
                        autocomplete="username"
                    >

                    @if ($errors->get('email'))
                        <div class="error">
                            @foreach ($errors->get('email') as $message)
                                <div>{{ $message }}</div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">Password</label>

                    <input
                        id="password"
                        class="form-control"
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                    >

                    @if ($errors->get('password'))
                        <div class="error">
                            @foreach ($errors->get('password') as $message)
                                <div>{{ $message }}</div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="remember-row">
                    <label class="remember" for="remember_me">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                        >
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a class="forgot" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="login-button">
                    SIGN IN TO DECOYGUARD →
                </button>
            </form>

            <div class="security-note">
                <span>●</span> Secure Authentication Portal
            </div>

        </section>

        <a href="{{ url('/') }}" class="back-link">
            ← Back to Home
        </a>

    </main>
</body>
</html>
