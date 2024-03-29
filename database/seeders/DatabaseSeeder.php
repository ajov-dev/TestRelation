<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		// \App\Models\User::factory(10)->create();

		// \App\Models\User::factory()->create([
		//     'name' => 'Test User',
		//     'email' => 'test@example.com',
		// ]);

		$this->call(AcademicActivitySeeder::class);
		$this->call(GroupSeeder::class);
		$this->call(ModuleSeeder::class);
		$this->call(InstructorSeeder::class);
		$this->call(ThemeSeeder::class);

		// $this->call(GroupModuleSeeder::class);
		// $this->call(ModuleThemeSeeder::class);
		// $this->call(ModuleInstructorSeeder::class);
		// $this->call(SubThemeSeeder::class);

	}
}
