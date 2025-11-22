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
            'status' => 'required|in:on-progress,diterima,pengajuan,unknown',
        ]);

        // Get leader data
        $leader = Student::where('nisn', $validated['leader_nisn'])->first();

        // Parse and validate members_nisn
        $memberNisns = array_map('trim', array_filter(explode(',', $validated['members_nisn'])));
        $members = Student::whereIn('nisn', $memberNisns)->get();
        $memberNisnsInDb = $members->pluck('nisn')->toArray();
        $invalidNisns = array_diff($memberNisns, $memberNisnsInDb);

        return view('squads.preview', compact('validated', 'leader', 'members', 'invalidNisns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:50|unique:squads,name',
            'leader_nisn' => 'required|numeric|digits_between:8,10|exists:students,nisn',
            'members_nisn' => 'required|string',
            'status' => 'required|in:on-progress,diterima,pengajuan,unknown',
        ]);

        // Validate members_nisn format
        $memberNisns = array_map('trim', array_filter(explode(',', $validated['members_nisn'])));
        $members = Student::whereIn('nisn', $memberNisns)->get();
        $memberNisnsInDb = $members->pluck('nisn')->toArray();
        $invalidNisns = array_diff($memberNisns, $memberNisnsInDb);

        if (!empty($invalidNisns)) {
            return back()->withErrors(['members_nisn' => 'NISN tidak valid: ' . implode(', ', $invalidNisns)]);
        }

        // Create squad
        Squad::create([
            'name' => $validated['name'],
            'leader_nisn' => $validated['leader_nisn'],
            'members_nisn' => implode(', ', $memberNisns),
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
            'name' => 'required|string|min:3|max:50|unique:squads,name,' . $squad->id,
            'leader_nisn' => 'required|numeric|digits_between:8,10|exists:students,nisn',
            'members_nisn' => 'required|string',
            'status' => 'required|in:on-progress,diterima,pengajuan,unknown',
        ]);

        // Validate members_nisn format
        $memberNisns = array_map('trim', array_filter(explode(',', $validated['members_nisn'])));
        $members = Student::whereIn('nisn', $memberNisns)->get();
        $memberNisnsInDb = $members->pluck('nisn')->toArray();
        $invalidNisns = array_diff($memberNisns, $memberNisnsInDb);

        if (!empty($invalidNisns)) {
            return back()->withErrors(['members_nisn' => 'NISN tidak valid: ' . implode(', ', $invalidNisns)]);
        }

        // Update squad
        $squad->update([
            'name' => $validated['name'],
            'leader_nisn' => $validated['leader_nisn'],
            'members_nisn' => implode(', ', $memberNisns),
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
}
