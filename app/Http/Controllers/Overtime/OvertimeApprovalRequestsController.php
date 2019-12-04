<?php

namespace App\Http\Controllers\Overtime;

use App\Models\Overtime\OvertimeApproval;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Overtime\Overtime;

class OvertimeApprovalRequestsController extends Controller
{
    private $overtimeApproval;

    function __construct(OvertimeApproval $overtimeApproval)
    {
        $this->overtimeApproval = $overtimeApproval;
    }


    public function claim(Request $request){

        $result = $this->overtimeApproval->storeResource($request['overTimeId']);
        if(isset($result))
            return ['data' => $result];

        return [    'data' => [ 'errorMessage' => 'Could not claim your request' ]   ];
    }



    public function getOvertimeApprovalLists(Request $request){
        if($request['mssId']){
            $result = $this->overtimeApproval->getMssOvertimeList($request['mssId']);
            return [ 'data' => $result ];
        }
    }

    public function overtimeAcceptance(Request $request){
        if($request['mssId']){
            $result = $this->overtimeApproval->overtimeAcceptance($request);
            return [ 'data' => $result ];
        }
    }
}
