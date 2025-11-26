<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Squad;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Show the main list of students.
     * 
     * Loads:
     * - All students with a squad
     * - All students without a squad
     * - All students (full list)
     * - Total number of squads
     * 
     * These are passed to the index page so the UI can
     * render tables, filters, statistics, and JS-side filtering.
     */
    public function index()
    {
        $perPage = request('per_page', session('per_page', 10));
        session(['per_page' => $perPage]);

        $major = request('major', 'ALL');

        $withSquadPage = request('withSquadPage', 1);
        $withoutSquadPage = request('withoutSquadPage', 1);

        // Query global count jurusan (tidak ikut filter)
        $jurusanCounts = [
            'ALL' => Student::count(),
            'PPLG' => Student::where('major', 'PPLG')->count(),
            'TJKT' => Student::where('major', 'TJKT')->count(),
            'BCF' => Student::where('major', 'BCF')->count(),
            'DKV' => Student::where('major', 'DKV')->count(),
        ];

        // Query data siswa sesuai filter
        $studentsWithSquadQuery = Student::whereNotNull('squad_id');
        $studentsWithoutSquadQuery = Student::whereNull('squad_id');
        if ($major !== 'ALL') {
            $studentsWithSquadQuery->where('major', $major);
            $studentsWithoutSquadQuery->where('major', $major);
        }
        $studentsWithSquad = $studentsWithSquadQuery->paginate($perPage, ['*'], 'withSquadPage', $withSquadPage);
        $studentsWithoutSquad = $studentsWithoutSquadQuery->paginate($perPage, ['*'], 'withoutSquadPage', $withoutSquadPage);
        $totalSquads = Squad::count();

        return view('students.index', compact(
            'studentsWithSquad',
            'studentsWithoutSquad',
            'jurusanCounts',
            'totalSquads',
            'perPage',
            'major'
        ));
    }

    /**
     * Show the form for creating a new student.
     * 
     * Loads all squads so the dropdown can display them.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a new student into the database.
     * 
     * Validates form data, encrypts the password,
     * and inserts a new student record.
     * 
     * After creation, redirects with a success message.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|integer|digits_between:8,10|unique:students,nisn,',
            'name' => 'required|string|max:255',
            'major' => 'required|in:PPLG,TJKT,DKV,BCF',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:pending,verified',
        ]);

        // Secure password hashing
        $validated['password'] = bcrypt($validated['password']);

        $student = Student::create($validated);

        $msg = "Murid baru ditambahkan: {$student->name} (NISN: {$student->nisn})";
        return redirect()->route('students.index')->with('success', $msg);
    }

    /**
     * Display a single student's detail page.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the edit form for a student.
     * 
     * Loads all squads so the dropdown can populate properly.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update an existing student.
     * 
     * Validates input, checks for changed fields (to generate
     * a readable change-log message), and updates the student.
     * 
     * If password field is empty, the password stays unchanged.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nisn' => 'required|integer|digits_between:8,10|unique:students,nisn,' . $student->id,
            'name' => 'required|string|max:255',
            'major' => 'required|in:PPLG,TJKT,DKV,BCF',
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:pending,verified',
        ]);

        // Only update password if provided
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }

        /**
         * Compare incoming values with existing ones
         * to build a readable "changes" summary.
         */
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

        // Build message depending on whether changes were detected
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

        return redirect()->route('students.index')->with('success', $msg);
    }

    /**
     * Delete a student record.
     * 
     * Removes the student from the database and returns
     * a success message containing the name and NISN.
     */
    public function destroy(Student $student)
    {
        $name = $student->name;
        $nisn = $student->nisn;

        $student->delete();

        $student->delete();
        // Preserve current page after delete
        $withSquadPage = session('withSquadPage', 1);
        $withoutSquadPage = session('withoutSquadPage', 1);
        $perPage = session('per_page', 10);
        return redirect()->route('students.index', [
            'withSquadPage' => $withSquadPage,
            'withoutSquadPage' => $withoutSquadPage,
            'per_page' => $perPage
        ])->with('success', 'Akun murid berhasil dihapus.');
    }
}

