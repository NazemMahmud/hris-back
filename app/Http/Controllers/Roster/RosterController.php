<?php

namespace App\Http\Controllers\Roster;


use App\Http\Controllers\BaseController;
use App\Models\Roster\RosterModel;

class RosterController extends BaseController
{
    public function __construct(RosterModel $roster)
    {
        $this->EntityInstance = $roster;
        parent::__construct();
    }
}
