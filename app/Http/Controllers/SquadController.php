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
        $squads = Squad::withCount('users')->paginate(10);
        return view('squads.index', compact('squads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('squads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Cek apakah student sudah punya squad
        $student = auth()->user();
        
        if ($student->squad_id) {
            return redirect()->back()->with('error', 'Anda sudah tergabung dalam squad lain!');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:squads',
            'description' => 'nullable|string|max:500',
        ]);

        // Buat squad baru dengan leader adalah student yang membuat
        $squad = Squad::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'leader_id' => $student->id,
        ]);

        // Update student menjadi anggota squad
        $student->update(['squad_id' => $squad->id]);

        return redirect()->route('squads.show', $squad->id)->with('success', 'Squad berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Squad $squad)
    {
        $squad->load('users', 'leader');
        $isLeader = auth()->user()->id === $squad->leader_id;
        
        return view('squads.show', compact('squad', 'isLeader'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Squad $squad)
    {
        // Hanya leader yang bisa edit
        if (auth()->user()->id !== $squad->leader_id) {
            return redirect()->back()->with('error', 'Hanya leader squad yang bisa mengedit!');
        }

        return view('squads.edit', compact('squad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Squad $squad)
    {
        // Cek apakah user adalah leader
        if (auth()->user()->id !== $squad->leader_id) {
            return redirect()->back()->with('error', 'Hanya leader squad yang bisa mengedit!');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:squads,name,' . $squad->id,
            'description' => 'nullable|string|max:500',
        ]);

        $squad->update($validated);

        return redirect()->route('squads.show', $squad->id)->with('success', 'Squad berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Squad $squad)
    {
        // Hanya leader yang bisa hapus squad
        if (auth()->user()->id !== $squad->leader_id) {
            return redirect()->back()->with('error', 'Hanya leader squad yang bisa menghapus!');
        }

        // Lepaskan semua anggota dari squad
        Student::where('squad_id', $squad->id)->update(['squad_id' => null]);

        $squad->delete();

        return redirect()->route('squads.index')->with('success', 'Squad berhasil dihapus!');
    }

    /**
     * Show squad invitations for student
     */
    public function invitations()
    {
        $student = auth()->user();
        
        // Ambil semua squad kecuali yang sudah joined
        $invitations = Squad::where(function ($query) use ($student) {
            $query->doesntHave('users')
                  ->orWhereHas('users', function ($q) use ($student) {
                      $q->where('students.id', '!=', $student->id);
                  });
        })->paginate(10);

        return view('squads.invitations', compact('invitations'));
    }

    /**
     * Student join squad
     */
    public function join(Squad $squad)
    {
        $student = auth()->user();

        // Cek apakah student sudah punya squad
        if ($student->squad_id) {
            return redirect()->back()->with('error', 'Anda sudah tergabung dalam squad lain!');
        }

        // Join squad
        $student->update(['squad_id' => $squad->id]);

        return redirect()->route('squads.show', $squad->id)->with('success', 'Berhasil bergabung ke squad!');
    }

    /**
     * Leader remove member from squad
     */
    public function removeMember(Squad $squad, Student $student)
    {
        // Cek apakah user adalah leader
        if (auth()->user()->id !== $squad->leader_id) {
            return redirect()->back()->with('error', 'Hanya leader squad yang bisa mengeluarkan anggota!');
        }

        // Cek apakah student adalah anggota squad
        if ($student->squad_id !== $squad->id) {
            return redirect()->back()->with('error', 'Student bukan anggota squad ini!');
        }

        // Tidak bisa mengeluarkan leader
        if ($student->id === $squad->leader_id) {
            return redirect()->back()->with('error', 'Tidak bisa mengeluarkan leader squad!');
        }

        // Lepaskan student dari squad
        $student->update(['squad_id' => null]);

        return redirect()->back()->with('success', 'Anggota berhasil dikeluarkan dari squad!');
    }

    /**
     * Student leave squad
     */
    public function leave(Squad $squad)
    {
        $student = auth()->user();

        // Cek apakah student adalah anggota squad
        if ($student->squad_id !== $squad->id) {
            return redirect()->back()->with('error', 'Anda bukan anggota squad ini!');
        }

        // Leader tidak bisa leave, harus delete squad
        if ($student->id === $squad->leader_id) {
            return redirect()->back()->with('error', 'Leader tidak bisa meninggalkan squad. Hapus squad jika ingin keluar!');
        }

        // Lepaskan dari squad
        $student->update(['squad_id' => null]);

        return redirect()->route('squads.index')->with('success', 'Anda berhasil meninggalkan squad!');
    }

    /**
     * Dashboard untuk student
     */
    public function dashboard()
    {
        $student = auth()->user();
        
        if ($student->squad_id) {
            $squad = $student->squad()->with('leader', 'users')->first();
            $isLeader = $student->id === $squad->leader_id;
            
            return view('squads.dashboard', compact('squad', 'isLeader'));
        }

        // Jika belum punya squad, tampilkan pilihan
        $availableSquads = Squad::whereDoesntHave('users', function ($q) use ($student) {
            $q->where('students.id', $student->id);
        })->paginate(10);

        return view('squads.dashboard', compact('availableSquads'));
    }
}