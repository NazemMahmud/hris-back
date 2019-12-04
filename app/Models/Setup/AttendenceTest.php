<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Events\GenericRedisEvent;

class AttendenceTest extends Base
{
    protected $CacheTable = true;
    protected $table = 'attendance_test';

    function __construct()
    {
        parent::__construct($this);
    }

}
