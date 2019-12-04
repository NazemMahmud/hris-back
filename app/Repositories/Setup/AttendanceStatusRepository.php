<?php

namespace App\Repositories\Setup;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Setup\AttendanceStatus;
use Illuminate\Http\Request;
/**
 * Class PaymentTypeReposatory.
 */
class AttendanceStatusRepository
{
    private $attendanceStatus;

    public function __construct(AttendanceStatus $attendanceStatus)
    {
        $this->attendanceStatus = $attendanceStatus;
    }

    public function all(Request $request)
    {
        $orderBy =$request->has('orderBy')?$request->orderBy:'DESC';
        return $this->attendanceStatus->getAll($request->query('pageSize'),$orderBy);
    }

    public function store(Request $data)
    {
        return $this->attendanceStatus->storeResource($data);
    }

    // update record in the database
    public function update(Request $request, $id)
    {
        return $this->attendanceStatus->updateResource($request, $id);
    }

    public function show( $id)
    {
        return $this->attendanceStatus->getResourceById($id);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->employeeChilden->deleteResource($id);
    }
}
