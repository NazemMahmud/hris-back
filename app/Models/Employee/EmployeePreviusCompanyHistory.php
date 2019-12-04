<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;

class EmployeepreviusCompanyHistory extends Base
{
    public function __construct( )
    {
        parent::__construct($this);
    }  

/**
     * @param $request
     * @return EmployeepreviusCompanyHistory
     */
    function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'staff_id' =>  'required',
            'division' =>  'required',
            'department' =>  'required',
            'unit' =>  'required',
            'job_level' =>  'required',
            'salary_formula' =>  'required',
            'salary' =>  'required',
            'tax_deducation' =>  'required',
            'pF_deduction' =>  'required',
            'start_date' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()], 404); 
        
        $resource = new EmployeepreviusCompanyHistory();

        $resource->staff_id = $request->staff_id;
        $resource->division = $request->division;
        $resource->department = $request->department;
        $resource->unit = $request->unit;
        $resource->job_level = $request->job_level;
        $resource->salary_formula = $request->salary_formula;
        $resource->salary = $request->salary;
        $resource->tax_deducation = $request->tax_deducation;
        $resource->pF_deduction = $request->pF_deduction;
        $resource->start_date = $request->start_date;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();

        return $resource;
    }

    /**
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    function updateResource($request, $id) {
        $resource = EmployeepreviusCompanyHistory::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'staff_id' =>  'required',
            'division' =>  'required',
            'department' =>  'required',
            'unit' =>  'required',
            'job_level' =>  'required',
            'salary_formula' =>  'required',
            'salary' =>  'required',
            'tax_deducation' =>  'required',
            'pF_deduction' =>  'required',
            'start_date' =>  'required',
            'isActive' => 'required',
            'isDefault' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->staff_id = $request->staff_id;
        $resource->division = $request->division;
        $resource->department = $request->department;
        $resource->unit = $request->unit;
        $resource->job_level = $request->job_level;
        $resource->salary_formula = $request->salary_formula;
        $resource->salary = $request->salary;
        $resource->tax_deducation = $request->tax_deducation;
        $resource->pF_deduction = $request->pF_deduction;
        $resource->start_date = $request->start_date;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;

        $resource->save();

        return $resource;
    }
}
