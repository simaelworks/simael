<?php

namespace Database\Seeders;

use App\Models\Squad;
use Illuminate\Database\Seeder;

class DefaultSquadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 squad
        Squad::factory()->count(10)->create();

        Squad::create([
            'name' => 'Squad Dummy',
            'description' => 'Squad boongan buat tes doang',
            'status' => 'on-progress',
        ]);

        Squad::create([
            'name' => 'Squad DKV',
            'description' => 'Squad untuk jurusan Desain Komunikasi Visual',
            'status' => 'pengajuan',
        ]);

        Squad::create([
            'name' => 'Squad BCF',
            'description' => 'Squad untuk jurusan Bisnis dan Cyber Forensik',
            'status' => 'diterima',
        ]);
    }
}
