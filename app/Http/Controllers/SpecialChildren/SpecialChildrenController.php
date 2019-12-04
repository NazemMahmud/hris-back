<?php

namespace App\Http\Controllers\SpecialChildren;

use App\Http\Resources\SpecialChildrenBenefit\SpecialChildrenForEmployeeCollection;
use App\Models\SpecialChildren\SpecialChildren;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialChildrenBenefit\SpecialChildren as SpecialChildrenResource;

class SpecialChildrenController extends Controller
{
    private $specialChildren;
    function __construct(SpecialChildren $specialChildren)
    {
        $this->specialChildren = $specialChildren;
    }

    public function getSpecialChildForEmployee(){
        return new SpecialChildrenForEmployeeCollection($this->specialChildren->getSpecialChildForEmployee());
    }

    public function getSpecialChild(Request $request){
        return new SpecialChildrenResource($this->specialChildren->getSpecialChild($request->id));
    }
}
