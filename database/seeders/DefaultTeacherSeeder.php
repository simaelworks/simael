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
		DB::table('teachers')->updateOrInsert(
			['nik' => '1234567890123456'],
			[
				'name' => 'Demo Teacher',
				'password' => Hash::make('password123'),
				'created_at' => now(),
				'updated_at' => now(),
			]
		);
	}
}
