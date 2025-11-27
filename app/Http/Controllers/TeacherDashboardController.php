<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    //
    public function index()
    {
        $teacher = Teacher::find(session('teacher_id'));
        return view('teacher.dashboard', compact('teacher'));
    }
}
