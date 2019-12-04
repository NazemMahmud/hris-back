<?php

namespace App\Http\Controllers\Setup;

use App\Http\Resources\Setup\Relationship as RelationshipResource;
use App\Http\Resources\Setup\RelationshipCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setup\Relationship;

class RelationshipController extends Controller
{
    private $relationship;

    public function __construct(Relationship $relationship)
    {
        $this->relationship= $relationship;
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
        return new RelationshipCollection($this->relationship->getAll($request->pageSize, $orderBy));
    }

    public function store(Request $request)
    {

        $result = $this->relationship->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new RelationshipResource($result);
    }

    public function show($id)
    {
        $result = $this->relationship->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new RelationshipResource($result);
    }

    public function update(Request $request, $id)
    {
        $result = $this->relationship->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new RelationshipResource($result);
    }

    public function destroy($id)
    {
        $result = $this->relationship->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new RelationshipResource($result);
    }

    public function searchResult($searchBy) 
    {
        return new RelationshipCollection( $this->relationship->searchResource($searchBy));
    }
}
