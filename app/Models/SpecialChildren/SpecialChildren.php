<?php

namespace App\Models\SpecialChildren;

use App\Models\Employee\EmployeeChildrenInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SpecialChildren extends Model
{
    function getSpecialChildForEmployee(){
        return EmployeeChildrenInfo::where('staff_id', Auth::user()->staff_id)
            ->where('isSpecial', 1)->get();
    }

    function getSpecialChild($id){
        return EmployeeChildrenInfo::find($id);
    }
}
