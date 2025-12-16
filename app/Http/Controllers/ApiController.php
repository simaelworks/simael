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
        $excludeSquadId = $request->query('exclude_squad_id', null);
        
        $query = Student::query();

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhere('major', 'like', "%{$search}%");
            });
        }

        $students = $query->with('squad')->get();

        // Map students with squad information
        $results = $students->map(function($student) use ($excludeSquadId) {
            $data = [
                'id' => $student->id,
                'name' => $student->name,
                'nisn' => $student->nisn,
                'major' => $student->major,
                'squad_id' => $student->squad_id,
                'in_squad' => !is_null($student->squad_id),
                'squad_name' => $student->squad ? $student->squad->name : null,
            ];
            
            // Mark as unavailable if already in the squad being edited
            if ($excludeSquadId && $student->squad_id == $excludeSquadId) {
                $data['unavailable'] = false; // Can be selected for same squad
            } elseif ($student->squad_id) {
                $data['unavailable'] = true; // Cannot select if in another squad
            }
            
            return $data;
        });

        return response()->json($results);
    }

    // Teacher API endpoints for searching squads
    public function teacherSearchSquads(Request $request)
    {
        $search = $request->query('search', '');

        $query = Squad::with(['leader', 'users']);

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }

        $squads = $query->get()->map(function($squad) {
            return [
                'id' => $squad->id,
                'name' => $squad->name,
                'status' => $squad->status,
                'leader' => $squad->leader,
                'users' => $squad->users,
                'company_name' => $squad->company_name,
                'company_address' => $squad->company_address,
            ];
        });

        return response()->json($squads);
    }
}
