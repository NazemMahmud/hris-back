<?php

namespace App\Http\Controllers\MedicalSetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MedicalSetup\TreatmentModeCollection;
use App\Http\Resources\MedicalSetup\TreatmentMode as TreatmentModeResource;
use App\Models\MedicalSetup\TreatmentMode;

class TreatmentModeController extends Controller
{
    private $treatmentMode;

    function __construct(TreatmentMode $treatmentMode)
    {
        $this->treatmentMode = $treatmentMode;
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
        return new TreatmentModeCollection($this->treatmentMode->getAll($request->pageSize, $orderBy));
    }

    public function store(Request $request)
    {
        $result = $this->treatmentMode->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new TreatmentModeResource($result);
    }

    public function show($id)
    {
        $result = $this->treatmentMode->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new TreatmentModeResource($result);
    }

    public function update(Request $request, $id)
    {
        $result = $this->treatmentMode->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new TreatmentModeResource($result);
    }

    public function destroy($id)
    {
        $result = $this->treatmentMode->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new TreatmentModeResource($result);
    }

    public function searchResult($searchBy) 
    {
        return new TreatmentModeCollection( $this->treatmentMode->searchResource($searchBy));
    }
}
