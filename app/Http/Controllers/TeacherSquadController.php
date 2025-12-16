<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Squad;
use App\Models\Student;

class TeacherSquadController extends Controller
{
    public function index()
    {
        $squads = Squad::paginate(10);
        $allSquads = Squad::with(['leader', 'users'])->get();
        return view('teacher.squads.index', compact('squads', 'allSquads'));
    }

    public function show($id)
    {
        $squad = Squad::findOrFail($id);
        return view('teacher.squads.show', compact('squad'));
    }

    public function create()
    {
        return view('teacher.squads.create');
    }

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:20|min:3',
            'leader_nisn' => 'nullable|string',
            'members_nisn' => 'required|string',
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string|max:255',
            'status' => 'required|string|in:pengajuan,on-progress,diterima,unknown',
        ]);

        // Parse members NISNs
        $memberNisns = array_filter(array_map('trim', explode(',', $validated['members_nisn'])));
        
        // Determine the leader
        $leaderId = null;
        $leaderNisn = null;
        
        if (!empty($validated['leader_nisn'])) {
            // User selected a leader
            $leader = Student::where('nisn', $validated['leader_nisn'])->firstOrFail();
            $leaderId = $leader->id;
            $leaderNisn = $leader->nisn;
        } else {
            // Auto-promote first member to be leader
            if (!empty($memberNisns)) {
                $promotedMember = Student::whereIn('nisn', $memberNisns)->first();
                if ($promotedMember) {
                    $leaderId = $promotedMember->id;
                    $leaderNisn = $promotedMember->nisn;
                    
                    // Remove promoted member from members list
                    $memberNisns = array_filter($memberNisns, fn($nisn) => trim($nisn) !== $leaderNisn);
                }
            }
        }
        
        // Validate that we have a leader
        if (!$leaderId) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['leader_nisn' => 'Harus ada leader atau minimal 1 anggota untuk promosi']);
        }

        // Create the squad
        $squad = Squad::create([
            'name' => $validated['name'],
            'leader_id' => $leaderId,
            'company_name' => $validated['company_name'] ?? null,
            'company_address' => $validated['company_address'] ?? null,
            'status' => $validated['status'],
        ]);

        // Assign leader to squad
        $leader = Student::find($leaderId);
        if ($leader) {
            $leader->update(['squad_id' => $squad->id]);
        }

        // Assign members to squad
        foreach ($memberNisns as $nisn) {
            $member = Student::where('nisn', trim($nisn))->first();
            if ($member) {
                $member->update(['squad_id' => $squad->id]);
            }
        }

        // Clear session data
        session()->forget('squad_form_data');

        return redirect()->route('teacher.squads.index')
            ->with('success', 'Squad baru berhasil dibuat!');
    }

    public function edit($id)
    {
        $squad = Squad::findOrFail($id);
        // Get all members (excluding leader)
        $members = Student::where('squad_id', $squad->id)
            ->where('id', '!=', $squad->leader_id)
            ->get();
        // Get member NISNs as comma-separated string for form
        $memberNisns = $members->pluck('nisn')->implode(', ');
        
        return view('teacher.squads.edit', compact('squad', 'members', 'memberNisns'));
    }

    public function update(Request $request, $id)
    {
        $squad = Squad::findOrFail($id);
        
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:20|min:3',
            'leader_nisn' => 'nullable|string',
            'members_nisn' => 'required|string',
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string|max:255',
            'status' => 'required|string|in:pengajuan,on-progress,diterima,unknown',
        ]);

        // Parse members NISNs
        $memberNisns = array_filter(array_map('trim', explode(',', $validated['members_nisn'])));
        
        // Get member students
        $memberStudents = Student::whereIn('nisn', $memberNisns)->get();
        
        // Determine the new leader
        $newLeaderId = null;
        $newLeaderNisn = null;
        
        if (!empty($validated['leader_nisn'])) {
            // User selected a new leader
            $newLeader = Student::where('nisn', $validated['leader_nisn'])->firstOrFail();
            $newLeaderId = $newLeader->id;
            $newLeaderNisn = $newLeader->nisn;
        } else {
            // User didn't select a new leader, check if we need to auto-promote
            $oldLeaderId = $squad->leader_id;
            
            if (!empty($memberNisns)) {
                // Promote the first member to be the leader
                $promotedMember = Student::whereIn('nisn', $memberNisns)->first();
                if ($promotedMember) {
                    $newLeaderId = $promotedMember->id;
                    $newLeaderNisn = $promotedMember->nisn;
                    
                    // Remove promoted member from members list
                    $memberNisns = array_filter($memberNisns, fn($nisn) => trim($nisn) !== $newLeaderNisn);
                }
            }
        }
        
        // Validate that we have a leader
        if (!$newLeaderId) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['leader_nisn' => 'Harus ada leader atau minimal 1 anggota untuk promosi']);
        }

        // Update squad
        $squad->update([
            'name' => $validated['name'],
            'leader_id' => $newLeaderId,
            'company_name' => $validated['company_name'] ?? null,
            'company_address' => $validated['company_address'] ?? null,
            'status' => $validated['status'],
        ]);

        // Update all students squad_id
        // First, remove all students from this squad
        Student::where('squad_id', $squad->id)->update(['squad_id' => null]);

        // Assign the leader
        $leader = Student::find($newLeaderId);
        if ($leader) {
            $leader->update(['squad_id' => $squad->id]);
        }

        // Then assign new members
        foreach ($memberNisns as $nisn) {
            $student = Student::where('nisn', trim($nisn))->first();
            if ($student) {
                $student->update(['squad_id' => $squad->id]);
            }
        }

        return redirect()->route('teacher.squads.index')
            ->with('success', 'Squad berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $squad = Squad::findOrFail($id);
        
        // Remove all students from this squad
        Student::where('squad_id', $squad->id)->update(['squad_id' => null]);
        
        // Delete the squad
        $squad->delete();
        
        return redirect()->route('teacher.squads.index')
            ->with('success', 'Squad berhasil dihapus!');
    }

    public function preview(Request $request)
    {
        $squads = Squad::all();
        
        // Jika POST request, simpan form data ke session untuk preview
        if ($request->isMethod('post')) {
            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:20|min:3',
                'leader_nisn' => 'nullable|string',
                'members_nisn' => 'required|string',
                'company_name' => 'nullable|string|max:255',
                'company_address' => 'nullable|string|max:255',
                'status' => 'required|string|in:pengajuan,on-progress,diterima,unknown',
            ]);
            
            // Store form data in session for preview
            return redirect()->route('teacher.squads.preview')
                ->with('squad_form_data', $validated);
        }
        
        // Get form data from session
        $validated = session('squad_form_data', []);
        
        // Get leader info if available
        $leader = null;
        $leaderAlreadyInSquad = false;
        if (!empty($validated['leader_nisn'])) {
            $leader = Student::where('nisn', $validated['leader_nisn'])->first();
            // Check if leader is already in another squad
            if ($leader && $leader->squad_id) {
                $leaderAlreadyInSquad = true;
            }
        }
        
        // Get members info if available
        $memberStudents = [];
        $membersAlreadyInSquad = [];
        if (!empty($validated['members_nisn'])) {
            $memberNisns = array_filter(array_map('trim', explode(',', $validated['members_nisn'])));
            $memberStudents = Student::whereIn('nisn', $memberNisns)->get();
            
            // Check which members are already in other squads
            $membersAlreadyInSquad = $memberStudents->filter(function ($member) {
                return $member->squad_id !== null;
            })->all();
        }
        
        return view('teacher.squads.preview', compact('squads', 'validated', 'leader', 'memberStudents', 'leaderAlreadyInSquad', 'membersAlreadyInSquad'));
    }
}
