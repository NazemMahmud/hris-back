<?php

use App\Models\Setup\Relationship;
use Illuminate\Database\Seeder;

class RelationshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $relationships = [
            ['id'=>1, 'name' => 'Own','isActive' => 1, 'isDefault' => 1, ],
            ['id'=>2, 'name' => 'Spouse','isActive' => 1, 'isDefault' => 1, ],
            ['id'=>3, 'name' => 'Children','isActive' => 1, 'isDefault' => 1, ]
        ];

        Relationship::truncate()->insert($relationships);
    }
}
