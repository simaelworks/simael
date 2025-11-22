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
        $studentsWithSquad = Student::with('squad')->whereNotNull('squad_id')->get();
        $studentsWithoutSquad = Student::with('squad')->whereNull('squad_id')->get();
        $allStudents = Student::with('squad')->get();
        $totalSquads = Squad::count();

        return view('students.index', compact(
            'studentsWithSquad',
            'studentsWithoutSquad',
            'allStudents',
            'totalSquads'
        ));
    }

    /**
     * Show the form for creating a new student.
     * 
     * Loads all squads so the dropdown can display them.
     */
    public function create()
    {
        $squads = Squad::all();
        return view('students.create', compact('squads'));
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
            'squad_id' => 'nullable|exists:squads,id',
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
        $squads = Squad::all();
        return view('students.edit', compact('student', 'squads'));
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
            'squad_id' => 'nullable|exists:squads,id',
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

        $msg = "Murid dihapus: {$name} (NISN: {$nisn})";
        return redirect()->route('students.index')->with('success', $msg);
    }
}

