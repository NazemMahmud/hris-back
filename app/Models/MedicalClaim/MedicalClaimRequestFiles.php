<?php

namespace App\Models\MedicalClaim;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class MedicalClaimRequestFiles extends Model
{
    protected $table = 'medical_claim_request_files';

    public function fileStore($medicalClaimRequestId, $file_paths){

        foreach ($file_paths as $file_path) {
            $resource  = new MedicalClaimRequestFiles();
            $resource->medical_claim_request_id = $medicalClaimRequestId;
            $resource->file_path = $file_path;
            $resource->created_by = Auth::user()->staff_id;
            $resource->updated_by = Auth::user()->staff_id;
            $resource->save();
        }
    }
}
