<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use App\Models\Base;
use App\Models\Employee\BasicInfoUpdateRequest;


class BasicInfo extends Base
{
    protected $table = "employee_basic_info";

    public function __construct($attributes = array())
    {
        parent::__construct($this);
        $this->fill($attributes);
    }

    public function Nationality() {
        return $this->hasOne('App\Models\Setup\Nationality');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee\Employee');
    }

    function getResourceById($id)
    {
        $resource['info'] = $this->model::where('staff_id', $id)->first();
        $resource['request'] = BasicInfoUpdateRequest::where('staff_id', $id)->first();

        if (empty($resource['info'])) return response()->json(['errors' => 'Resource not found'], 404);

        return $resource;
    }

    function storeResource($request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
            'familyName' => 'required',
            'givenName' => 'required',
            'familyNameBangla' => 'required',
            'givenNameBangla' => 'required',
            'genderId' => 'required',
            'maritalStatusId' => 'required',
            'languageId' => 'required',
            'nationalIdNumber' => 'required',
            'nationalIdIssueDate' => 'required',
            'nationalIdExpireDate' => 'required',
            'countryId' => 'required',
            'divisionId' => 'required',
            'districtId' => 'required'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $resource = BasicInfo::where('staff_id', '=', $request->staff_id )->first();

        if(empty($resource)){
            $resource = new BasicInfo();
        }
        $resource->staff_id = $request->staff_id ;
        $resource->familyName = $request->familyName ;
        $resource->givenName = $request->givenName ;
        $resource->familyNameBangla = $request->familyNameBangla ;
        $resource->givenNameBangla = $request->givenNameBangla ;
        $resource->genderId = $request->genderId ;
        $resource->maritalStatusId = $request->maritalStatusId ;

        $resource->languageId = $request->languageId ;
        $resource->nationalIdNumber = $request->nationalIdNumber ;
        $resource->nationalIdIssueDate = Helper::formatdateTime($request->nationalIdIssueDate);
        $resource->nationalIdExpireDate =  Helper::formatdateTime($request->nationalIdExpireDate);
        $resource->countryId = $request->countryId ;
        $resource->divisionId = $request->divisionId ;
        $resource->districtId = $request->districtId ;
        $resource->maritalDate = $request->maritalDate ;

        $resource->employeeImageUrl = $request->employeeImageUrl ;
        if($request->has('isActive')) $resource->isActive = $request->isActive ;
        if($request->has('isDefault')) $resource->isDefault = $request->isDefault ;
        if($request->has('dateofBirth')){
            $resource->dateofBirth = Helper::formatdateTime($request->dateofBirth);
        }


        $resource->save();

        return $resource;
    }

    function updateResource($request,$id)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
            'familyName' => 'required',
            'givenName' => 'required',
            'familyNameBangla' => 'required',
            'givenNameBangla' => 'required',
            'genderId' => 'required',
            'maritalStatusId' => 'required',
            'languageId' => 'required',
            'nationalIdNumber' => 'required',
            'nationalIdIssueDate' => 'required',
            'nationalIdExpireDate' => 'required',
            'countryId' => 'required',
            'divisionId' => 'required',
            'districtId' => 'required'
        ]);


        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);
        $data['info'] = $this->model::where('staff_id', $id)->first();
        if (empty($data['info'])) return response()->json(['errors' => 'Resource not found'], 404);

        $resource = BasicInfoUpdateRequest::where('staff_id', '=', $request->staff_id)->first();

        if(empty($resource)){
            $resource = new BasicInfoUpdateRequest();
        }

        $resource->basic_info_id = $data['info']->id;
        $resource->staff_id = $request->staff_id;
        $resource->familyName =  $this->checkRequestedData($data['info']->familyName, $request->familyName);
        $resource->givenName = $this->checkRequestedData($data['info']->givenName, $request->givenName) ;
        $resource->familyNameBangla = $this->checkRequestedData($data['info']->familyNameBangla, $request->familyNameBangla) ;
        $resource->givenNameBangla = $this->checkRequestedData($data['info']->givenNameBangla, $request->givenNameBangla) ;
        $resource->genderId = $this->checkRequestedData($data['info']->genderId, $request->genderId) ;
        $resource->maritalStatusId = $this->checkRequestedData($data['info']->maritalStatusId, $request->maritalStatusId);
        $resource->languageId = $this->checkRequestedData($data['info']->languageId, $request->languageId) ;
        $resource->nationalIdNumber = $this->checkRequestedData($data['info']->nationalIdNumber, $request->nationalIdNumber);
        $resource->nationalIdIssueDate = $this->checkRequestedData($data['info']->nationalIdIssueDate, Helper::formatdateTime($request->nationalIdIssueDate));
        $resource->nationalIdExpireDate =  $this->checkRequestedData($data['info']->nationalIdExpireDate, Helper::formatdateTime($request->nationalIdExpireDate));
        $resource->countryId = $this->checkRequestedData($data['info']->countryId,$request->countryId);
        $resource->divisionId = $this->checkRequestedData($data['info']->divisionId,$request->divisionId);
        $resource->districtId = $this->checkRequestedData($data['info']->districtId,$request->districtId);
        $resource->maritalDate = $this->checkRequestedData($data['info']->maritalDate,$request->maritalDate);
        $resource->status = 0;

        if($request->has('isActive')) $resource->isActive = $request->isActive ;
        if($request->has('isDefault')) $resource->isDefault = $request->isDefault ;

        if($request->has('dateofBirth')) $resource->dateofBirth =  $this->checkRequestedData($data['info']->dateofBirth, Helper::formatdateTime($request->dateofBirth));

        $resource->save();

        $data['info'] = $this->model::where('staff_id', $id)->first();
        $data['request'] = $resource;

        return $data;
    }

    public function checkRequestedData($info, $requested){
        return  $info != $requested? $requested : null;
    }
    public function uploadImage($request, $staffId)
    {
        $basicInfoImage = BasicInfo::where('employee_id', $staffId)->first();
        if ($request->image) {
            $file = $request->file('image');
            $filename = time() . "." . $file->getClientOriginalExtension();
            $location = public_path('files/');


            $file->move($location, $filename);
            $basicInfoImage->employeeImageUrl = asset('files/' . $filename);
        }

        $basicInfoImage->save();
        return "Image uploaded successfully";
    }
    public function getBasicInfoData($staff_id)
    {
        return BasicInfo::where('staff_id',$staff_id)->first();
    }


}
