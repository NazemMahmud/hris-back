<?php

namespace App\Models\MedicalClaim;

use App\Events\GenericRedisEvent;
use App\Models\Base;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use App\Models\MedicalClaim\MedicalClaimRequest;

class MedicalClaimItem extends Base
{

    function __construct()
    {
        parent::__construct($this);
    }

    function storeResource($request, $medicalClaimRequestId) {
        $validator = Validator::make($request->all(), [
            'receipt_description' =>  'required',
            'requested_amount' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = new MedicalClaimItem();

        $resource->medical_claim_request_id = $medicalClaimRequestId;
        $resource->receipt_description = $request->receipt_description;
        $resource->requested_amount = $request->requested_amount;
        $resource->settled_amount = $request->settled_amount;
        $resource->isActive = $request->isActive;
        $resource->isDefault = $request->isDefault;
        $resource->created_by = $request->created_by;
        $resource->updated_by = $request->updated_by;
        $resource->deleted_by = $request->deleted_by;

        $resource->save();
        event(new GenericRedisEvent($resource));

        return $resource;
    }

    function updateResource($request, $id) {
        $resource = MedicalClaimItem::find($id);

        if (empty($resource)) return response()->json(['message' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(),
        [
            'settled_amount' =>  'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource->settled_amount = $request->settled_amount;
        $resource->save();

        event(new GenericRedisEvent($resource));
        return $resource;
    }
    public function medicalClaimRequest()
    {
        return $this->hasMany(MedicalClaimRequest);
    }
}
