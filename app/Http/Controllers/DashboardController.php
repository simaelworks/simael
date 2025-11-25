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

        // If status is pending, route to pending page
        if ($student->status == 'pending') {
            return view('pages.pending', compact('student'));
        }

        return view('pages.dashboard', compact('student', 'squad'));
    }
}
