<?php

namespace App\Http\Controllers\Setup;

use App\Models\Setup\Gender;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Base\BaseCollection;
use App\Http\Resources\Base\BaseResource;
use Illuminate\Http\Response;
use App\Http\Resources\Setup\Gender as GenderResource;
use App\Manager\RedisManager\RedisManager;
use App\Http\Resources\Setup\GenderCollection;

class GenderController extends Controller
{
    /**
     * @var Gender
     */
    private $gender;

    public function __construct(Gender $gender)
    {
        $this->gender = $gender;
    }

    /*
     * Display a listing of the resource.
     * @param Request $request
     * @return string
     */

    public function index(Request $request)
    {
        $orderBy = 'DESC';
        if ($request->orderBy) {
            $orderBy = $request->orderBy;
        }

        if ($request->searchBy) {
            return $this->searchResult($request->searchBy);
        }

        return new BaseCollection($this->gender->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return GenderResource|JsonResponse
     */
    public function store(Request $request)
    {
        return $this->gender->storeResource($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return $this->gender->getResourceById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return GenderResource
     */
    public function update(Request $request, $id)
    {
        return $this->gender->updateResource($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return GenderResource|JsonResponse
     */
    public function destroy($id)
    {
        return $this->gender->deleteResource($id);
    }

    public function searchResult($searchBy)
    {
        return new GenderCollection($this->gender->searchResource($searchBy));
    }
}
