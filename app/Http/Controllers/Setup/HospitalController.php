<?php

namespace App\Http\Controllers\Setup;

use App\Models\Setup\Hospital;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Base\BaseCollection;
use App\Http\Resources\Setup\HospitalCollection;
use App\Http\Resources\Setup\Hospital as HospitalResource;

class HospitalController extends Controller
{
    private $hospital;

    public function __construct(Hospital $hospital)
    {
        $this->hospital = $hospital;
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
        return new BaseCollection($this->hospital->getAll($request->pageSize, $orderBy));
    }

    public function store(Request $request)
    {
       $result = $this->hospital->storeResource($request);
       return $result;
    }

    public function show($id)
    {
        $result = $this->hospital->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new HospitalResource($result);
    }

    public function update(Request $request, $id)
    {
        $result = $this->hospital->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new HospitalResource($result);
    }

    public function destroy($id)
    {
        $result = $this->hospital->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new HospitalResource($result);
    }

    public function searchResult($searchBy) 
    {
        return new HospitalCollection( $this->hospital->searchResource($searchBy));
    }
}
