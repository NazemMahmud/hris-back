<?php

namespace App\Repositories\Setup;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Setup\TaxResponsible;
use Illuminate\Http\Request;
/**
 * Class PaymentTypeReposatory.
 */
class TaxResponsibleRepository
{
    private $taxResponsible;

    public function __construct(TaxResponsible $taxResponsible)
    {
        $this->taxResponsible = $taxResponsible;
    }

    public function all(Request $request)
    {
        $orderBy =$request->has('orderBy')?$request->orderBy:'DESC';
        return $this->taxResponsible->getAll($request->query('pageSize'),$orderBy);
    }

    public function store(Request $data)
    {
        return $this->taxResponsible->storeResource($data);
    }

    // update record in the database
    public function update(Request $request, $id)
    {
        return $this->taxResponsible->updateResource($request, $id);
    }

    public function show( $id)
    {
        return $this->taxResponsible->getResourceById($id);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->taxResponsible->deleteResource($id);
    }
}
