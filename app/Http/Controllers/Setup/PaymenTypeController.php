<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setup\PaymenTypeCollection;
use App\Http\Resources\Setup\PaymenType as PaymenTypeResource;
use App\Repositories\Setup\PaymentTypeRepository;
class PaymenTypeController extends Controller
{
    private $paymentTypeRepository;
    public function __construct(PaymentTypeRepository $paymentTypeRepository)
    {
        $this->paymentTypeRepository = $paymentTypeRepository;
    }

    public function index(Request $request)
    {
        return new PaymenTypeCollection($this->paymentTypeRepository->all($request));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->paymentTypeRepository->store($request);
        return (is_object(json_decode($result))) === false ?  $result :  new PaymenTypeResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->paymentTypeRepository->show($id);
        return (is_object(json_decode($result))) === false ?  $result :  new PaymenTypeResource($result);
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
        $result = $this->paymentTypeRepository->update($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new PaymenTypeResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return PageResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->paymentTypeRepository->delete($id);
        return (is_object(json_decode($result))) === false ?  $result :  new PaymenTypeResource($result);
    }
}
