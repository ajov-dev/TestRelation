<?php

namespace Database\Seeders;

use App\Models\Instructor;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Instructor::create([
            'firstname' => 'Manuel',
            'lastname' => 'Jimenez',
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        Instructor::create([
            'firstname' => 'Juan',
            'lastname' => 'Perez',
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        Instructor::create([
            'firstname' => 'Pedro',
            'lastname' => 'Gonzalez',
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);
    }
}
