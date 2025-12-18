<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class LoginRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:student', ['only' => 'loginPage', 'registerPage', 'login', 'register']);
        $this->middleware('student.auth', ['only' => 'logout']);
    }
    //
    public function loginPage()
    {
        return view('auth.login');
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Get client IP
        $clientIp = $request->ip();
        
        // Check rate limit - 1 registration per 2 minutes per IP
        $cacheKey = 'register_attempt_' . $clientIp;
        
        if (Cache::has($cacheKey)) {
            return back()->with('failed', 'Anda hanya bisa mendaftar sekali setiap 2 menit. Mohon coba lagi nanti.');
        }

        // Validate reCAPTCHA
        $recaptchaToken = $request->input('recaptcha_token');
        
        if (!$recaptchaToken) {
            return back()->with('failed', 'reCAPTCHA validation failed. Mohon coba lagi.');
        }

        // Verify reCAPTCHA with Google
        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $recaptchaToken,
            ]);

            $result = $response->json();

            // reCAPTCHA v3 returns a score between 0.0 and 1.0
            // 1.0 is very likely a legitimate interaction, 0.0 is very likely a bot
            // We use 0.5 as threshold - adjust as needed
            if (!$result['success'] || $result['score'] < 0.5) {
                return back()->with('failed', 'Verifikasi CAPTCHA gagal. Anda mungkin adalah bot atau aktivitas mencurigakan terdeteksi.');
            }
        } catch (\Exception $e) {
            return back()->with('failed', 'Error saat verifikasi CAPTCHA. Mohon coba lagi.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string',
            'nisn' => 'required|string|digits:10',
            'major' => 'required|string',
            'password' => 'required|string',
            'confirm-password' => 'required|string',
        ]);

        $student = Student::where('nisn', $validatedData['nisn'])->first();

        if ($student) {
            return back()->with('failed', 'NISN Sudah Terdaftar di SIMAEL!');
        }

        if ($validatedData['password'] != $validatedData['confirm-password']) {
            return back()->with('failed', 'Re-type password dengan benar!');
        }

        Student::create([
            'name' => $validatedData['name'],
            'nisn' => $validatedData['nisn'],
            'major' => $validatedData['major'],
            'password' => Hash::make($validatedData['password']),
            'status' => 'pending',
        ]);

        // Set cache for 2 minutes (120 seconds)
        Cache::put($cacheKey, true, 120);

        return redirect()->route('login')->with('success', 'Pendaftaran Berhasil!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nisn' => 'required|string|digits:10',
            'password' => 'required|string'
        ]);
        $remember = $request->filled('remember-key');

        if (!Auth::guard('student')->attempt($credentials, $remember)) {
            return back()->with('failed', 'NSIN atau Password salah');
        }

        // session(['student_id' => $student['id']]);
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('loginPage');
    }
}
