<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\WorkingDayCollection;
use App\Http\Resources\Setup\WorkingDay;
use App\Repositories\Setup\WorkinDayRepository;
class WorkingDayController extends Controller
{
    private $workinDayRepository;
    public function __construct(WorkinDayRepository $workinDayRepository)
    {
        $this->workinDayRepository = $workinDayRepository;
    }

    public function index(Request $request)
    {
        return $this->workinDayRepository->all($request);
        //return new WorkingDayCollection($this->workinDayRepository->all($request));
    }
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->workinDayRepository->store($request);
        return (is_object(json_decode($result))) === false ?  $result :  new WorkingDay($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->workinDayRepository->show($id);
        return (is_object(json_decode($result))) === false ?  $result :  new WorkingDay($result);
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
        $result = $this->workinDayRepository->update($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new WorkingDay($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return PageResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->workinDayRepository->delete($id);
        return (is_object(json_decode($result))) === false ?  $result :  new WorkingDay($result);
    }

}
