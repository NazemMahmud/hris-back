<?php

use App\Models\Setup\MaritalStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class MaritalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $marital_statuses = [
            ['id' => 1, 'name' => 'Married', 'code' => 'M', 'isActive' => 1, 'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'Unmarried', 'code' => 'UM', 'isActive' => 0, 'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'Single', 'code' => 'Sl', 'isActive' => 1, 'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        MaritalStatus::insert($marital_statuses);
    }
}
