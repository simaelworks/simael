<?php

namespace App\Http\Controllers;

use App\Models\InviteSquad;
use Illuminate\Http\Request;

class InviteSquadController extends Controller
{
    public function store(Request $request) {
        InviteSquad::create([
            'squad_id' => $request['squad_id'],
            'student_id' => $request['student_id']
        ]);

        return redirect()->route('dashboard');
    }

    public function destroy(InviteSquad $invite) {
        $invite->delete();

        return redirect()->route('dashboard');
    }
}
