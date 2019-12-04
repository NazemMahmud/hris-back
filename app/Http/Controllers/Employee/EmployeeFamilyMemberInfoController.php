<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Employee\EmployeeFamilyInfoRepository;
use App\Http\Resources\Employee\EmployeeFamilyMemberInfo;
use App\Http\Resources\Employee\EmployeeFamilyMemberInfoCollection;
use App\Http\Resources\Employee\EmployeeFamilyMemberInfoStore;

class EmployeeFamilyMemberInfoController extends Controller
{
    private $employeeFamilyInfoRepository;
    public function __construct(EmployeeFamilyInfoRepository $employeeFamilyInfoRepository)
    {
       $this->employeeFamilyInfoRepository = $employeeFamilyInfoRepository;
    }
    public function index(Request $request)
    {
        //return new EmployeeFamilyMemberInfoCollection($this->employeeFamilyInfoRepository->all($request));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->employeeFamilyInfoRepository->store($request);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeFamilyMemberInfoStore($result);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->employeeFamilyInfoRepository->show($id);
        return (is_object($result)) ?  $result :  new EmployeeFamilyMemberInfo($result);
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
        $result = $this->employeeFamilyInfoRepository->update($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeFamilyMemberInfoStore($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return PageResource|JsonResponse
     */
    public function destroy($id)
    {
        return $result = $this->employeeFamilyInfoRepository->delete($id);
        return (is_object(json_decode($result))) === false ?  $result :  new EmployeeFamilyMemberInfoStore($result);

    }
}
