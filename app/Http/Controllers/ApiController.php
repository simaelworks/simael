<?php

namespace App\Http\Controllers;

use App\Models\InviteSquad;
use App\Models\Student;
use App\Models\Squad;
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

    // Teacher API endpoints for searching students
    public function teacherSearchStudents(Request $request)
    {
        $search = $request->query('search', '');
        
        if (empty($search)) {
            return response()->json([]);
        }

        $students = Student::where('name', 'like', "%{$search}%")
            ->orWhere('nisn', 'like', "%{$search}%")
            ->orWhere('id', 'like', "%{$search}%")
            ->with('squad')
            ->get();

        return response()->json($students);
    }

    // Teacher API endpoints for searching squads
    public function teacherSearchSquads(Request $request)
    {
        $search = $request->query('search', '');
        
        if (empty($search)) {
            return response()->json([]);
        }

        $squads = Squad::where('name', 'like', "%{$search}%")
            ->with(['leader', 'users'])
            ->get();

        return response()->json($squads);
    }
}
