<?php

namespace App\Http\Controllers\Setup;

use App\Http\Resources\Setup\PageCollection;
use App\Http\Resources\Setup\Page as PageResource;
use App\Manager\RedisManager\RedisManager;
use App\Models\Setup\GroupPermission;
use App\Models\Setup\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    /**
     * @var Page
     */
    private $page;
    public $middleChild = [];

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return PageCollection
     */
    public function index(Request $request)
    {
        $orderBy = 'DESC';
        if ($request->orderBy) {
            $orderBy = $request->orderBy;
        }
        if ($request->searchBy) {
            return $this->searchResult($request->searchBy);
        }
        $pageSize = (isset($request->pageSize)) ? $request->pageSize : 0;
        return new PageCollection($this->page->getAll($pageSize, $orderBy));
    }

    public function getAllPagesForParent(){
        return new PageCollection($this->page->getAllPagesForParent());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return PageResource
     */
    public function store(Request $request)
    {
        $result = $this->page->storeResource($request);
        return (is_object(json_decode($result))) === false ? $result : new PageResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return PageResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->page->getResourceById($id);
        return (is_object(json_decode($result))) === false ? $result : new PageResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return PageResource
     */
    public function update(Request $request, $id)
    {
        $result = $this->page->updateResource($request, $id);
        return (is_object(json_decode($result))) === false ? $result : new PageResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return PageResource|JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->page->deleteResource($id);
        return (is_object(json_decode($result))) === false ? $result : new PageResource($result);
    }

    public function getPagesWithPermission($groupId)
    {
        $pagesForPermission = Page::all();
        foreach ($pagesForPermission as $pages) {
            $pages->groupId = $groupId;
        }
//        $pagesForPermission->groupId = $groupId;
//        dd($pagesForPermission);
        return new PageCollection($pagesForPermission);
    }

    public function searchResult($searchBy)
    {
        return new PageCollection($this->page->searchResource($searchBy));
    }

    /************************************************************/
    # Condition 1: Sort out and get those related Page ID (by back traversing ) which are related for this Group ID
    # Condition 2: Get pages which id is in #Condition-1 array
    # Condition 3: Insert those pages respective of parents
    # Condition 4: Create the menu tree && store and return as a JSON value

    /**
     * @param $arrayForPages
     * @param int $parent
     * @return array
     */
    function getMenuTree($arrayForPages, $parent = 0)
    {
        $menuTree = [];
        foreach ($arrayForPages[$parent] as $page) {

            $newMenu = new \stdClass();
            $newMenu->id = $page['id'];
            $newMenu->title = $page['name'];
            $newMenu->translate = $page['translate'];
            $newMenu->type = $page['type'];
            $newMenu->icon = $page['icon'];
            $newMenu->url = $page['link'];
            $newMenu->badge = $page['badge'];
            // check if there are children for this item
            if (isset($arrayForPages[$page['id']])) {
                $newMenu->children = $this->getMenuTree($arrayForPages, $page['id']); // and here we use this nested function recursively
            }
            $menuTree[] = $newMenu;
        }
        return $menuTree;
    }

    /**
     * @param $groupId
     * @return array
     */
    function hasPageIds($groupId)
    {
        $pages = GroupPermission::select('page_id')->where('group_id', $groupId)
            ->where('isChecked', 1)->orderBy('page_id')->get();
        $parentArray = [];
        foreach ($pages as $page) {
            $tempPageId = $page->page_id;
            while ($tempPageId > 0) {
                $checkParent = Page::where('id', $tempPageId)->first();
                array_push($parentArray, $checkParent->id);
                $tempPageId = $checkParent->parent_id;
            }
        }
        $pagesWithParent = array_unique($parentArray);
        sort($pagesWithParent);
        return $pagesWithParent;
    }

    /**
     * @param Request $request
     * @return array
     */
    function getPages(Request $request)
    {
        $dynamicMenuCache = RedisManager::DynamicMenuCacher();
        if(isset($request->groupId) && $request->groupId) {
            $pages =  $dynamicMenuCache->getMenus($request->groupId);
            if (!empty($pages)) {
                return $pages;
            } else{
                $arrayForPages = [];
                $workablePageIds = $this->hasPageIds($request->groupId);
//                return [ 'data' => $workablePageIds];
                $allPage = Page::whereIn('id', $workablePageIds)->get();
                foreach ($allPage as $page)
                    $arrayForPages [$page->parent_id][] = $page;
    
                if (!empty($arrayForPages)) {
                    $dynamicMenu = $this->getMenuTree($arrayForPages);
                    $data = [];
                    $data['data'] = $dynamicMenu;
                    $dynamicMenuCache->storeMenus($request->groupId, $data);
                    return $data;
                } else {
                    return ['message' => 'No page is defined for this user'];
                }
            }
        } else {
            return ['message' => 'No page is defined for this user'];
        }

    }

}
