<?php

namespace App\Http\Controllers\Holiday;

use App\Http\Controllers\Controller;
use App\Http\Resources\Base\BaseCollection;
use App\Http\Resources\Holiday\HolidayCollection;
use App\Http\Resources\Holiday\Holiday as HolidayResource;
use App\Models\Holiday\Holiday;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HolidayController extends Controller
{
    private $holiday;

    public function __construct(Holiday $holiday)
    {
        $this->holiday = $holiday;
    }

    /**
     * @return HolidayCollection
     */
    public function index()
    {
        return new HolidayCollection($this->holiday->getAll());
    }

    /**
     * @param $id
     * @return HolidayResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->holiday->deleteResource($id);
        return (is_object(json_decode($result))) === false ? $result : new HolidayResource($result);
    }

    /**
     * @param $id
     * @return HolidayResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->holiday->getResourceById($id);
        return (is_object(json_decode($result))) === false ? $result : new HolidayResource($result);
    }

    public function store(Request $request)
    {
        $result = $this->holiday->store($request);
        return (is_object(json_decode($result))) === false ? $result : new HolidayCollection($result);
    }

    public function getHolidaysWithIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $start_date = date("Y-m-d", $request->start_date / 1000);
        $end_date = date("Y-m-d", $request->end_date / 1000);
//        return array( 'start_date' => $start_date, 'end_date' => $end_date);
        $holidyas = DB::table('holidays')->whereBetween('date', [$start_date, $end_date])->get();

        if (empty($holidyas)) return response()->json(['message' => 'Resource not found'], 404);
        return [
            'data' => count($holidyas)
        ];
    }
}
