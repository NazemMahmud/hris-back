<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@hris.com',
            'password' => bcrypt('@$gtu678BXC3#'),
            'staff_id' => 0
        ]);
    }
}
