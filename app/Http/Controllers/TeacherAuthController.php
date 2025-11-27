<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        if (!$teacher || !Hash::check($credentials['password'], $teacher->password)) {
            return back()->withErrors([
                'nik' => 'NIK atau password salah.',
            ])->withInput();
        };

        session(['teacher_id' => $teacher['id']]);
        return redirect()->route('teacher.dashboard');
    }

    public function logout()
    {
        session()->forget('student_id');

        return redirect()->route('teacher.login');
    }
}
