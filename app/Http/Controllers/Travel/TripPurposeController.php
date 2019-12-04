<?php

namespace App\Http\Controllers\Travel;

use App\Http\Controllers\BaseController;
use App\Models\Travel\TripPurpose;

class TripPurposeController extends BaseController
{
    public function __construct(TripPurpose $purpose)
    {
        $this->EntityInstance = $purpose;
        parent::__construct();
    }
}
