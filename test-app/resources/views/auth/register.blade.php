<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account - {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Instrument Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        body {
            background-color: #0d1117;
            color: #e6edf3;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }
        .bg-glow {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            height: 350px;
            background: radial-gradient(circle, rgba(62, 207, 142, 0.15) 0%, rgba(13, 17, 23, 0) 70%);
            filter: blur(50px);
            pointer-events: none;
            z-index: 0;
        }
        .card {
            width: 100%;
            max-width: 420px;
            background: #161b22;
            border: 1px solid rgba(240, 246, 252, 0.1);
            border-radius: 14px;
            padding: 2.25rem 2rem;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.45);
            position: relative;
            z-index: 1;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 1.75rem;
        }
        .supabase-icon {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #3ecf8e;
        }
        .brand h1 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #ffffff;
            letter-spacing: -0.01em;
        }
        .badge {
            margin-left: auto;
            font-size: 0.72rem;
            background: rgba(62, 207, 142, 0.12);
            color: #3ecf8e;
            padding: 0.2rem 0.55rem;
            border-radius: 9999px;
            border: 1px solid rgba(62, 207, 142, 0.25);
            font-weight: 500;
        }
        .subtitle {
            font-size: 0.9rem;
            color: #8b949e;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1.15rem;
        }
        label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: #c9d1d9;
            margin-bottom: 0.4rem;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.7rem 0.85rem;
            background: #0d1117;
            border: 1px solid rgba(240, 246, 252, 0.15);
            border-radius: 8px;
            color: #ffffff;
            font-size: 0.92rem;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        input:focus {
            border-color: #3ecf8e;
            box-shadow: 0 0 0 3px rgba(62, 207, 142, 0.18);
        }
        .btn-submit {
            width: 100%;
            padding: 0.75rem;
            background: #3ecf8e;
            color: #0d1117;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: background 0.15s ease, transform 0.05s ease;
        }
        .btn-submit:hover {
            background: #34b27b;
        }
        .alert-error {
            background: rgba(248, 81, 73, 0.1);
            border: 1px solid rgba(248, 81, 73, 0.3);
            color: #f85149;
            border-radius: 8px;
            padding: 0.7rem 0.85rem;
            font-size: 0.84rem;
            margin-bottom: 1.25rem;
        }
        .footer-text {
            text-align: center;
            font-size: 0.83rem;
            color: #8b949e;
            margin-top: 1.5rem;
        }
        .footer-text a {
            color: #3ecf8e;
            text-decoration: none;
            font-weight: 500;
        }
        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>
    <div class="card">
        <div class="brand">
            <svg class="supabase-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M21.362 9.354H12V.348a.348.348 0 0 0-.616-.224L1.758 13.067a.784.784 0 0 0 .616 1.306H11.64v9.006a.348.348 0 0 0 .616.224l9.626-12.943a.784.784 0 0 0-.52-1.306Z"/>
            </svg>
            <h1>{{ config('app.name', 'Laravel') }}</h1>
            <span class="badge">Supabase DB</span>
        </div>

        <p class="subtitle">Create a new user account</p>

        @if ($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    placeholder="John Doe"
                />
            </div>

            <div class="form-group">
                <label for="email">Email address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    placeholder="name@example.com"
                />
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    placeholder="Minimum 8 characters"
                />
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    placeholder="Repeat password"
                />
            </div>

            <button type="submit" class="btn-submit">
                Register
            </button>
        </form>

        <p class="footer-text">
            Already have an account?
            <a href="{{ route('login') }}">Log in</a>
        </p>
    </div>
</body>
</html>
