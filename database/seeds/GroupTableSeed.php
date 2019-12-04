<?php

use Illuminate\Database\Seeder;
use App\Models\Setup\Group;
class GroupTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group_data = [
            ['id'=>1, 'name' => 'Manager', 'description' => 'Manager Group', 'isActive' => 0, 'isDefault' => 0],
            ['id'=>2, 'name' => 'Executive', 'description' => 'Executive Group', 'isActive' => 0, 'isDefault' => 1],
            ['id'=>3, 'name' => 'VP', 'description' => 'VP Group', 'isActive' => 1, 'isDefault' => 1],
            ['id'=>4, 'name' => 'Admin', 'description' => 'Admin Group', 'isActive' => 1, 'isDefault' => 1],
        ];

        Group::insert($group_data);
    }
}
