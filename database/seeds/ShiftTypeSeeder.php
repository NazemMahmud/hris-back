<?php

use Illuminate\Database\Seeder;
class ShiftTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shift_types')->insert([
            'name' => 'test',
            'graceTime' => rand( 1, 10 ),
            'daysOfWeek' => json_encode('thursday,sunday,monday,tuesday,wednesday'),
            'weekEnds' => json_encode('friday,saturday'),
            'startTime' =>'10:00:00',
            'endTime' => '20:00:00',
            'lunchStartTime' => '14:00:00',
            'lunchEndTime' => '14:30:00',
        ]);
    }
}