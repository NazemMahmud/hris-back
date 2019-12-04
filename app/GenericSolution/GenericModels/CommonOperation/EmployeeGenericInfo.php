<?php

namespace App\GenericSolution\GenericModels\CommonOperation;

use App\Models\Employee\EmployeeInfo;
use Illuminate\Support\Facades\DB;

class EmployeeGenericInfo {
    public static function getEmployeeBand($staff_id) {
        $band = DB::table('employee_info')->where('staff_id', '=', $staff_id)->select('band_id')->take(1)->get();
        if(!empty($band)) {
            return $band[0]->band_id;
        } else {
            return $band;
        }
    }
    public static function getFirstLineManagerId($staffId) {
        $line_manager = EmployeeInfo::select('lineManager_1st')->where('staff_id', $staffId)->first();
        return $line_manager->lineManager_1st;
    }

    public static function getSecondtLineManagerId($staffId) {
        $line_manager = EmployeeInfo::select('lineManager_2nd')->where('staff_id', $staffId)->first();
        return $line_manager->lineManager_2nd;
    }

    public static function getHrbpId($staffId) {
        $line_manager = EmployeeInfo::select('hrbp')->where('staff_id', $staffId)->first();
        return $line_manager->hrbp;
    }
} 