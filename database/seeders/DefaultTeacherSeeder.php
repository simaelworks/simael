<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DefaultTeacherSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		\App\Models\Teacher::factory()->count(5)->create();
		\App\Models\Teacher::create([
			'name' => 'pak wowo',
			'nik' => '1234567890123456',
			'password' => bcrypt('1234567890123456'),
		]);
	}
}
