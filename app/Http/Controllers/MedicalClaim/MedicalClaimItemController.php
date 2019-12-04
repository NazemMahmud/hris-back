<?php

namespace App\Http\Controllers\MedicalClaim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MedicalClaim\MedicalClaimItemCollection;
use App\Http\Resources\MedicalClaim\MedicalClaimItem as MedicalClaimItemResource;
use App\Models\MedicalClaim\MedicalClaimItem;

class MedicalClaimItemController extends Controller
{
    private $medicalClaimItem;

    function __construct(MedicalClaimItem $medicalClaimItem)
    {
        $this->medicalClaimItem = $medicalClaimItem;
    }

    public function index(Request $request)
    {
        $orderBy = 'DESC';
        if($request->orderBy)
        {
            $orderBy = $request->orderBy;
        }

        if($request->searchBy)
        {
            return  $this->searchResult($request->searchBy);
        }
        return new MedicalClaimItemCollection($this->medicalClaimItem->getAll($request->pageSize, $orderBy));
    }

    public function store(Request $request)
    {
        $result = $this->medicalClaimItem->storeResource($request, $request->query('medicalClaimRequestId'));
        return (is_object(json_decode($result))) === false ?  $result :  new MedicalClaimItemResource($result);
    }

    public function show($id)
    {
        $result = $this->medicalClaimItem->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new MedicalClaimItemResource($result);
    }

    public function update(Request $request, $id)
    {
        $result = $this->medicalClaimItem->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new MedicalClaimItemResource($result);
    }

    // public function destroy($id)
    // {
    //     $result = $this->medicalClaimItem->deleteResource($id);
    //     return (is_object(json_decode($result))) === false ?  $result :  new MedicalClaimItemResource($result);
    // }

    public function searchResult($searchBy)
    {
        return new MedicalClaimItemCollection( $this->medicalClaimItem->searchResource($searchBy));
    }
}
