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

        return view('teacher.squads.index', compact('allSquads', 'majors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $availableStudents = Student::all();
        // Note: Session data 'squad_form_data' is preserved for restoring form values after coming back from preview
        return view('teacher.squads.create', compact('availableStudents'));
    }

    /**
     * Show preview of squad before creating
     */
    public function preview(Request $request)
    {
        // // If GET request, try to use old input from session
        // if ($request->isMethod('get') && !$request->hasAny(['name', 'leader_nisn', 'members_nisn', 'status'])) {
        //     // Check if we have old input from validation failure
        //     if (!$request->old('name')) {
        //         return redirect()->route('squads.create');
        //     }
        // }

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:20|unique:squads,name',
            'nama_perusahaan' => 'nullable|string|max:100',
            'alamat_perusahaan' => 'nullable|string|max:255',
            'status' => 'required|in:on-progress,diterima,pengajuan,unknown',
        ]);

        // Get leader data
        // $leader = Student::where('nisn', $validated['leader_nisn'])->first();

        // // Parse and validate members_nisn
        // $memberNisnsArray = array_map('trim', array_filter(explode(',', $validated['members_nisn'])));
        
        // // Check if at least one member is provided
        // if (empty($memberNisnsArray)) {
        //     return back()->withErrors(['members_nisn' => 'Minimal harus ada satu anggota']);
        // }
        
        // // Check that all NISNs are exactly 10 digits
        // $invalidNisns = array_filter($memberNisnsArray, function ($nisn) {
        //     return !preg_match('/^\d{10}$/', $nisn);
        // });
        // if (!empty($invalidNisns)) {
        //     return back()->withErrors(['members_nisn' => 'Semua NISN anggota harus 10 angka: ' . implode(', ', $invalidNisns)]);
        // }
        
        // $memberStudents = Student::whereIn('nisn', $memberNisnsArray)->get();
        // $nisnsFoundInDb = $memberStudents->pluck('nisn')->toArray();
        // $idsInvalid = array_diff($memberNisnsArray, $nisnsFoundInDb);

        // if (!empty($idsInvalid)) {
        //     return back()->withErrors(['members_nisn' => 'NISN tidak ditemukan: ' . implode(', ', $idsInvalid)]);
        // }

        // // Check if any NISN is already used in other squads BEFORE going to preview
        // $idsForValidation = array_merge([$validated['leader_nisn']], $memberNisnsArray);
        // $idsAlreadyUsed = $this->getUsedIds($idsForValidation);

        // if (!empty($idsAlreadyUsed)) {
        //     return back()->withErrors(['members_nisn' => 'NISN sudah digunakan di squad lain: ' . implode(', ', $idsAlreadyUsed)]);
        // }

        // // TIDAK ada NISN yang terpakai, simpan input ke session untuk restore jika kembali dari preview
        // $request->session()->put('squad_form_data', $validated);

        // // Check if leader is already in a squad
        // $leaderAlreadyInSquad = in_array($validated['leader_nisn'], $idsAlreadyUsed);

        // // Check which members are already in squads
        // $membersAlreadyInSquad = $memberStudents->filter(function ($student) use ($idsAlreadyUsed) {
        //     return in_array($student->nisn, $idsAlreadyUsed);
        // });

        return view('teacher.squads.preview', compact('validated', 'leader', 'memberStudents', 'idsInvalid', 'idsAlreadyUsed', 'leaderAlreadyInSquad', 'membersAlreadyInSquad'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $student = Student::find(session('student_id'));

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:20|unique:squads,name',
            'description' => 'nullable|string',
        ]);

        $squad = Squad::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'leader_id' => $student->id,
        ]);

        $student->update(['squad_id' => $squad->id]);

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Squad $squad)
    {
        return view('teacher.squads.show', compact('squad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Squad $squad)
    {
        return view('teacher.squads.edit', compact('squad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Squad $squad)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|min:3|max:20|unique:squads,name,' . $squad->id,
            'company_name' => 'nullable|string|max:100',
            'company_address' => 'nullable|string|max:255',
            'status' => 'nullable|in:on-progress,diterima,pengajuan,unknown',
        ]);

        foreach ($validated as $key => $value) {
            if (!$validated[$key]) {
                unset($validated[$key]);
            }
        }

        $squad->update($validated);
        
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Squad $squad)
    {
        $squad->delete();
        return redirect()->route('teacher.squads.index')->with('success', 'Squad berhasil dihapus!');
    }

    /**
     * Get list of NISNs that are already used in other squads
     */
    // private function getUsedIds(array $nisnsToCheck)
    // {
    //     $nisnsAlreadyUsed = [];

    //     foreach ($nisnsToCheck as $currentNisn) {
    //         // Check in leader_nisn
    //         if (Squad::where('leader_nisn', $currentNisn)->exists()) {
    //             $nisnsAlreadyUsed[] = $currentNisn;
    //             continue;
    //         }

    //         // Check in members_nisn (comma-separated string)
    //         if (Squad::where('members_nisn', 'LIKE', "%$currentNisn%")->exists()) {
    //             $nisnsAlreadyUsed[] = $currentNisn;
    //         }
    //     }

    //     return $nisnsAlreadyUsed;
    // }

    /**
     * Get list of NISNs that are already used in OTHER squads (excluding given squad ID)
     */
    // private function getUsedIdsExcept(array $nisnsToCheck, $excludeSquadId)
    // {
    //     $nisnsAlreadyUsed = [];

    //     foreach ($nisnsToCheck as $currentNisn) {
    //         // Check in leader_nisn (exclude current squad)
    //         if (Squad::where('leader_nisn', $currentNisn)->where('id', '!=', $excludeSquadId)->exists()) {
    //             $nisnsAlreadyUsed[] = $currentNisn;
    //             continue;
    //         }

    //         // Check in members_nisn (comma-separated string, exclude current squad)
    //         if (Squad::where('members_nisn', 'LIKE', "%$currentNisn%")->where('id', '!=', $excludeSquadId)->exists()) {
    //             $nisnsAlreadyUsed[] = $currentNisn;
    //         }
    //     }

    //     return $nisnsAlreadyUsed;
    // }

    public function kickMember(Student $student)
    {
        if (!$student) {
            return redirect()->route('dashboard')->with('error', 'Student tidak ditemukan!');
        }

        $student->update([
            'squad_id' => null
        ]);

        return redirect()->route('dashboard')->with('success', 'Berhasil mengeluarkan student dari squad');
    }

    public function leave(Squad $squad)
    {
        $student = Student::find(session('student_id'));

        // Hapus squad jika leader keluar dari squad
        if ($student->id == $squad->leader_id) {
            $squad->delete();
        } else {
            $student->update([
                'squad_id' => null
            ]);
        }

        return redirect()->route('dashboard');
    }
}
