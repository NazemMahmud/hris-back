<?php

namespace App\Http\Controllers\Travel;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Base\BaseResource;
use App\Models\Travel\TravelAllowance;

class TravelAllowanceController extends BaseController  
{
    public function __construct(TravelAllowance $setup)
    {
        $this->EntityInstance = $setup;
        parent::__construct();
    }

    public function show($travel_id) {
        $allowance = TravelAllowance::where('travel_id', $travel_id)->take(1)->get();
        return new BaseResource($allowance);
    }
}
