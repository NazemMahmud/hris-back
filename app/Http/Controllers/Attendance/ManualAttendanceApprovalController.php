<?php

namespace App\Http\Controllers\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Employee\EmployeeManualAttendanceRepository;
class ManualAttendanceApprovalController extends Controller
{

    public function __construct(EmployeeManualAttendanceRepository $EmployeeManualAttendanceRepository)
    {
        $this->EmployeeManualAttendanceRepository = $EmployeeManualAttendanceRepository;
    }

    public function manualAttendanceAcceptance(Request $request, $manualAttendanceId)
    {
        return $this->EmployeeManualAttendanceRepository->manualAttendanceAcceptance($request, $manualAttendanceId);
    }
}
