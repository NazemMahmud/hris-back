<?php

namespace App\Models\EmployeeEducation;

use App\Models\Base\BaseModel;

class EmployeeEducationModel extends BaseModel
{
    protected $table = "employeeeducations";
    public function __construct()
    {
        parent::__construct($this);
    }
   
    static public function PostSerializerFields()
    {
        return [
            'education_level', 'university_name', 'country_code', 'graduation_year', 'major', 'gpa'
        ];
    }

    static public function FieldsValidator()
    {
        return [
            'university_name' => 'required',
            'country_code' => 'required',
            'graduation_year' => 'required',
            'major' => 'required',
            'gpa' => 'required',
        ];
    }
}
