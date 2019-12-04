<?php

namespace App\Http\Controllers\Travel;

use App\Http\Controllers\BaseController;
use App\Models\Travel\TravelAllowanceSetup;

class TravelAllowanceSetupController extends BaseController
{
    public function __construct(TravelAllowanceSetup $setup)
    {
        $this->EntityInstance = $setup;
        parent::__construct();
    }
}
