<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Setup\AttendanceStatusRepository;
use App\Http\Resources\Setup\AttendanceStatusCollection;
use App\Http\Resources\Setup\AttendanceStatus;

class AttendanceStatusController extends Controller
{
    private $attendanceStatusRepository;
    public function __construct(AttendanceStatusRepository $attendanceStatusRepository)
    {
        $this->attendanceStatusRepository = $attendanceStatusRepository;
    }


    public function index(Request $request)
    {
        return new AttendanceStatusCollection($this->attendanceStatusRepository->all($request));
    }

    public function store(Request $request)
    {
        $result = $this->attendanceStatusRepository->store($request);
        return (is_object(json_decode($result))) === false ?  $result :  new AttendanceStatus($result);
    }

    public function show($id)
    {
        $result = $this->attendanceStatusRepository->show($id);
        return (is_object(json_decode($result))) === false ?  $result :  new AttendanceStatus($result);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $result = $this->attendanceStatusRepository->update($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new AttendanceStatus($result);
    }

    public function destroy($id)
    {
        $result = $this->attendanceStatusRepository->delete($id);
        return (is_object(json_decode($result))) === false ?  $result :  new AttendanceStatus($result);
    }
}
