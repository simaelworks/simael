<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DefaultStudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['name' => 'Lutfi', 'nisn' => '1234567890', 'major' => 'PPLG', 'password' => 'lutfi123'],
            ['name' => 'Aufa', 'nisn' => '1234567891', 'major' => 'PPLG', 'password' => 'aufa123'],
            ['name' => 'rofi', 'nisn' => '1234567892', 'major' => 'PPLG', 'password' => 'rofi123'],
            ['name' => 'dika', 'nisn' => '1234567893', 'major' => 'PPLG', 'password' => 'dika123'],
            ['name' => 'Ryandra', 'nisn' => '1234567894', 'major' => 'TJKT', 'password' => 'ryan123'],
            ['name' => 'dandi', 'nisn' => '1234567895', 'major' => 'TJKT', 'password' => 'dandi123'],
            ['name' => 'excel', 'nisn' => '1234567896', 'major' => 'TJKT', 'password' => 'excel123'],
            ['name' => 'pindut', 'nisn' => '1234567897', 'major' => 'TJKT', 'password' => 'pinndut123'],
            ['name' => 'kennnet', 'nisn' => '1234567898', 'major' => 'TJKT', 'password' => 'kennet123'],
            ['name' => 'adrian', 'nisn' => '1234567899', 'major' => 'TJKT', 'password' => 'adrian123'],
            ['name' => 'Siti Nurhaliza', 'nisn' => '1234567900', 'major' => 'DKV', 'password' => 'siti123'],
            ['name' => 'Budi Santoso', 'nisn' => '1234567901', 'major' => 'DKV', 'password' => 'budi123'],
            ['name' => 'Eka Putri', 'nisn' => '1234567902', 'major' => 'DKV', 'password' => 'eka123'],
            ['name' => 'Fajar Rahman', 'nisn' => '1234567903', 'major' => 'DKV', 'password' => 'fajar123'],
            ['name' => 'Rini Wijaya', 'nisn' => '1234567904', 'major' => 'BCF', 'password' => 'rini123'],
            ['name' => 'Harun Alrasyid', 'nisn' => '1234567905', 'major' => 'BCF', 'password' => 'harun123'],
            ['name' => 'Indah Lestari', 'nisn' => '1234567906', 'major' => 'BCF', 'password' => 'indah123'],
            ['name' => 'Joko Widodo', 'nisn' => '1234567907', 'major' => 'BCF', 'password' => 'joko123'],
            ['name' => 'Kiki Amalia', 'nisn' => '1234567908', 'major' => 'PPLG', 'password' => 'kiki123'],
            ['name' => 'Lala Maulana', 'nisn' => '1234567909', 'major' => 'PPLG', 'password' => 'lala123'],
            ['name' => 'Mira Kusuma', 'nisn' => '1234567910', 'major' => 'PPLG', 'password' => 'mira123'],
            ['name' => 'Nanda Pratama', 'nisn' => '1234567911', 'major' => 'PPLG', 'password' => 'nanda123'],
            ['name' => 'Oki Setiawan', 'nisn' => '1234567912', 'major' => 'TJKT', 'password' => 'oki123'],
            ['name' => 'Putri Handoko', 'nisn' => '1234567913', 'major' => 'TJKT', 'password' => 'putri123'],
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
    }
}



