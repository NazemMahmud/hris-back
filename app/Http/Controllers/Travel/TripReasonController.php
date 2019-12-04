<?php

namespace App\Http\Controllers\Travel;

use App\Http\Controllers\BaseController;
use App\Models\Travel\TripReason;

class TripReasonController extends BaseController
{
    public function __construct(TripReason $reason)
    {
        $this->EntityInstance = $reason;
        parent::__construct();
    }
}
