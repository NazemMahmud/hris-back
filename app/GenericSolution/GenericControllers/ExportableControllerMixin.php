<?php

namespace App\GenericSolution\GenericControllers;
use App\GenericSolution\GenericModels\ExportableModelMixin;
use Maatwebsite\Excel\Facades\Excel;

trait ExportableControllerMixin {
    public function export() {
        return Excel::download(new ExportableModelMixin, 'users.xlsx');
    }
}
