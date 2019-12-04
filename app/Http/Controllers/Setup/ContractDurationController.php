<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Setup\ContractDurationRepository;
use App\Http\Resources\Setup\ContractDurationCollection;
use App\Http\Resources\Setup\ContractDuration;
class ContractDurationController extends Controller
{
    private $contractDurationRepository;
    public function __construct(ContractDurationRepository $contractDurationRepository)
    {
        $this->contractDurationRepository = $contractDurationRepository;
    }

    public function index(Request $request)
    {
        return new ContractDurationCollection($this->contractDurationRepository->all($request));
    }

    public function store(Request $request)
    {
        $result = $this->contractDurationRepository->store($request);
        return (is_object(json_decode($result))) === false ?  $result :  new ContractDuration($result);
    }


    public function show($id)
    {
        $result = $this->contractDurationRepository->show($id);
        return (is_object(json_decode($result))) === false ?  $result :  new ContractDuration($result);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $result = $this->contractDurationRepository->update($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new ContractDuration($result);
    }

    public function destroy($id)
    {
        $result = $this->contractDurationRepository->delete($id);
        return (is_object(json_decode($result))) === false ?  $result :  new ContractDuration($result);
    }
}
