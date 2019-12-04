<?php

namespace App\Http\Controllers\MedicalClaim;

use App\Helpers\FileuploadHelpers;
use App\Models\MedicalClaim\MedicalClaimRequestFiles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MedicalClaim\MedicalClaimRequestCollection;
use App\Http\Resources\MedicalClaim\MedicalClaimRequest as MedicalClaimRequestResource;
use App\Models\MedicalClaim\MedicalClaimRequest;
use App\Http\Resources\MedicalClaim\MedicalClaimRequestStore;

class MedicalClaimRequestController extends Controller
{
    private $medicalClaimRequest;
    private $medicalClaimRequestFiles;

    function __construct(MedicalClaimRequest $medicalClaimRequest, MedicalClaimRequestFiles $medicalClaimRequestFiles)
    {
        $this->medicalClaimRequest = $medicalClaimRequest;
        $this->medicalClaimRequestFiles = $medicalClaimRequestFiles;
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
        return new MedicalClaimRequestCollection($this->medicalClaimRequest->getAll($request->pageSize, $orderBy));
    }

    public function store(Request $request)
    {
        $result = $this->medicalClaimRequest->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new MedicalClaimRequestStore($result);
    }

    public function show($id)
    {
        $result = $this->medicalClaimRequest->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new MedicalClaimRequestResource($result);
    }
    public function searchResult($searchBy)
    {
        return new MedicalClaimRequestCollection( $this->treatmentMode->searchResource($searchBy));
    }

    public function fileStore($medicalClaimRequestId, $file_paths){
        $this->medicalClaimRequestFiles->fileStore($medicalClaimRequestId, $file_paths);
    }

    public function fileUpload(Request $request, $medicalClaimRequestId){
        $data =  FileuploadHelpers::fileUpload($request);
        $this->fileStore($medicalClaimRequestId, $data);
        return $data;
    }

    public function update(Request $request, $id)
    {
        $result = $this->medicalClaimRequest->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new MedicalClaimRequestResource($result);
    }
}
