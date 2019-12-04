<?php

use App\Models\Setup\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DivisionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = [
            ['id' => 1, 'country_id' => 1, 'name' => 'Dhaka', 'isActive' => 0, 'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'country_id' => 1, 'name' => 'Khulna', 'isActive' => 1, 'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'country_id' => 1, 'name' => 'Rongpur', 'isActive' => 0, 'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        Division::insert($divisions);
    }
}
