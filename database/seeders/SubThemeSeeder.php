<?php

namespace Database\Seeders;

use App\Models\SubTheme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubThemeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{

		SubTheme::create([
			'theme_id' => 1, // Default
			'description' => 'Sub_theme #1',
			'created_by' => 'admin',
			'updated_by' => 'admin',
		]);

		SubTheme::create([
			'theme_id' => 1, // Default
			'description' => 'Sub_theme #2',
			'created_by' => 'admin',
			'updated_by' => 'admin',
		]);

		SubTheme::create([
			'theme_id' => 2, // Default
			'description' => 'Sub_theme #3',
			'created_by' => 'admin',
			'updated_by' => 'admin',
		]);

		SubTheme::create([
			'theme_id' => 2, // Default
			'description' => 'Sub_theme #4',
			'created_by' => 'admin',
			'updated_by' => 'admin',
		]);

		SubTheme::create([
			'theme_id' => 3, // Default
			'description' => 'Sub_theme #5',
			'created_by' => 'admin',
			'updated_by' => 'admin',
		]);

		SubTheme::create([
			'theme_id' => 3, // Default
			'description' => 'Sub_theme #6',
			'created_by' => 'admin',
			'updated_by' => 'admin',
		]);
	}
}
