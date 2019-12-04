<?php

namespace App\Models;
use App\Models\Setup\EmployeeDepartment;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Base\Collection;
use App\Manager\RedisManager\RedisManager;
use App\Events\GenericRedisEvent;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Base extends Model
{
    /**
     * @var Model
     */
    public $model;

    protected $CacheTable = false;

    use SoftDeletes;

    /**
     * Base constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }

    /**
     * @param int $resourcePerPage
     * @param string $orderBy
     * @return JsonResponse
     * @throws \ReflectionException
     */
    function getAll($resourcePerPage = 0, $orderBy = 'DESC') {
        $redis_cache = RedisManager::Generic();
        $reflection = new \ReflectionClass($this->model);
        $model_name = $reflection->getShortName();
        // with cache table
        if($this->model->CacheTable) {
            $data = $redis_cache->get($model_name);
            if($data) {
                //$resourcePerPage = $resourcePerPage == 0 ? 20 : $resourcePerPage;
                $collection = (new Collection($data))->paginate(10);
                return $collection;
            } else {
                if(method_exists($this, 'SerializerFields') && method_exists($this, 'getForeignKeyData')) {
                    $data = ($resourcePerPage == 0) ? $this->model::with($this->getForeignKeyData())
                    ->orderBy('created_at',$orderBy)->get($this->SerializerFields()):
                    $this->model::orderBy('created_at',$orderBy)->paginate($resourcePerPage);

                } else if(method_exists($this, 'SerializerFields')) {
                    $data = ($resourcePerPage == 0) ? $this->model::orderBy('created_at',$orderBy)->get($this->SerializerFields()):
                    $this->model::orderBy('created_at',$orderBy)->paginate($resourcePerPage);

                } else if(method_exists($this, 'getForeignKeyData')) {
                    $data = ($resourcePerPage == 0) ? $this->model::with($this->getForeignKeyData())
                    ->orderBy('created_at',$orderBy)->get():
                    $this->model::orderBy('created_at',$orderBy)->paginate($resourcePerPage);

                } else {
                    $data = ($resourcePerPage == 0) ? $this->model::orderBy('created_at',$orderBy)->get():
                    $this->model::orderBy('created_at',$orderBy)->paginate($resourcePerPage);
                }

                if(method_exists($this, 'setHiddenFields')) {
                    $data->makeHidden($this->setHiddenFields());
                }
                $redis_cache->store($model_name, $data);
                
                return $data;
            }
        }
        // No cache table 
        if(method_exists($this, 'SerializerFields') && method_exists($this, 'getForeignKeyData')) {
            $data = ($resourcePerPage == 0) ? $this->model::with($this->getForeignKeyData())
            ->orderBy('created_at',$orderBy)->get($this->SerializerFields()):
            $this->model::orderBy('created_at',$orderBy)->paginate($resourcePerPage);

        } else if(method_exists($this, 'SerializerFields')) {
            $data = ($resourcePerPage == 0) ? $this->model::orderBy('created_at',$orderBy)->get($this->SerializerFields()):
            $this->model::orderBy('created_at',$orderBy)->paginate($resourcePerPage);

        } else if(method_exists($this, 'getForeignKeyData')) {
            $data = ($resourcePerPage == 0) ? $this->model::with($this->getForeignKeyData())
            ->orderBy('created_at',$orderBy)->get():
            $this->model::orderBy('created_at',$orderBy)->paginate($resourcePerPage);

        } else {
            $data = ($resourcePerPage == 0) ? $this->model::orderBy('created_at',$orderBy)->get():
            $this->model::orderBy('created_at',$orderBy)->paginate($resourcePerPage);
        }
        if(method_exists($this, 'setHiddenFields')) {
            $data->makeHidden($this->setHiddenFields());
        }
        return $data;
    }


    function getResourceById($id) {
        if(method_exists($this, 'getForeignKeyData')) {
            $resource = $this->model::with($this->getForeignKeyData())->where('deleted_at', NULL)->find($id);
        } else {
            $resource = $this->model::where('deleted_at', NULL)->find($id);
        }
        if (empty($resource)) return response()->json(['errors' => 'Resource not found'], 404);

        return $resource;
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    function deleteResource($id) {
         $resource = $this->model::find($id);
        $resource->isActive = 0;
        $resource->save();

        if (empty($resource)) return response()->json(['message' => 'Resource not found.'], 404);

       //event(new GenericRedisEvent($resource));
         $resource->delete();

        return $resource;
    }

    function searchResource($searchBy)
     {
        $resource = $this->model::where('name', 'like', "%{$searchBy}%")->get();

        if (empty($resource)) return response()->json(['message' => 'Resource not found.']);
        return $resource ;
     }

     function getByColumnName($request, $column){
        return  $this->model::where($column, $request)->orderBy('id', 'desc')->get();
    }
}
