<?php

namespace Database\Seeders;

use App\Models\ModuleTheme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ModuleTheme::create([
            'modules_id' => 1,
            'themes_id' => 1,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        ModuleTheme::create([
            'modules_id' => 1,
            'themes_id' => 2,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        ModuleTheme::create([
            'modules_id' => 1,
            'themes_id' => 3,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        ModuleTheme::create([
            'modules_id' => 2,
            'themes_id' => 1,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        ModuleTheme::create([
            'modules_id' => 2,
            'themes_id' => 2,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        ModuleTheme::create([
            'modules_id' => 2,
            'themes_id' => 3,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        ModuleTheme::create([
            'modules_id' => 3,
            'themes_id' => 1,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        ModuleTheme::create([
            'modules_id' => 3,
            'themes_id' => 2,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        ModuleTheme::create([
            'modules_id' => 3,
            'themes_id' => 3,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);
    }
}
