<?php

namespace App\Http\Controllers\Travel;

use App\Http\Controllers\BaseController;
use App\Models\Travel\ModeOfTrip;

class ModeOfTravelController extends BaseController
{
    public function __construct(ModeOfTrip $mode)
    {
        $this->EntityInstance = $mode;
        parent::__construct();
    }
}
