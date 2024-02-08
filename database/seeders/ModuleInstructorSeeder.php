<?php

namespace Database\Seeders;

use App\Models\ModuleInstructor;
use Illuminate\Database\Seeder;

class ModuleInstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModuleInstructor::create([
            'module_id' => 1,
            'instructor_id' => 1,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        ModuleInstructor::create([
            'module_id' => 2,
            'instructor_id' => 2,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        ModuleInstructor::create([
            'module_id' => 3,
            'instructor_id' => 3,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);
    }
}
