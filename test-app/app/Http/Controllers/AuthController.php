<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    /**
     * Build an HTTP client for Supabase API requests.
     */
    protected function supabaseClient(?string $token = null)
    {
        $headers = [
            'apikey' => config('services.supabase.anon_key'),
            'Content-Type' => 'application/json',
        ];

        if ($token) {
            $headers['Authorization'] = "Bearer {$token}";
        }

        $client = Http::withHeaders($headers);

        if (!config('services.supabase.verify_ssl', false)) {
            $client = $client->withoutVerifying();
        }

        return $client;
    }

    /**
     * Show the login page.
     */
    public function showLogin()
    {
        if (session()->has('supabase_user') || Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $supabaseUrl = config('services.supabase.url');
        $supabaseKey = config('services.supabase.anon_key');

        // Check if Supabase API is configured
        if ($supabaseUrl && $supabaseKey && !str_contains($supabaseUrl, '[YOUR-PROJECT-REF]')) {
            try {
                $response = $this->supabaseClient()
                    ->post(rtrim($supabaseUrl, '/') . '/auth/v1/token?grant_type=password', [
                        'email' => $credentials['email'],
                        'password' => $credentials['password'],
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    session([
                        'supabase_user' => $data['user'] ?? null,
                        'supabase_token' => $data['access_token'] ?? null,
                    ]);
                    $request->session()->regenerate();

                    return redirect()->intended(route('dashboard'));
                }

                $error = $response->json('error_description') 
                    ?? $response->json('msg') 
                    ?? 'Invalid Supabase login credentials.';

                return back()->withErrors(['email' => $error])->onlyInput('email');
            } catch (\Throwable $e) {
                return back()->withErrors(['email' => 'Supabase connection error: ' . $e->getMessage()])->onlyInput('email');
            }
        }

        // Fallback to local authentication
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials. If using Supabase, please configure SUPABASE_URL and SUPABASE_ANON_KEY in your .env file.',
        ])->onlyInput('email');
    }

    /**
     * Show the registration page.
     */
    public function showRegister()
    {
        if (session()->has('supabase_user') || Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $supabaseUrl = config('services.supabase.url');
        $supabaseKey = config('services.supabase.anon_key');

        // Register directly via Supabase Auth API
        if ($supabaseUrl && $supabaseKey && !str_contains($supabaseUrl, '[YOUR-PROJECT-REF]')) {
            try {
                $response = $this->supabaseClient()
                    ->post(rtrim($supabaseUrl, '/') . '/auth/v1/signup', [
                        'email' => $validated['email'],
                        'password' => $validated['password'],
                        'data' => [
                            'name' => $validated['name'],
                        ],
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    session([
                        'supabase_user' => $data['user'] ?? null,
                        'supabase_token' => $data['access_token'] ?? null,
                    ]);
                    $request->session()->regenerate();

                    return redirect()->route('dashboard');
                }

                $error = $response->json('error_description') 
                    ?? $response->json('msg') 
                    ?? 'Failed to register account with Supabase.';

                return back()->withErrors(['email' => $error])->onlyInput('email');
            } catch (\Throwable $e) {
                return back()->withErrors(['email' => 'Supabase connection error: ' . $e->getMessage()])->onlyInput('email');
            }
        }

        // Fallback local registration
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        $supabaseUrl = config('services.supabase.url');
        $supabaseKey = config('services.supabase.anon_key');
        $token = session('supabase_token');

        if ($token && $supabaseUrl && $supabaseKey) {
            try {
                $this->supabaseClient($token)
                    ->post(rtrim($supabaseUrl, '/') . '/auth/v1/logout');
            } catch (\Throwable) {
                // Ignore API logout error
            }
        }

        Auth::logout();
        session()->forget(['supabase_user', 'supabase_token']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Display the authenticated dashboard.
     */
    public function dashboard()
    {
        $supabaseUser = session('supabase_user');
        $authUser = Auth::user();

        if (!$supabaseUser && !$authUser) {
            return redirect()->route('login');
        }

        $user = $supabaseUser ? (object) [
            'id' => $supabaseUser['id'] ?? 'N/A',
            'name' => $supabaseUser['user_metadata']['name'] ?? explode('@', $supabaseUser['email'] ?? 'User')[0],
            'email' => $supabaseUser['email'] ?? 'N/A',
            'created_at' => isset($supabaseUser['created_at']) ? \Carbon\Carbon::parse($supabaseUser['created_at']) : null,
            'source' => 'Supabase Auth API',
        ] : (object) [
            'id' => $authUser->id,
            'name' => $authUser->name,
            'email' => $authUser->email,
            'created_at' => $authUser->created_at,
            'source' => 'Local Database',
        ];

        return view('dashboard', [
            'user' => $user,
        ]);
    }
}
