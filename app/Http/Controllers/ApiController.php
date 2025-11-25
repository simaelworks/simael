<?php

namespace App\Http\Controllers;

use App\Models\InviteSquad;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function getStudent()
    {
        $student = Student::all();

        return response()->json($student);
    }

    public function inviteStudent(Request $request)
    {
        Log::info('Got request');
        Log::info($request);
        $validate = $request->validate([
            'squad_id' => 'integer',
            'student_id' => 'integer',
        ]);


        InviteSquad::create($validate);

        return response('Successfully make invite request to Student', 200);
    }
}
