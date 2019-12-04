<?php

namespace App\Repositories\Setup;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Setup\Occupation;
use Illuminate\Http\Request;
/**
 * Class PaymentTypeReposatory.
 */
class OccupationRepository
{
    private $occupation;

    public function __construct(Occupation $occupation)
    {
        $this->occupation = $occupation;
    }

    public function all(Request $request)
    {
        $orderBy =$request->has('orderBy')?$request->orderBy:'DESC';
        return $this->occupation->getAll($request->query('pageSize'),$orderBy);
    }

    public function store(Request $data)
    {
        return $this->occupation->storeResource($data);
    }

    // update record in the database
    public function update(Request $request, $id)
    {
        return $this->occupation->updateResource($request, $id);
    }

    public function show( $id)
    {
        return $this->occupation->getResourceById($id);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->occupation->deleteResource($id);
    }
}
