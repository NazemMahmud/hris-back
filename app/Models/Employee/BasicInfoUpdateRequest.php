<?php

namespace App\Models\Employee;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class BasicInfoUpdateRequest extends Base
{
    public function __construct($attributes = array())
    {
        parent::__construct($this);
        $this->fill($attributes);
    }
    public function basicInfoUpdateRequest($staff_id)
    {
        return BasicInfoUpdateRequest::where('staff_id',$staff_id)->where('status',0)->first();
    }
    public function basicInfoHistoryUpdateRequest($staff_id)
    {
        return BasicInfoUpdateRequest::where('staff_id',$staff_id)->where('status','<>',0)->first();
    }
    public function basicInfoRequest($staff_id)
    {
        return BasicInfoUpdateRequest::where('staff_id',$staff_id)->first();
    }
    public function basicInfoRequestRejected($staff_id)
    {
        return BasicInfoUpdateRequest::where('staff_id',$staff_id)->first();
    }

}
