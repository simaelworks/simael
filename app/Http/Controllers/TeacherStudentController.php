<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class TeacherStudentController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', session('per_page', 10));
        session(['per_page' => $perPage]);

        $withSquadPage = request('withSquadPage', session('withSquadPage', 1));
        $withoutSquadPage = request('withoutSquadPage', session('withoutSquadPage', 1));
        session(['withSquadPage' => $withSquadPage, 'withoutSquadPage' => $withoutSquadPage]);

        $major = request('major', 'ALL');
        $studentQuery = Student::query();
        if ($major !== 'ALL') {
            $studentQuery->where('major', $major);
        }
        $studentsWithSquad = (clone $studentQuery)->whereNotNull('squad_id')->paginate($perPage, ['*'], 'withSquadPage', $withSquadPage);
        $studentsWithoutSquad = (clone $studentQuery)->whereNull('squad_id')->paginate($perPage, ['*'], 'withoutSquadPage', $withoutSquadPage);
        $allStudents = $studentQuery->get();
        $totalSquads = \App\Models\Squad::count();

        // Jurusan counts (always from all students, not filtered)
        $allJurusanStudents = Student::all();
        $jurusanCounts = [
            'ALL' => $allJurusanStudents->count(),
            'PPLG' => $allJurusanStudents->where('major', 'PPLG')->count(),
            'TJKT' => $allJurusanStudents->where('major', 'TJKT')->count(),
            'BCF' => $allJurusanStudents->where('major', 'BCF')->count(),
            'DKV' => $allJurusanStudents->where('major', 'DKV')->count(),
        ];

        return view('teacher.students.index', compact(
            'studentsWithSquad',
            'studentsWithoutSquad',
            'allStudents',
            'totalSquads',
            'perPage',
            'major',
            'jurusanCounts'
        ));
    }

    public function create()
    {
        return view('teacher.students.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|string|digits_between:8,10|unique:students,nisn,',
            'name' => 'required|string|max:255',
            'major' => 'required|in:PPLG,TJKT,DKV,BCF',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:pending,verified',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $student = Student::create($validated);

        $msg = "Murid baru ditambahkan: {$student->name} (NISN: {$student->nisn})";
        return redirect()->route('teacher.students.index')->with('success', $msg);
    }

    public function show(Student $student)
    {
        return view('teacher.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('teacher.students.edit', compact('student'));
    }

    public function update(\Illuminate\Http\Request $request, Student $student)
    {
        $validated = $request->validate([
            'nisn' => 'required|string|digits_between:8,10|unique:students,nisn,' . $student->id,
            'name' => 'required|string|max:255',
            'major' => 'required|in:PPLG,TJKT,DKV,BCF',
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:pending,verified',
            'squad_id' => 'nullable|integer|exists:squads,id',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }

        if (empty($validated['squad_id'])) {
            $validated['squad_id'] = null;
        }

        $changes = [];
        foreach ($validated as $key => $value) {
            if ($student->{$key} != $value) {
                $changes[$key] = [
                    'old' => $student->{$key},
                    'new' => $value
                ];
            }
        }

        $student->update($validated);

        if (count($changes) > 0) {
            $parts = [];
            foreach ($changes as $field => $vals) {
                $parts[] = "{$field}: {$vals['old']} → {$vals['new']}";
            }
            $detail = implode('; ', $parts);
            $msg = "Data murid diperbarui ({$student->name}): {$detail}";
        } else {
            $msg = "Data murid diperbarui: {$student->name}";
        }

        return redirect()->route('teacher.students.index')->with('success', $msg);
    }

    public function destroy(Student $student)
    {
        $name = $student->name;
        $nisn = $student->nisn;

        $student->delete();

        $withSquadPage = session('withSquadPage', 1);
        $withoutSquadPage = session('withoutSquadPage', 1);
        $perPage = session('per_page', 10);
        return redirect()->route('teacher.students.index', [
            'withSquadPage' => $withSquadPage,
            'withoutSquadPage' => $withoutSquadPage,
            'per_page' => $perPage
        ])->with('success', 'Akun murid berhasil dihapus.');
    }
}
