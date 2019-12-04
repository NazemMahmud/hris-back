<?php

namespace App\Http\Controllers;

use App\Helpers\FileuploadHelpers;
use App\Models\FileuploadHelper;
use App\Models\File;
use Dotenv\Regex\Result;
use Illuminate\Http\Request;
// use App\Helpers\FileuploadHelpers;

class FileupdateHelperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    //    return $request->all();
    // return FileuploadHelpers::fileUpload($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->file('files'));
//        return $request->file('files');
//        return $request;
        // return (mb_convert_encoding($request, 'UTF-8'));
        return FileuploadHelpers::fileUpload($request);
        // $result = $this->Band->storeResource($request);
        // return (is_object(json_decode($result))) === false ?  $result :  new FileuploadHelpers($result);
        
    }
    

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
