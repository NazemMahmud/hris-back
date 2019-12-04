<?php

namespace App\Http\Controllers\Travel;

use App\Http\Controllers\BaseController;
use App\Models\Travel\TripType;

class TripTypeController extends BaseController
{
    public function __construct(TripType $type)
    {
        $this->EntityInstance = $type;
        parent::__construct();
    }
}
