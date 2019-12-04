<?php

namespace App\Http\Controllers\Travel;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Base\BaseResource;
use App\Models\Travel\Travel;
use Illuminate\Http\Request;

class TravelController extends BaseController
{
    public function __construct(Travel $travel)
    {
        $this->EntityInstance = $travel;
        parent::__construct(); 
    }

    public function store(Request $request)
    {
        $result = $this->EntityInstance->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new BaseResource($result);
    }

    public function travelApprovalRequest(Request $request) {
        $travel = $this->EntityInstance->getTravelRequestData();
        if(!empty($travel)) {
            $data['data'] = $travel;
            return ($data); 
        } else {
            return response()->json(['message' => 'Resource not found'], 404);
        }
    }

    public function travelInvoiceApprovalRequest(Request $request) {
        $approval = $this->EntityInstance->getTravelInvoiceRequestData();
        if(!empty($approval)) {
            $data['data'] = $approval;
            return ($data); 
        } else {
            return response()->json(['message' => 'Resource not found'], 404);
        }
    }
}