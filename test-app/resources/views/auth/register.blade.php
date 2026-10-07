<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        *, ::after, ::before {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
        :root {
            --bg-page: #FDFDFC;
            --bg-card: #FFFFFF;
            --border-card: rgba(26, 26, 0, 0.16);
            --border-input: #e3e3e0;
            --text-main: #1b1b18;
            --text-muted: #706f6c;
            --laravel-red: #FF2D20;
            --laravel-red-hover: #e02417;
            --laravel-red-light: rgba(255, 45, 32, 0.08);
            --laravel-red-border: rgba(255, 45, 32, 0.25);
            --card-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05);
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --bg-page: #0a0a0a;
                --bg-card: #161615;
                --border-card: rgba(255, 250, 237, 0.15);
                --border-input: #3E3E3A;
                --text-main: #EDEDEC;
                --text-muted: #A1A09A;
                --laravel-red: #FF2D20;
                --laravel-red-hover: #ff453a;
                --laravel-red-light: rgba(255, 45, 32, 0.12);
                --laravel-red-border: rgba(255, 45, 32, 0.35);
                --card-shadow: 0px 4px 20px 0px rgba(0, 0, 0, 0.5);
            }
        }
        body {
            background-color: var(--bg-page);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .container {
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .logo-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            text-decoration: none;
        }
        .laravel-logo {
            width: 54px;
            height: 54px;
            color: var(--laravel-red);
        }
        .card {
            width: 100%;
            background-color: var(--bg-card);
            border: 1px solid var(--border-card);
            border-radius: 12px;
            padding: 2.25rem 2rem;
            box-shadow: var(--card-shadow);
        }
        .header {
            margin-bottom: 1.75rem;
        }
        .header h1 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-main);
            letter-spacing: -0.02em;
            margin-bottom: 0.35rem;
        }
        .header p {
            font-size: 0.875rem;
            color: var(--text-muted);
            line-height: 1.4;
        }
        .form-group {
            margin-bottom: 1.15rem;
        }
        label {
            display: block;
            font-size: 0.825rem;
            font-weight: 500;
            color: var(--text-main);
            margin-bottom: 0.4rem;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.65rem 0.85rem;
            background-color: transparent;
            border: 1px solid var(--border-input);
            border-radius: 6px;
            color: var(--text-main);
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        input:focus {
            border-color: var(--laravel-red);
            box-shadow: 0 0 0 3px var(--laravel-red-light);
        }
        .btn-primary {
            width: 100%;
            padding: 0.7rem;
            background-color: var(--laravel-red);
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: background-color 0.15s ease, transform 0.05s ease;
        }
        .btn-primary:hover {
            background-color: var(--laravel-red-hover);
        }
        .btn-primary:active {
            transform: scale(0.99);
        }
        .alert-error {
            background-color: var(--laravel-red-light);
            border: 1px solid var(--laravel-red-border);
            color: var(--laravel-red);
            border-radius: 6px;
            padding: 0.65rem 0.85rem;
            font-size: 0.825rem;
            margin-bottom: 1.25rem;
            line-height: 1.4;
        }
        .footer-link {
            text-align: center;
            font-size: 0.825rem;
            color: var(--text-muted);
            margin-top: 1.5rem;
        }
        .footer-link a {
            color: var(--text-main);
            text-decoration: underline;
            text-underline-offset: 3px;
            font-weight: 500;
        }
        .footer-link a:hover {
            color: var(--laravel-red);
        }
        .badge-brand {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            margin-top: 1rem;
            font-size: 0.725rem;
            color: var(--text-muted);
        }
        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: var(--laravel-red);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Laravel Official Logo Mark -->
        <a href="/" class="logo-wrap" title="Laravel">
            <svg class="laravel-logo" viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M61.8548 14.6253C61.8778 14.7102 61.8895 14.7979 61.8895 14.8858V28.5615C61.8895 28.7607 61.7779 28.9431 61.5997 29.0347L48.2127 35.9189C48.0315 36.0121 47.8139 36.0097 47.635 35.9126L34.5074 28.7891C34.3359 28.6961 34.2299 28.5173 34.2299 28.3225V14.8858C34.2299 14.6866 34.3415 14.5042 34.5197 14.4126L47.9067 7.52844C48.0879 7.43521 48.3055 7.43764 48.4844 7.53472L61.612 14.6582C61.7138 14.7134 61.7966 14.7968 61.8548 14.8988V14.6253Z" fill="currentColor"/>
                <path d="M28.0905 32.3276C28.1135 32.4125 28.1252 32.5002 28.1252 32.5881V46.2638C28.1252 46.463 28.0136 46.6454 27.8354 46.737L14.4484 53.6212C14.2672 53.7144 14.0496 53.712 13.8707 53.6149L0.743126 46.4914C0.571618 46.3984 0.465576 46.2196 0.465576 46.0248V32.5881C0.465576 32.3889 0.577218 32.2065 0.755428 32.1149L14.1424 25.2307C14.3236 25.1375 14.5412 25.1399 14.7201 25.237L27.8477 32.3605C27.9495 32.4157 28.0323 32.4991 28.0905 32.6011V32.3276Z" fill="currentColor"/>
                <path d="M44.9727 49.9575C44.9957 50.0424 45.0074 50.1301 45.0074 50.218V63.8937C45.0074 64.0929 44.8958 64.2753 44.7176 64.3669L31.3306 71.2511C31.1494 71.3443 30.9318 71.3419 30.7529 71.2448L17.6253 64.1213C17.4538 64.0283 17.3478 63.8495 17.3478 63.6547V50.218C17.3478 50.0188 17.4594 49.8364 17.6376 49.7448L31.0246 42.8606C31.2058 42.7674 31.4234 42.7698 31.6023 42.8669L44.7299 49.9904C44.8317 50.0456 44.9145 50.129 44.9727 50.231V49.9575Z" fill="currentColor"/>
            </svg>
        </a>

        <div class="card">
            <div class="header">
                <h1>Create an account</h1>
                <p>Register a new account to get started.</p>
            </div>

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
                    <label for="name">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        placeholder="Your name"
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
                        placeholder="you@example.com"
                    />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        placeholder="••••••••"
                    />
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        placeholder="••••••••"
                    />
                </div>

                <button type="submit" class="btn-primary">
                    Register
                </button>
            </form>

            <p class="footer-link">
                Already have an account?
                <a href="{{ route('login') }}">Log in</a>
            </p>
        </div>

        <div class="badge-brand">
            <span class="badge-dot"></span>
            Connected with Supabase
        </div>
    </div>
</body>
</html>
