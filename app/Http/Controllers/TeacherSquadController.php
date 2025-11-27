<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Squad;

class TeacherSquadController extends Controller
{
    public function index()
    {
        $squads = Squad::paginate(10);
        $allSquads = Squad::all();
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

    public function edit($id)
    {
        $squad = Squad::findOrFail($id);
        return view('teacher.squads.edit', compact('squad'));
    }

    public function preview()
    {
        $squads = Squad::all();
        return view('teacher.squads.preview', compact('squads'));
    }
}
