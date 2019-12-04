<?php

namespace App\Models\Roster;

use App\Models\Base\BaseModel;

class RosterModel extends BaseModel
{
    protected $table = "rosters";

    public function __construct()
    {
        parent::__construct($this);
    }

    public function SerializerFields()
    {
        return ['id', 'name', 'start_time', 'end_time'];
    }

    static public function PostSerializerFields()
    {
        return ['name', 'start_time', 'end_time', 'created_by', 'updated_by', 'deleted_by'];
    }

    static public function FieldsValidator()
    {
        return [
            'name' => 'required',
            'start_time' => 'required', 
            'end_time' => 'required'
        ];
    }

}
