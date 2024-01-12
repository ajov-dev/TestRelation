<?php

namespace Database\Seeders;

use App\Models\AcademicActivity;
use Illuminate\Database\Seeder;

class AcademicActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicActivity::create([
            'description' => 'Class #1',
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        /**        AcademicActivity::create([
         * 'description' => 'Class #2',
         * 'created_by' => 'admin',
         * 'updated_by' => 'admin',
         * ]);
         *
         * AcademicActivity::create([
         * 'description' => 'Class #3',
         * 'created_by' => 'admin',
         * 'updated_by' => 'admin',
         * ]);
         **/
    }
}
