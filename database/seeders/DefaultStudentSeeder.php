<?php

namespace Database\Seeders;

use App\Models\Squad;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DefaultStudentSeeder extends Seeder
{
    public function run(): void
    {
        // Default student to login
        $students = [
            ['name' => 'Lutfi', 'nisn' => '1234567890', 'major' => 'PPLG', 'password' => 'lutfi123'],
            ['name' => 'Aufa', 'nisn' => '1234567891', 'major' => 'PPLG', 'password' => 'aufa123'],
            ['name' => 'rofi', 'nisn' => '1234567892', 'major' => 'PPLG', 'password' => 'rofi123'],
            ['name' => 'dika', 'nisn' => '1234567893', 'major' => 'PPLG', 'password' => 'dika123'],
            ['name' => 'Ryandra', 'nisn' => '1234567894', 'major' => 'TJKT', 'password' => 'ryan123'],
        ];

        foreach ($students as $student) {
            Student::create([
                'name' => $student['name'],
                'nisn' => $student['nisn'],
                'major' => $student['major'],
                'password' => Hash::make($student['password']),
                'status' => 'verified',
            ]);
        }

        // Generate 30 random student
		Student::factory()->count(40)->create();

        // --------

        // finally, make squad and student to have relation

        $verifiedStudents = Student::where([
            'status' => 'verified'
        ])->get();

        $squads = Squad::all();

        // Assign verified student to be leader squad. if squad is full, assign verified student to be member of random squad
        // This will made the development test to be easy
        foreach ($verifiedStudents as $key => $student) {
            if (isset($squads[$key])) {
                $squad = $squads[$key];
                $squad->leader_id = $student->id;
                $student->squad_id = $squad->id;

                $squad->save();
                $student->save();

                continue;
            }

            $student->squad_id = $squads->random()->id;
            $student->save();
        }

        // Assign random verified user to be leader of squad
        // foreach ($squads as $squad) {
        //     $squad->leader_id = $verifiedStudents->random()->id;
        //     $squad->save();
        // }
    }
}



