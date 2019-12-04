<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\EducationLevelCollection;
use App\Http\Resources\Setup\EducationLevel as EducationLevelResource;
use App\Models\Setup\EducationLevel;
use Illuminate\Http\JsonResponse;


class EducationLevelController extends Controller
{
    /**
     * @var EducationLevel
     */
    private $educationLevel;

    public function __construct(EducationLevel $educationLevel)
    {
        $this->educationLevel = $educationLevel;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return EducationLevelCollection
     */
    public function index(Request $request)
    {
        $orderBy = 'DESC';
        if($request->orderBy) 
        {
            $orderBy = $request->orderBy;
        }
        if($request->searchBy)
        {
            return $this->searchResult($request->searchBy);
        }
        return new EducationLevelCollection($this->educationLevel->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return EducationLevelResource
     */
    public function store(Request $request)
    {
        $result = $this->educationLevel->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EducationLevelResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return EducationLevelResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->educationLevel->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EducationLevelResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return EducationLevelResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->educationLevel->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EducationLevelResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return EducationLevelResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->educationLevel->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EducationLevelResource($result);
    }

    public function searchResult($searchBy)
    {
        return new EducationLevelCollection( $this->educationLevel->searchResource($searchBy));
    }
}
