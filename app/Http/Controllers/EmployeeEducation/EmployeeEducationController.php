<?php

namespace App\Http\Controllers\EmployeeEducation;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\EmployeeEducation\EmployeeEducationModel;


class EmployeeEducationController extends BaseController
{
    public function __construct(EmployeeEducationModel $employee_education)
    {
        $this->EntityInstance = $employee_education;
        parent::__construct();
    }
}
