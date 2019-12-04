<?php

use App\Models\Setup\ContractType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ContractTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contract_types = [
            ['id' => 1, 'name' => 'Full-Time', 'isActive' => 1,  'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'Part-time', 'isActive' => 0,  'isDefault' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'Full-Time', 'isActive' => 1,  'isDefault' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            
        ];
        ContractType::insert($contract_types);
    }
}
