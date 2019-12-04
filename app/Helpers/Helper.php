<?php

namespace App\Helpers;
use App\Models\Employee\EmployeeInfo;
use App\User;
use Auth;
class Helper{

    public static function weekends($daysOfWeeks) {
        $weekends = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
        foreach ($daysOfWeeks as $daysOfWeek){
            if (strtolower($daysOfWeek)=='saturday')$weekends = array_diff($weekends, array('Saturday'));
            if (strtolower($daysOfWeek)=='sunday')$weekends = array_diff($weekends, array('Sunday'));
            if (strtolower($daysOfWeek)=='monday')$weekends = array_diff($weekends, array('Monday'));
            if (strtolower($daysOfWeek)=='tuesday')$weekends = array_diff($weekends, array('Tuesday'));
            if (strtolower($daysOfWeek)=='wednesday')$weekends = array_diff($weekends, array('Wednesday'));
            if (strtolower($daysOfWeek)=='thursday')$weekends = array_diff($weekends, array('Thursday'));
            if (strtolower($daysOfWeek)=='friday')$weekends = array_diff($weekends, array('Friday'));

        }
        return implode(",",$weekends);
    }
    public static function checkIfLeaveRequestOnvalidTimeOrDate($startDate) {
        $startDate = (string)strtolower(date('l', strtotime($startDate)));
        $employee = EmployeeInfo::where('employee_id',Auth::user()->id)->first();
        $shiftInfo = EmployeeInfo::find($employee->id)->shiftType;
        $shiftInfo = explode(",",json_decode($shiftInfo->weekEnds));
        return in_array($startDate,$shiftInfo)?false:true;
    }
    public static function formatdateTime($datetime) {
        $datetime = strtotime($datetime);
        return  date('Y-m-d h:i:s',$datetime);
    }
    public static function formatdate($date) {
        $data = strtotime($date);
        return  date('Y-m-d',$data);
    }
    public static function formatTime($time) {
        $time = strtotime($time);
        return date('h:i:s',$time);
    }
    public static function UniqueString() {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = substr(str_shuffle(str_repeat($pool, 20)), 0, 50);
        $microtime = microtime(true);
        return $randomString.$microtime;
    }

}
