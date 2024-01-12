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
            'description' => 'Default',
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        Theme::create([
            'description' => 'Dark',
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        Theme::create([
            'description' => 'Light',
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

    }
}
