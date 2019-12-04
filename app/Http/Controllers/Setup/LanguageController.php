<?php

namespace App\Http\Controllers\Setup;

use App\Http\Resources\Setup\LanguageCollection;
use App\Models\Setup\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Http\Resources\Setup\Language as LanguageResource;

class LanguageController extends Controller
{
    /**
     * @var Language
     */
    private $language;

    function __construct(Language $language)
    {
        $this->language = $language;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return LanguageCollection
     */
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
        return new LanguageCollection($this->language->getAll($request->pageSize, $orderBy));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return LanguageResource|JsonResponse
     */
    function store(Request $request)
    {
        $result = $this->language->storeResource($request);
        return (is_object(json_decode($result))) === false ?  $result :  new LanguageResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return LanguageResource
     */
    function show($id)
    {
        $result = $this->language->getResourceById($id);
        return (is_object(json_decode($result))) === false ?  $result :  new LanguageResource($result);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse|LanguageResource
     */
    function update(Request $request, $id)
    {
        $result = $this->language->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new LanguageResource($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return JsonResponse|LanguageResource
     */
    public function destroy($id)
    {
        $result = $this->language->deleteResource($id);
        return (is_object(json_decode($result))) === false ?  $result :  new LanguageResource($result);
    }

    public function searchResult($searchBy)
    {
        return new languageCollection( $this->language->searchResource($searchBy));
    }
}