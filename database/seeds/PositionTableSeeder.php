<?php

use App\Models\Setup\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            ['id' => 1, 'name' => 'Legal Advisor', 'code' => 'LA', 'isActive' => 0, 'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'Regional Manager', 'code' => 'RM', 'isActive' => 1, 'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'Chief Procurement Officer', 'code' => 'CPO', 'isActive' => 0, 'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        Position::insert($positions);
    }
}
