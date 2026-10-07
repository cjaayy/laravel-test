<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script>
        window.location.href = "{{ route('login') }}";
    </script>
</head>
<body style="background: #0d1117; color: #e6edf3; display: flex; align-items: center; justify-content: center; height: 100vh; font-family: sans-serif;">
    <p>Redirecting to <a href="{{ route('login') }}" style="color: #3ecf8e;">Login</a>...</p>
</body>
</html>
