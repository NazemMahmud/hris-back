<?php

namespace App\Http\Controllers\Permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setup\Page;
use App\Models\Setup\Group;
use App\Models\Permission\GroupPermission;
use App\Http\Resources\Setup\GroupCollection;
class GroupPermissionController extends Controller
{
    private $Page;
    private $group;
    private $permissionData=[];
    private $groupPermission;
    public function __construct(Page $Page,Group $group,GroupPermission $groupPermission)
    {
        $this->Page = $Page;
        $this->group = $group;
        $this->groupPermission = $groupPermission;
    }
    public function index(Request $request){
        $orderBy = $request->has('orderBy')?$request->orderBy:'DESC';
        return new GroupCollection($this->group->getAll($request->query('pageSize'),$orderBy));
    }
    public function update(Request $request,$id)
    {
    }
    public function updateAll(Request $request)
    {
        $data = $request->all();
        return $result = $this->groupPermission->updateResource($data);
    }
    public function show($groupId)
    { 
        $mainPage = page::where('parent_id','=',0)->get();

        foreach($mainPage as $main){
            $subpage = page::where('parent_id','=',$main->id)->get();
            //return count($subpage);
            if($subpage && count($subpage )!=0){
                //return $subpage;
                foreach($subpage as $sub){
                    $subsubpage = page::where('parent_id','=',$sub->id)->get();
                    if($subsubpage && count($subsubpage )!=0){
                            foreach($subsubpage as $key=> $subsub){
                                $this->checkpermissionAndGetPermissionData($groupId,$subsub->id,$main->name,$sub->name,$subsub->name);
                            }
                    }else{
                            $this->checkpermissionAndGetPermissionData($groupId,$main->id,$main->name,$sub->name);
                    }
                }
            }else{
                    $this->checkpermissionAndGetPermissionData($groupId,$main->id,$main->name);
            }
        }
        return $this->permissionData;
    }
    public function checkpermissionAndGetPermissionData($groupId,$pageId,$mainpage=null,$subpage=null,$pageName=null){
		$permissionData=[];
		$permissions = GroupPermission::where('page_id','=',$pageId)->where('group_id','=',$groupId)->get();
		if($permissions){
			foreach($permissions as $key=> $permission){
				$data = array(
                    'tab' => $mainpage,
                    'module' => $subpage,
					'name' => $pageName,
					'isChecked' => $permission->isChecked,
					'permission' => $permission->permission,
					'page_id' => $permission->page_id,
					'group_id' => $permission->group_id,
					'permissions_id' => $permission->id,
                );
				 array_push($this->permissionData,$data);
			}
		}
		return $this->permissionData;
	}
    
}
