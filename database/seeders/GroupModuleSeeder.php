<?php

namespace Database\Seeders;

use App\Models\GroupModule;
use Illuminate\Database\Seeder;

class GroupModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        GroupModule::create([
            'group_id' => 1,
            'modules_id' => 1,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        GroupModule::create([
            'group_id' => 1,
            'modules_id' => 2,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

        GroupModule::create([
            'group_id' => 1,
            'modules_id' => 3,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);
    }
}
