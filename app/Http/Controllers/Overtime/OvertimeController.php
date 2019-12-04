<?php

namespace App\Http\Controllers\Overtime;

use App\Models\Overtime\OvertimeApproval;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Manager\RedisManager\RedisManager;
use App\Http\Resources\Employee\EmployeeOvertime as EmployeeOvertimeResource;
use App\Http\Resources\Employee\EmployeeOvertimeCollection;
use App\Models\Overtime\Overtime;

class OvertimeController extends Controller
{
    private $employeeOvertime;

    function __construct(Overtime $employeeOvertime)
    {
        $this->employeeOvertime = $employeeOvertime;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*if ($request->search) {
            return $this->filter($request);
        }
        return new EmployeeOvertimeCollection($this->employeeInfo->getAll($request->query('pageSize'))); */

    }


    /**
     * * Store a newly created resource in storage.
     *
     * @return EmployeeOvertimeCollection|array
     */
    public function store()
    {
        $result = $this->employeeOvertime->storeOrUpdateResource();
        $noDataMessage = [
            ['data' => 'No Overtime data for today']
        ];
        if (empty($result))
            return $noDataMessage;

        return new EmployeeOvertimeCollection($result);
//        return $result;
    }

    /**
     * Get Overtime List for An Employee
     * @param Request $request
     * @return array
     */
    public function show(Request $request)
    {
        if ($request['staffId']) {
            $result = $this->employeeOvertime->getEmployeeOvertimeInfoById($request['staffId']);
            return ['data' => $result];
        }
        return [    'data' => [ 'errorMessage' => 'No record for this employee' ]   ];
    }

    public function overtimeBasicInfo(Request $request){
        if ($request['staffId']) {
            $result = $this->employeeOvertime->overtimeBasicInfo($request['staffId']);
            return ['data' => $result];
        }
        return [    'data' => [ 'errorMessage' => 'No record for this employee' ]   ];
    }
}