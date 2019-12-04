<?php


namespace App\GenericSolution\GenericModels\ExportUtility;
use Illuminate\Support\Facades\DB;

class ImportUtility
{
    public static function getEntity($table = '', $key = '', $value = '') {
        if($table and $key and $value) {
            $entity = DB::table($table)->where($key, 'like', "%{$value}%")->first();
            return $entity ? $entity : null;
        }
        return null;
    }
    public static function IsNotExist($table = '', $key = '', $value = '') : bool {
        if($table and $key and $value) {
            $row = DB::table($table)->where($key, 'like', "%{$value}%")->first();
            return isset($row->id)? false : true;
        }
        return true;
    }
}
