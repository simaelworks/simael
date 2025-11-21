<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Student::create([
            'name' => 'Lutfi',
            'nisn' => '1234567890',
            'major' => 'PPLG',
            'password' => Hash::make('lutfi123'),
            'status' => 'pending',
        ]);
        
        Student::create([
            'name' => 'Aufa',
            'nisn' => '1234567891',
            'major' => 'PPLG',
            'password' => Hash::make('aufa123'),
            'status' => 'pending',
        ]);
                
        Student::create([
            'name' => 'rofi',
            'nisn' => '1234567892',
            'major' => 'PPLG',
            'password' => Hash::make('rofi123'),
            'status' => 'pending',
        ]);
        
        Student::create([
            'name' => 'dika',
            'nisn' => '1234567893',
            'major' => 'PPLG',
            'password' => Hash::make('dika123'),
            'status' => 'pending',
        ]);


        Student::create([
            'name' => 'Ryandra',
            'nisn' => '12345678',
            'major' => 'TJKT',
            'password' => Hash::make('ryan123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);

        Student::create([
            'name' => 'dandi',
            'nisn' => '123456781',
            'major' => 'TJKT',
            'password' => Hash::make('dandi123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);

        Student::create([
            'name' => 'excel',
            'nisn' => '123456782',
            'major' => 'TJKT',
            'password' => Hash::make('excel123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);
        
        Student::create([
            'name' => 'pindut',
            'nisn' => '123456783',
            'major' => 'TJKT',
            'password' => Hash::make('pinndut123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);
        
        Student::create([
            'name' => 'kennnet',
            'nisn' => '123456784',
            'major' => 'TJKT',
            'password' => Hash::make('kennet123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);

        Student::create([
            'name' => 'adrian',
            'nisn' => '123456785',
            'major' => 'TJKT',
            'password' => Hash::make('adrian123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);
    }
}



