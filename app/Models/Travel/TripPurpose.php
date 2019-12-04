<?php

namespace App\Models\Travel;

use App\Models\Base\BaseModel;

class TripPurpose extends BaseModel
{
    protected $table = "trip_purpose";

    public function __construct()
    {
        parent::__construct($this);
    }

    public function SerializerFields()
    {
        return ['id', 'name'];
    }

    static public function PostSerializerFields()
    {
        return ['name', 'created_by', 'updated_by', 'deleted_by'];
    }

    static public function FieldsValidator()
    {
        return [
            'name' => 'required',
        ];
    }
}
