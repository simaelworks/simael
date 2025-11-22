<?php

namespace App\Http\Controllers;

use App\Models\Squad;
use App\Models\Student;
use Illuminate\Http\Request;

class SquadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allSquads = Squad::all();

        // Get all majors from all students
        $majors = Student::distinct()
            ->pluck('major')
            ->filter()
            ->sort()
            ->values();

        return view('squads.index', compact('allSquads', 'majors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('squads.create');
    }

    /**
     * Show preview of squad before creating
     */
    public function preview(Request $request)
    {
        // If GET request, try to use old input from session
        if ($request->isMethod('get') && !$request->hasAny(['name', 'leader_nisn', 'members_nisn', 'status'])) {
            // Check if we have old input from validation failure
            if (!$request->old('name')) {
                return redirect()->route('squads.create');
            }
        }

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:50|unique:squads,name',
            'leader_nisn' => 'required|numeric|digits_between:8,10|exists:students,nisn',
            'members_nisn' => 'required|string',
            'nama_perusahaan' => 'nullable|string|max:100',
            'alamat_perusahaan' => 'nullable|string|max:255',
            'status' => 'required|in:on-progress,diterima,pengajuan,unknown',
        ]);

        // Get leader data
        $leader = Student::where('nisn', $validated['leader_nisn'])->first();

        // Parse and validate members_nisn
        $memberNisnsArray = array_map('trim', array_filter(explode(',', $validated['members_nisn'])));
        $memberStudents = Student::whereIn('nisn', $memberNisnsArray)->get();
        $nisnsFoundInDb = $memberStudents->pluck('nisn')->toArray();
        $nisnsInvalid = array_diff($memberNisnsArray, $nisnsFoundInDb);

        // Check if any NISN is already used in other squads
        $nisnsForValidation = array_merge([$validated['leader_nisn']], $memberNisnsArray);
        $nisnsAlreadyUsed = $this->getUsedNisns($nisnsForValidation);

        return view('squads.preview', compact('validated', 'leader', 'memberStudents', 'nisnsInvalid', 'nisnsAlreadyUsed'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:20|unique:squads,name',
            'leader_nisn' => 'required|numeric|digits_between:8,10|exists:students,nisn',
            'members_nisn' => 'required|string',
            'nama_perusahaan' => 'nullable|string|max:100',
            'alamat_perusahaan' => 'nullable|string|max:255',
            'status' => 'required|in:on-progress,diterima,pengajuan,unknown',
        ]);

        // Validate members_nisn format
        $memberNisnsArray = array_map('trim', array_filter(explode(',', $validated['members_nisn'])));
        $memberStudents = Student::whereIn('nisn', $memberNisnsArray)->get();
        $nisnsFoundInDb = $memberStudents->pluck('nisn')->toArray();
        $nisnsInvalid = array_diff($memberNisnsArray, $nisnsFoundInDb);

        if (!empty($nisnsInvalid)) {
            return back()->withErrors(['members_nisn' => 'NISN tidak valid: ' . implode(', ', $nisnsInvalid)]);
        }

        // Check if any NISN is already used in other squads
        $nisnsForValidation = array_merge([$validated['leader_nisn']], $memberNisnsArray);
        $nisnsAlreadyUsed = $this->getUsedNisns($nisnsForValidation);

        if (!empty($nisnsAlreadyUsed)) {
            return back()->withErrors(['members_nisn' => 'NISN sudah digunakan di squad lain: ' . implode(', ', $nisnsAlreadyUsed)]);
        }

        // Create squad
        Squad::create([
            'name' => $validated['name'],
            'leader_nisn' => $validated['leader_nisn'],
            'members_nisn' => implode(', ', $memberNisnsArray),
            'nama_perusahaan' => $validated['nama_perusahaan'] ?? null,
            'alamat_perusahaan' => $validated['alamat_perusahaan'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('squads.index')->with('success', 'Squad berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Squad $squad)
    {
        return view('squads.show', compact('squad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Squad $squad)
    {
        return view('squads.edit', compact('squad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Squad $squad)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:20|unique:squads,name,' . $squad->id,
            'leader_nisn' => 'required|numeric|digits_between:8,10|exists:students,nisn',
            'members_nisn' => 'required|string',
            'nama_perusahaan' => 'nullable|string|max:100',
            'alamat_perusahaan' => 'nullable|string|max:255',
            'status' => 'required|in:on-progress,diterima,pengajuan,unknown',
        ]);

        // Validate members_nisn format
        $memberNisnsArray = array_map('trim', array_filter(explode(',', $validated['members_nisn'])));
        $memberStudents = Student::whereIn('nisn', $memberNisnsArray)->get();
        $nisnsFoundInDb = $memberStudents->pluck('nisn')->toArray();
        $nisnsInvalid = array_diff($memberNisnsArray, $nisnsFoundInDb);

        if (!empty($nisnsInvalid)) {
            return back()->withErrors(['members_nisn' => 'NISN tidak valid: ' . implode(', ', $nisnsInvalid)]);
        }

        // Check if any NISN is already used in OTHER squads (exclude current squad)
        $nisnsForValidation = array_merge([$validated['leader_nisn']], $memberNisnsArray);
        $nisnsAlreadyUsed = $this->getUsedNisnsExcept($nisnsForValidation, $squad->id);

        if (!empty($nisnsAlreadyUsed)) {
            return back()->withErrors(['members_nisn' => 'NISN sudah digunakan di squad lain: ' . implode(', ', $nisnsAlreadyUsed)]);
        }

        // Update squad
        $squad->update([
            'name' => $validated['name'],
            'leader_nisn' => $validated['leader_nisn'],
            'members_nisn' => implode(', ', $memberNisnsArray),
            'nama_perusahaan' => $validated['nama_perusahaan'] ?? null,
            'alamat_perusahaan' => $validated['alamat_perusahaan'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('squads.index')->with('success', 'Squad berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Squad $squad)
    {
        $squad->delete();
        return redirect()->route('squads.index')->with('success', 'Squad berhasil dihapus!');
    }

    /**
     * Get list of NISNs that are already used in other squads
     */
    private function getUsedNisns(array $nisnsToCheck)
    {
        $nisnsAlreadyUsed = [];

        foreach ($nisnsToCheck as $currentNisn) {
            // Check in leader_nisn
            if (Squad::where('leader_nisn', $currentNisn)->exists()) {
                $nisnsAlreadyUsed[] = $currentNisn;
                continue;
            }

            // Check in members_nisn (comma-separated string)
            if (Squad::where('members_nisn', 'LIKE', "%$currentNisn%")->exists()) {
                $nisnsAlreadyUsed[] = $currentNisn;
            }
        }

        return $nisnsAlreadyUsed;
    }

    /**
     * Get list of NISNs that are already used in OTHER squads (excluding given squad ID)
     */
    private function getUsedNisnsExcept(array $nisnsToCheck, $excludeSquadId)
    {
        $nisnsAlreadyUsed = [];

        foreach ($nisnsToCheck as $currentNisn) {
            // Check in leader_nisn (exclude current squad)
            if (Squad::where('leader_nisn', $currentNisn)->where('id', '!=', $excludeSquadId)->exists()) {
                $nisnsAlreadyUsed[] = $currentNisn;
                continue;
            }

            // Check in members_nisn (comma-separated string, exclude current squad)
            if (Squad::where('members_nisn', 'LIKE', "%$currentNisn%")->where('id', '!=', $excludeSquadId)->exists()) {
                $nisnsAlreadyUsed[] = $currentNisn;
            }
        }

        return $nisnsAlreadyUsed;
    }
}
