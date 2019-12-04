<?php

use Illuminate\Database\Seeder;
use App\Models\Setup\EmployeeJobLevel;
class EmployeeJobLevelSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $job_level = [
            ['id'=>'1','name' => 'A',],
            ['id'=>'2','name' => 'B',],
            ['id'=>'3','name' => 'C',],
            ['id'=>'4','name' => 'D',],
            ['id'=>'5','name' => 'E',],
            ['id'=>'6','name' => 'F',],
            ['id'=>'7','name' => 'G',],
            ['id'=>'8','name' => 'H',],
            ['id'=>'9','name' => 'I',],
            ['id'=>'10','name' => 'J',],
            ['id'=>'11','name' => 'K',],
            ['id'=>'12','name' => 'L',],
            ['id'=>'13','name' => 'M',],
            ['id'=>'14','name' => 'N',],
            ['id'=>'15','name' => 'O',],
            ['id'=>'16','name' => 'P',],
            ['id'=>'17','name' => 'Q',],
            ['id'=>'18','name' => 'R',],
            ['id'=>'19','name' => 'S',],
            ['id'=>'20','name' => 'T',],

        ];

        EmployeeJobLevel::insert($job_level);
    }
}
