<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\NationalityCollection;
use App\Models\Setup\Nationality;
use App\Http\Resources\Setup\Nationality as NationalityResource;
use Illuminate\Http\Response;

class NationalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $nationality;

    function __construct(nationality $nationality)
    {
        $this->nationality = $nationality;
    }

    function index(Request $request)
    {
        $orderBy = 'DESC';
         if($request->orderBy) {
             $orderBy = $request->orderBy;
         }
         if($request->searchBy)
        {
            return $this->searchResult($request->searchBy);
        }
        return new NationalityCollection($this->nationality->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $result = $this->nationality->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new NationalityResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $result = $this->nationality->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new NationalityResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    function update(Request $request, $id)
    {
        $result = $this->nationality->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new NationalityResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    function destroy($id)
    {
        $result = $this->nationality->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new NationalityResource($result);
    }
    public function searchResult($searchBy)
    {
        return new nationalityCollection( $this->nationality->searchResource($searchBy));
    }
}