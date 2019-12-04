<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Setup\Band;

class BandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bands = [
            ['id' => 1, 'name' => 'A', 'isActive' => 1,  'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'B', 'isActive' => 0,  'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'C', 'isActive' => 1,  'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'name' => 'D', 'isActive' => 1,  'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ];
        Band::insert($bands);
    }
}
