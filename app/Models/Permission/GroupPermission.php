<?php

namespace App\Models\Permission;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Support\Facades\DB;
/**
 * @method static Where(string $string, $groupId)
 */
class GroupPermission extends Base
{
    protected $table = "group_permissions";

    function __construct()
    {
        parent::__construct($this);
    }

    function updateResource($request) {
    	DB::beginTransaction();
    	foreach($request as $permission){
    		$groupPermission = GroupPermission::find($permission['permissions_id']);
    		$groupPermission->isChecked = $permission['isChecked'];
    		$groupPermission->permission = $permission['permission'];
    		$groupPermission->save();
    	}
    	DB::commit();
    	return json_encode('success');

    }
}
