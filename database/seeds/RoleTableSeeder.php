<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public $roles = [
        'admin', 'Manager', 'Hrbp'
    ];

    public function run() {
        foreach($this->roles as $role) {
            Role::create(['name' => $role]);
        };

        // $admin = User::where('name', 'admin')->first();
        // $admin->assignRole('admin');
    }
}
