<?php

use Illuminate\Database\Seeder;
use App\Models\Employee\BasicInfo;
class EmployeeBasicInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(BasicInfo::class, 10)->create();
    }
}