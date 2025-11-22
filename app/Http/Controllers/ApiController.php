<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getStudent()
    {
        $student = Student::all();

        return response()->json($student);
    }
}
