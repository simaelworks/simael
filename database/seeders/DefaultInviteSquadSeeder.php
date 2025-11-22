<?php

namespace Database\Seeders;

use App\Models\InviteSquad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultInviteSquadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        InviteSquad::create([
            'squad_id' => 5,
            'student_id' => 4
        ]);
    }
}
