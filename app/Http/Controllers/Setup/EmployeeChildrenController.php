<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\EmployeeChildrenCollection;
use App\Http\Resources\Setup\EmployeeChildren;
use App\Repositories\Setup\EmployeeChildrenRepository;
class EmployeeChildrenController extends Controller
{
    private $employeeChildrenRepository;
    public function __construct(EmployeeChildrenRepository $employeeChildrenRepository)
    {
        $this->employeeChildrenRepository = $employeeChildrenRepository;
    }


    public function index(Request $request)
    {
        return new EmployeeChildrenCollection($this->employeeChildrenRepository->all($request));
    }
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->employeeChildrenRepository->store($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeChildren($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->employeeChildrenRepository->show($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeChildren($result);
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
        $result = $this->employeeChildrenRepository->update($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeChildren($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return PageResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->employeeChildrenRepository->delete($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeChildren($result);
    }
}
