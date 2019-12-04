<?php

namespace App\Models\Travel;

use App\Models\Base\BaseModel;

class TravelAllowance extends BaseModel
{
    protected $table = "travel_allowances";

    public function __construct()
    {
        parent::__construct($this);
    }
}
