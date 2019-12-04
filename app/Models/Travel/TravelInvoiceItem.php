<?php

namespace App\Models\Travel;
use App\Models\Base\BaseModel;

class TravelInvoiceItem extends BaseModel
{
    protected $table = "travel_invoice_items";
    public $timestamps = false;

    public function __construct() 
    {
        parent::__construct($this);
    }
}
