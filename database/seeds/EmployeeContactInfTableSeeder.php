<?php

use Illuminate\Database\Seeder;
use App\Models\Employee\EmployeeContactInfo;

class EmployeeContactInfTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(EmployeeContactInfo::class, 10)->create();
    }
}