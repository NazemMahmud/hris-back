<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Setup\TaxResponsibleRepository;
use App\Http\Resources\Setup\TaxResponsibleCollection;
use App\Http\Resources\Setup\TaxResponsible;
class TaxResponsibleController extends Controller
{
    private $taxResponsibleRepository;
    public function __construct(TaxResponsibleRepository $taxResponsibleRepository)
    {
        $this->taxResponsibleRepository = $taxResponsibleRepository;
    }

    public function index(Request $request)
    {
        return new TaxResponsibleCollection($this->taxResponsibleRepository->all($request));
    }

    public function store(Request $request)
    {
        $result = $this->taxResponsibleRepository->store($request);
        return (is_object(json_decode($result))) === false ?  $result :  new TaxResponsible($result);
    }


    public function show($id)
    {
        $result = $this->taxResponsibleRepository->show($id);
        return (is_object(json_decode($result))) === false ?  $result :  new TaxResponsible($result);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $result = $this->taxResponsibleRepository->update($request, $id);
        return (is_object(json_decode($result))) === false ?  $result :  new TaxResponsible($result);
    }

    public function destroy($id)
    {
        $result = $this->taxResponsibleRepository->delete($id);
        return (is_object(json_decode($result))) === false ?  $result :  new TaxResponsible($result);
    }
}
