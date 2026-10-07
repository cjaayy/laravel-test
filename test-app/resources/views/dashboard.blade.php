<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - {{ config('app.name', 'Laravel') }}</title>
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
            padding: 2rem 1.5rem;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(240, 246, 252, 0.1);
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .supabase-icon {
            width: 26px;
            height: 26px;
            color: #3ecf8e;
        }
        .brand h1 {
            font-size: 1.25rem;
            font-weight: 600;
        }
        .btn-logout {
            background: rgba(248, 81, 73, 0.12);
            color: #f85149;
            border: 1px solid rgba(248, 81, 73, 0.25);
            padding: 0.45rem 0.9rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s ease;
        }
        .btn-logout:hover {
            background: rgba(248, 81, 73, 0.22);
        }
        .card {
            background: #161b22;
            border: 1px solid rgba(240, 246, 252, 0.1);
            border-radius: 12px;
            padding: 1.75rem;
            margin-bottom: 1.5rem;
        }
        .card h2 {
            font-size: 1.15rem;
            margin-bottom: 0.5rem;
            color: #ffffff;
        }
        .card p {
            color: #8b949e;
            font-size: 0.92rem;
            line-height: 1.5;
        }
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-top: 1rem;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            background: rgba(62, 207, 142, 0.1);
            border: 1px solid rgba(62, 207, 142, 0.25);
            color: #3ecf8e;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #3ecf8e;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-top: 1.25rem;
        }
        .info-item {
            background: #0d1117;
            border: 1px solid rgba(240, 246, 252, 0.08);
            border-radius: 8px;
            padding: 0.85rem 1rem;
        }
        .info-label {
            font-size: 0.75rem;
            color: #8b949e;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }
        .info-val {
            font-size: 0.95rem;
            color: #e6edf3;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="brand">
                <svg class="supabase-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21.362 9.354H12V.348a.348.348 0 0 0-.616-.224L1.758 13.067a.784.784 0 0 0 .616 1.306H11.64v9.006a.348.348 0 0 0 .616.224l9.626-12.943a.784.784 0 0 0-.52-1.306Z"/>
                </svg>
                <h1>{{ config('app.name', 'Laravel') }}</h1>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Log Out</button>
            </form>
        </header>

        <main>
            <div class="card">
                <h2>Welcome, {{ $user->name }}!</h2>
                <p>You have successfully logged in to the application.</p>

                <div class="badge-status">
                    <span class="dot"></span>
                    Auth Source: {{ $user->source ?? 'Supabase' }}
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">User ID</div>
                        <div class="info-val">#{{ $user->id }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-val">{{ $user->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Account Created</div>
                        <div class="info-val">{{ $user->created_at?->diffForHumans() ?? 'Just now' }}</div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
