<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Module::create([
            'description' => 'Module #1',
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        Module::create([
            'description' => 'Module #2',
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        Module::create([
            'description' => 'Module #3',
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);
    }
}
