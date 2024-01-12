<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create([
            'academic_activity_id' => 1, // 'activity_id' => '1
            'description' => 'Group #1',
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);
        Group::create([
            'academic_activity_id' => 1, // 'activity_id' => '1
            'description' => 'Group #2',
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);
        Group::create([
            'academic_activity_id' => 1, // 'activity_id' => '1
            'description' => 'Group #3',
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);
    }
}
