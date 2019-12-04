<?php

namespace App\Models\Travel;

use App\Models\Base\BaseModel;

class TravelAllowanceSetup extends BaseModel
{
    protected $table = "tallowances_setup";

    public function __construct()
    {
        parent::__construct($this);
    }

    public function SerializerFields()
    {
        return ['id', 'brand', 'total', 'breakfast', 
                'lunch', 'dinner', 'incidental', 'isActive'
        ];
    }

    static public function PostSerializerFields()
    {
        return ['brand', 'total', 'breakfast', 'lunch', 'dinner', 'incidental', 'isActive', 'created_by', 'updated_by', 'deleted_by'];
    }

    static public function FieldsValidator()
    {
        return [
            'brand' => 'required',
            'total' => 'required',
            'breakfast' => 'required',
            'lunch' => 'required',
            'dinner' => 'required',
            'incidental' => 'required'
        ];
    }

    public static function getAllowanceByBand($band_id) {
        $allowance = TravelAllowanceSetup::where('band', '=', $band_id)->get()->first();
        return $allowance;
    }
}
