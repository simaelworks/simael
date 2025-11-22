<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $student = Student::find(session('student_id'));
        $squad = $student->squad;

        return view('pages.dashboard', compact('student', 'squad'));
    }
}
