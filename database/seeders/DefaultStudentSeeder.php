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

        // DKV Major Students
        Student::create([
            'name' => 'Siti Nurhaliza',
            'nisn' => '123456786',
            'major' => 'DKV',
            'password' => Hash::make('siti123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);

        Student::create([
            'name' => 'Budi Santoso',
            'nisn' => '123456787',
            'major' => 'DKV',
            'password' => Hash::make('budi123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);

        Student::create([
            'name' => 'Eka Putri',
            'nisn' => '123456788',
            'major' => 'DKV',
            'password' => Hash::make('eka123'),
            'status' => 'pending',
        ]);

        Student::create([
            'name' => 'Fajar Rahman',
            'nisn' => '123456789',
            'major' => 'DKV',
            'password' => Hash::make('fajar123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);

        // BCF Major Students
        Student::create([
            'name' => 'Rini Wijaya',
            'nisn' => '123456790',
            'major' => 'BCF',
            'password' => Hash::make('rini123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);

        Student::create([
            'name' => 'Harun Alrasyid',
            'nisn' => '123456791',
            'major' => 'BCF',
            'password' => Hash::make('harun123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);

        Student::create([
            'name' => 'Indah Lestari',
            'nisn' => '123456792',
            'major' => 'BCF',
            'password' => Hash::make('indah123'),
            'status' => 'pending',
        ]);

        Student::create([
            'name' => 'Joko Widodo',
            'nisn' => '123456793',
            'major' => 'BCF',
            'password' => Hash::make('joko123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);

        // More PPLG Students
        Student::create([
            'name' => 'Kiki Amalia',
            'nisn' => '123456794',
            'major' => 'PPLG',
            'password' => Hash::make('kiki123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);

        Student::create([
            'name' => 'Lala Maulana',
            'nisn' => '123456795',
            'major' => 'PPLG',
            'password' => Hash::make('lala123'),
            'status' => 'pending',
        ]);

        Student::create([
            'name' => 'Mira Kusuma',
            'nisn' => '123456796',
            'major' => 'PPLG',
            'password' => Hash::make('mira123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);

        Student::create([
            'name' => 'Nanda Pratama',
            'nisn' => '123456797',
            'major' => 'PPLG',
            'password' => Hash::make('nanda123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);

        // More TJKT Students
        Student::create([
            'name' => 'Oki Setiawan',
            'nisn' => '123456798',
            'major' => 'TJKT',
            'password' => Hash::make('oki123'),
            'status' => 'pending',
        ]);

        Student::create([
            'name' => 'Putri Handoko',
            'nisn' => '123456799',
            'major' => 'TJKT',
            'password' => Hash::make('putri123'),
            'status' => 'verified',
            'squad_id' => 1,
        ]);
    }
}



