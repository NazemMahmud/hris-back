<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Setup\EducationLevel;

class EducationLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $education_levels = [
            ['id' => 1, 'name' => 'SSc', 'isActive' => 1, 'isDefault' => 0, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'HSc', 'isActive' => 0, 'isDefault' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'B.Sc', 'isActive' => 1, 'isDefault' => 0, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['id' => 4, 'name' => 'M.Sc', 'isActive' => 1, 'isDefault' => 0, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['id' => 5, 'name' => 'Phd', 'isActive' => 0, 'isDefault' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['id' => 6, 'name' => 'B.com', 'isActive' => 0, 'isDefault' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
        ];
        EducationLevel::insert($education_levels);
    }
}
