<?php

namespace App\Repositories\Setup;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Setup\ContractDuration;
use Illuminate\Http\Request;
/**
 * Class PaymentTypeReposatory.
 */
class ContractDurationRepository
{
    private $contractDuration;

    public function __construct(ContractDuration $contractDuration)
    {
        $this->contractDuration = $contractDuration;
    }

    public function all(Request $request)
    {
        $orderBy =$request->has('orderBy')?$request->orderBy:'DESC';
        return $this->contractDuration->getAll($request->query('pageSize'),$orderBy);
    }

    public function store(Request $data)
    {
        return $this->contractDuration->storeResource($data);
    }

    // update record in the database
    public function update(Request $request, $id)
    {
        return $this->contractDuration->updateResource($request, $id);
    }

    public function show( $id)
    {
        return $this->contractDuration->getResourceById($id);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->contractDuration->deleteResource($id);
    }
}
