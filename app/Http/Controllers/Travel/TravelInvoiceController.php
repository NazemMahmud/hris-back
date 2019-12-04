<?php

namespace App\Http\Controllers\Travel;

use App\Http\Controllers\BaseController;
use App\Models\Travel\TravelInvoice;

class TravelInvoiceController extends BaseController
{
    public function __construct(TravelInvoice $travel)
    {
        $this->EntityInstance = $travel;
        parent::__construct(); 
    }

}
