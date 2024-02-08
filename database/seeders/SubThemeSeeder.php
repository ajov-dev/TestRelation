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
			'description' => 'theme 1 - Default',
			'created_by' => 'admin',
			'updated_by' => 'admin',
		]);

		SubTheme::create([
			'theme_id' => 2, // Default
			'description' => 'theme 1 - Dark',
			'created_by' => 'admin',
			'updated_by' => 'admin',
		]);

		SubTheme::create([
			'theme_id' => 3, // Default
			'description' => 'theme 1 - Light',
			'created_by' => 'admin',
			'updated_by' => 'admin',
		]);
	}
}
