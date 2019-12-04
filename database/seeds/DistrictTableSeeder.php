<?php

use App\Models\Setup\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts = [
            ['id' => 1, 'division_id' => 1, 'name' => 'Magura', 'isActive' => 0, 'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'division_id' => 2, 'name' => 'Khulna', 'isActive' => 1, 'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'division_id' => 3, 'name' => 'Foridfur', 'isActive' => 0, 'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        District::insert($districts);
    }
}
