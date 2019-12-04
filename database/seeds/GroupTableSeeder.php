<?php

use App\Models\Setup\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            ['id' => 1, 'name' => 'Manager', 'isActive' => 1,  'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'HRBP', 'isActive' => 0,  'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        Group::insert($groups);
    }
}
