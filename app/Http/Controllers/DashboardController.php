<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $student = Auth::guard('student')->user();
        $squad = $student->squad;

        // If status is pending, route to pending page
        if ($student->status == 'pending') {
            return view('pages.pending', compact('student'));
        }

        return view('pages.dashboard', compact('student', 'squad'));
    }
}
