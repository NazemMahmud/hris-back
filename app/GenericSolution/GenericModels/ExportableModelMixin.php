<?php

namespace App\GenericSolution\GenericModels;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\GenericSolution\GenericModels\ExportUtility\GenericExport;

class ExportableModelMixin  implements FromCollection{
    public function collection() {
        return GenericExport::$ExportableModel->all();
    }
}
