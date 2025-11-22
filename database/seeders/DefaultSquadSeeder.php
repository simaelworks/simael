<?php

namespace Database\Seeders;

use App\Models\Squad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultSquadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Squad::create([
            'name' => 'Squad Dummy',
            'description' => 'Squad boongan buat tes doang',
        ]);

        Squad::create([
            'name' => 'Squad DKV',
            'description' => 'Squad untuk jurusan Desain Komunikasi Visual',
        ]);

        Squad::create([
            'name' => 'Squad BCF',
            'description' => 'Squad untuk jurusan Bisnis dan Cyber Forensik',
        ]);
    }
}
