<?php

use App\Models\MedicalSetup\TreatmentMode;
use Illuminate\Database\Seeder;

class TreatmentModeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $treatment_modes = [
            ['id'=>1, 'name' => 'OPD','isActive' => 1, 'isDefault' => 1, 'created_by' =>5, 'updated_by' =>5, 'deleted_by' => 6],
            ['id'=>2, 'name' => 'IPD','isActive' => 1, 'isDefault' => 1, 'created_by' =>5, 'updated_by' =>5, 'deleted_by' => 6],
            ['id'=>3, 'name' => 'Cashless','isActive' => 1, 'isDefault' => 1, 'created_by' =>5, 'updated_by' =>5, 'deleted_by' => 6]
        ];

        TreatmentMode::truncate()->insert($treatment_modes);
    }
}
