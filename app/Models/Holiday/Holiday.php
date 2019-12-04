<?php

namespace App\Models\Holiday;

use App\Models\Base;
use Carbon\Carbon;

class Holiday extends Base
{
    private $fixedHoliday;

    public function __construct()
    {
        parent::__construct($this);
        // $this->fixedHoliday = $fixedHoliday;
    }

    public function store($request)
    {
        if ($request->query('year')) {
            $fixedHolidays = $this->fixedHoliday->getAll();
            $holidays = [];

            foreach ($fixedHolidays as $fixedHoliday) {
                $holiday = new $this($this->fixedHoliday);

//                $date = date_create($request->year."-".$fixedHoliday->month."-".$fixedHoliday->days);
                $date = date("Y-m-d",  strtotime($request->year."-".$fixedHoliday->month."-".$fixedHoliday->days));

                $holiday->foreign_name = $fixedHoliday->foreign_name;
                $holiday->native_name = $fixedHoliday->native_name;
                $holiday->description = $fixedHoliday->description;
                $holiday->date = $date;

                $holiday->save();

                array_push($holidays, $holiday);
            }
            return json_encode($holidays);
        } else return response(['errors' => 'Year is required'], 404);
    }

    function isHoliday($date, $prevOrNext)
    {
        $prevOrNextDay = ($prevOrNext == 'previous') ? Carbon::parse($date)->subDays(1) : Carbon::parse($date)->addDays(1) ;
        $checkHoliday = Holiday::where('date', $prevOrNextDay)->first();

        return isset($checkHoliday);
    }
}
