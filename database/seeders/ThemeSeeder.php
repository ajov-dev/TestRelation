<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Theme::create([
			'description' => 'Theme #1',
			'created_by' => 'admin',
			'updated_by' => 'admin',
		]);

		Theme::create([
			'description' => 'Theme #2',
			'created_by' => 'admin',
			'updated_by' => 'admin',
		]);

		Theme::create([
			'description' => 'Theme #3',
			'created_by' => 'admin',
			'updated_by' => 'admin',
		]);

		Theme::create([
			'description' => 'Theme #4',
			'created_by' => 'admin',
			'updated_by' => 'admin',
		]);

		Theme::create([
			'description' => 'Theme #5',
			'created_by' => 'admin',
			'updated_by' => 'admin',
		]);

		Theme::create([
			'description' => 'Theme #6',
			'created_by' => 'admin',
			'updated_by' => 'admin',
		]);
	}
}
