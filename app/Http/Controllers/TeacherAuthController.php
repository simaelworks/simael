<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.teacher-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nik' => ['required', 'numeric', 'digits:16'],
            'password' => ['required'],
        ]);

        $teacher = Teacher::where('nik', $credentials['nik'])->first();
        if ($teacher && Hash::check($credentials['password'], $teacher->password)) {
            Auth::guard('teacher')->login($teacher);
            $request->session()->regenerate();
            return redirect()->route('teacher.dashboard');
        }

        return back()->withErrors([
            'nik' => 'NIK atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('teacher')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('teacher.login');
    }
}
