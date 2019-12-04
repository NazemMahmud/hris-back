<?php

namespace App\Repositories\Setup;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Setup\PaymentType;
use Illuminate\Http\Request;
/**
 * Class PaymentTypeReposatory.
 */
class PaymentTypeRepository
{
    private $paymentType;

    public function __construct(PaymentType $paymentType)
    {
        $this->paymentType = $paymentType;
    }

    public function all(Request $request)
    {
        $orderBy =$request->has('orderBy')?$request->orderBy:'DESC';
        return $this->paymentType->getAll($request->query('pageSize'),$orderBy);
    }
    public function store(Request $data)
    {
        return $this->paymentType->storeResource($data);
    }

    // update record in the database
    public function update(Request $request, $id)
    {
        return $this->paymentType->updateResource($request, $id);
    }

    public function show( $id)
    {
        return $this->paymentType->getResourceById($id);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->paymentType->deleteResource($id);
    }
}
