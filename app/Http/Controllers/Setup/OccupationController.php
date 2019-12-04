<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\OccupationCollection;
use App\Http\Resources\Setup\Occupation;
use App\Repositories\Setup\OccupationRepository;
class OccupationController extends Controller
{
    private $occupationRepository;
    public function __construct(OccupationRepository $occupationRepository)
    {
        $this->occupationRepository = $occupationRepository;
    }


    public function index(Request $request)
    {
        return new OccupationCollection($this->occupationRepository->all($request));
    }
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->occupationRepository->store($request);
        return (is_object(json_decode($result))) === false ?  $result :  new Occupation($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->occupationRepository->show($id);
        return (is_object(json_decode($result))) === false ?  $result :  new Occupation($result);
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
        $result = $this->occupationRepository->update($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new Occupation($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return PageResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->occupationRepository->delete($id);
        return (is_object(json_decode($result))) === false ?  $result :  new Occupation($result);
    }
}
