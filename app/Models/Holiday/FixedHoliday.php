<?php

namespace App\Models\Holiday;

use App\Models\Base;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class FixedHoliday extends Model
{
    public function __construct()
    {
        parent::__construct($this);
    }

    public function getResource($month) {
        $result = self::where('month', $month)->get();

        if (empty($result)) return response(['errors' => 'No data found'], 404);

        return $result;
    }

    public function storeResource($request) {
        $validator = Validator::make($request->all(), [
            'holiday_name' => 'required',
            'month' => 'required',
            'days' => 'required',
        ]);

        if ($validator->fails()) return response(['errors' => $validator->messages()], 404);

        $resource = new self();

        $resource->holiday_name = $request->holiday_name;
        $resource->month = $request->month;
        $resource->days = $request->days;

        $resource->save();

        return $resource;
    }

    public function updateResource($request, $month) {
        $resource = self::where('month', $month);

        if (empty($resource)) return response(['errors' => 'Resource not found'], 404);

        $validator = Validator::make($request->all(), [
            'holiday_name' =>  'required',
            'month' => 'required',
            'days' => 'required'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->messages()], 404);

        $resource->holiday_name = $request->holiday_name;
        $resource->month = $request->month;
        $resource->days = $request->days;

        $resource->save();

        return $resource;
    }
}
