<?php

namespace App\Repositories\Setup;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Setup\Relationship;
use Illuminate\Http\Request;
/**
 * Class PaymentTypeReposatory.
 */
class RelationShipRepository
{
    private $relationship;

    public function __construct(Relationship $relationship)
    {
        $this->relationship = $relationship;
    }

    public function all(Request $request)
    {
        return  $this->relationship->getAll();
        $orderBy =$request->has('orderBy')?$request->orderBy:'DESC';
//        return $this->workingDay->getAll($request->query('pageSize'),$orderBy);
    }

    public function store(Request $data)
    {
        return $this->relationship->storeResource($data);
    }

    // update record in the database
    public function update(Request $request, $id)
    {
        return $this->relationship->updateResource($request, $id);
    }

    public function show( $id)
    {
        return $this->relationship->storeResource($id);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->relationship->deleteResource($id);
    }
}
