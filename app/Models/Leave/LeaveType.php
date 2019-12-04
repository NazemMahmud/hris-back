<?php

namespace App\Models\Leave;

use App\Models\Base;

class LeaveType extends Base
{
    protected $table="leave_types";

    function __construct()
    {
        parent::__construct($this);
    }

}
