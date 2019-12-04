<?php

namespace App\Models\Travel;

use App\Models\ApprovalFlow\ApprovalFlowLevel;
use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Auth;

class TravelInvoiceApproval extends BaseModel
{
    protected $table = "travel_invoice_approval";

    public function __construct() 
    {
        parent::__construct($this);
    }

    public function travel() {
        return $this->belongsTo(Travel::class, 'travel_id', 'id');
    }

    public function invoice() {
        return $this->belongsTo(TravelInvoice::class, 'travel_invoice_id', 'id');
    }

    public function level() {
        return $this->belongsTo(ApprovalFlowLevel::class, 'current_level', 'id');
    }

    /**
     * Serializer field set for api purpose.
     */
    public function SerializerFields()
    {
        return ['id'];
    }

    public function getForeignKeyData() {
        return [
            'travel', 'invoice'
        ];
    }

    public function setHiddenFields()
    {
        return ['travel_id', 'travel_invoice_id'];
    }

}