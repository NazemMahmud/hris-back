<?php

namespace App\Models\Attendance;

use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class ManualAttendance extends Base
{
    public function __construct()
    {
        parent::__construct($this);
    }
}
