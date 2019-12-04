<?php

namespace App\Repositories\Setup;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Setup\WorkingDay;
use Illuminate\Http\Request;
/**
 * Class PaymentTypeReposatory.
 */
class WorkinDayRepository
{
    private $workingDay;

    public function __construct(WorkingDay $workingDay)
    {
        $this->workingDay = $workingDay;
    }

    public function all(Request $request)
    {
        $orderBy =$request->has('orderBy')?$request->orderBy:'DESC';
        return $this->workingDay->getAll($request->query('pageSize'),$orderBy);
    }

    public function store(Request $data)
    {
        return $this->workingDay->storeResource($data);
    }

    // update record in the database
    public function update(Request $request, $id)
    {
        return $this->workingDay->updateResource($request, $id);
    }

    public function show( $id)
    {
        return $this->workingDay->getResourceById($id);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->workingDay->deleteResource($id);
    }
}
