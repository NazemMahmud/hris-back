<?php

namespace App\Models\Travel;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Validator;
use App\GenericSolution\GenericModelFields\Fields;

class TravelInvoice extends BaseModel 
{
    protected $table = "travel_invoices";
    public static $invoiceItem = null;

    public function __construct() 
    {
        parent::__construct($this);
    }

    static public function PostSerializerFields()
    {
        return ['travel_id', 'total_cost', 'status', 'remark', 'created_by', 'updated_by', 'deleted_by'];
    }

    static public function FieldsValidator()
    {
        return [
            'travel_id' => 'required',
            'total_cost' => 'required',
            'status' => 'required',
            'items' => 'required'
        ];
    }

    public function items() {
        return $this->hasMany(TravelInvoiceItem::class);
    }

    public function getForeignKeyData() {
        return [
            'items'
        ];
    }
    public function getItemsAttribute() {
        return self::$invoiceItem;
    }

    function storeResource($request) {
        $EntityModel = $this->model;
        $fields = $EntityModel::PostSerializerFields();

        $validator = Validator::make($request->all(), $EntityModel::FieldsValidator());

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new $EntityModel();
        $createCommonFields = Fields::createCommonFields($fields, $resource);
        $resource = $createCommonFields['resource'];
        $fields = $createCommonFields['fields'];

        foreach ($fields as $field) {
            $resource->$field = $request->$field;
        }

        $resource->save();

        $items = $request->items;
        foreach($items as $item) {
            $invoiceItems = new TravelInvoiceItem();
            $invoiceItems->name = $item['name'];
            $invoiceItems->cost = $item['cost'];
            $resource->items()->save($invoiceItems);
        }
        self::$invoiceItem = $items;
        $resource->setAppends(['items'])->toArray();

        //making a approval request for that
        $levelName = 'Travel invoice';
        $relatedFIelds = [
            'travel_id' => $resource->travel_id,
            'travel_invoice_id' => $resource->id
        ];
        $this->storeApprovalRequest(new TravelInvoiceApproval, $levelName, $relatedFIelds);
        
        return $resource;
    }

}
