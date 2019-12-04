<?php

namespace App\GenericSolution\GenericModelFields;

use Illuminate\Support\Facades\Auth;

class Fields {

    protected static $commonFields = ['created_by', 'updated_by'];

    public static function MakeCommonField($table) {
        $table->bigInteger('created_by');
        $table->bigInteger('updated_by');
        $table->bigInteger('deleted_by')->nullable();
        $table->softDeletes('deleted_at');
        $table->timestamps();
    }

    public static function AddCommonField($table) {
        $table->bigInteger('created_by')->nullable();
        $table->bigInteger('updated_by')->nullable();
        $table->bigInteger('deleted_by')->nullable();
        $table->softDeletes('deleted_at')->nullable();
    }

    public static function createCommonFields($fields, $resource): array {
        $user_id = Auth::user()->id;
        foreach($fields as $key => $field) {
            if(in_array($field, self::$commonFields)) {
                unset($fields[$key]);
                $resource->$field = $user_id;
            }
        }

        return [
            'fields' => $fields,
            'resource' => $resource
        ];
    }
}
