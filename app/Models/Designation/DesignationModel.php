<?php

namespace App\Models\Designation;

use Illuminate\Database\Eloquent\Model;

class DesignationModel extends Model
{
    protected $table = 'designation';
    protected $fillable = [
        'name'
    ];
}
