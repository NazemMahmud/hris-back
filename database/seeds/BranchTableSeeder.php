<?php

use App\Models\Setup\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = [
            ['id' => 1, 'name' => 'Uttara', 'address' => 'Dhaka-1207', 'isHeadOffice'=> 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'Mirpur', 'address' => 'Dhaka-1206', 'isHeadOffice'=> 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'Gulshan', 'address' => 'Dhaka-1208', 'isHeadOffice'=> 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'name' => 'Savar', 'address' => 'Dhaka-1210', 'isHeadOffice'=> 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        Branch::insert($branches);
    }
}
