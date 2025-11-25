<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user only if not exists
        if (!\App\Models\User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Generate 5 squads
        $squads = \App\Models\Squad::factory(5)->create();

        // Generate 20 students
        $students = \App\Models\Student::factory(20)->create();

        // Assign only verified students to squads
        foreach ($students as $student) {
            if ($student->status === 'verified') {
                $student->squad_id = $squads->random()->id;
                $student->save();
            }
        }

        // Optionally call other seeders if needed
        $this->call([
            DefaultInviteSquadSeeder::class,
        ]);
    }
}
