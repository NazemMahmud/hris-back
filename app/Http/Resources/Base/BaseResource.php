<?php

namespace App\Http\Resources\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @author Fazlul Kabir Shohag <shohag.fks@gmail.com>
 */
class BaseResource extends JsonResource
{
    private static $SerializerFields = null;

    static public function SerializerFieldsSet($fields) {
        self::$SerializerFields = $fields;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request
     * @return array
     */
    public function toArray($request)
    {
        $fields = array();
        if(self::$SerializerFields) {
            foreach (self::$SerializerFields as $field) {
                $fields[$field] = $this->$field;
            }
        }
        if($fields) {
            return $fields;
        } else {
           return parent::toArray($request);
        }
    }
}
