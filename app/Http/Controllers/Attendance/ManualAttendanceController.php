<?php

namespace App\Http\Controllers\Attendance;

use App\Helpers\Helper;
use App\Http\Resources\Attendance\ManualAttendanceCollection;
use App\Models\Attendance\ManualAttendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use ReflectionException;
use App\Models\Employee\EmployeeInfo;
use App\Models\Attendance\ManualAttendanceApprovalRequest;

class ManualAttendanceController extends Controller
{
    private $manualAttendance;

    public function __construct(ManualAttendance $manualAttendance,ManualAttendanceApprovalRequest $manualAttendanceApprovalRequest)
    {
        $this->manualAttendance = $manualAttendance;
        $this->manualAttendanceApprovalRequest = $manualAttendanceApprovalRequest;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ManualAttendanceCollection
     * @throws ReflectionException
     */
    public function index()
    {
        return new ManualAttendanceCollection($this->manualAttendance->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ManualAttendance
     */
    public function store(Request $request)
    {
        $manual_attendance = new ManualAttendance;

        $manual_attendance->staff_id = $request->staff_id;
        $manual_attendance->in_time = Helper::formatTime($request->in_time);
        $manual_attendance->out_time = Helper::formatTime($request->out_time);
        $manual_attendance->date = Helper::formatdateTime($request->date);
        $manual_attendance->reason = $request->reason;

        $manual_attendance->save();
        $this->manualAttendanceApprovalRequest->manualAttendanceStore($manual_attendance->id,$request->staff_id);
        return $manual_attendance;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
