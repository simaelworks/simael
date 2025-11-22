<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class LoginRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['only' => 'loginPage', 'registerPage', 'login', 'register']);
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
        $validatedData = $request->validate([
            'name' => 'required|string',
            'nisn' => 'required|integer',
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

        return redirect()->route('login')->with('success', 'Pendaftaran Berhasil!');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'nisn' => 'required|integer',
            'password' => 'required|string'
        ]);

        $student = Student::where('nisn', $validatedData['nisn'])->first();

        if (!$student) {
            return back()->with('failed', 'NISN atau Kata sandi salah!');
        }

        if (!Hash::check($validatedData['password'], $student['password'])) {
            return back()->with('failed', 'NISN atau Kata sandi salah!');
        }

        session(['student_id' => $student['id']]);
        return redirect()->route('dashboard');
    }

    public function logout()
    {
        session()->forget('student_id');

        return redirect()->route('loginPage');
    }
}
