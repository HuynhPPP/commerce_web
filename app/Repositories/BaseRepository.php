<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Base;

/**
 * Class UserService
 * @package App\Services
 */
class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(
        Model $model
    ){
        $this->model = $model;
    }

    public function all(){
        return $this->model->all();
    }

    public function pagination(
        array $column = ['*'], 
        array $condition = [],
        array $join = [],
        array $extend = [],
        int $perpage = 1,
        array $relations = []
       
    ){
        $query = $this->model->select($column)->where(function($query) use ($condition){
            if(isset($condition['keyword']) && !empty($condition['keyword'])){
                $query->where('name', 'LIKE', '%'.$condition['keyword'].'%');
            }

            if(isset($condition['publish']) && $condition['publish'] !=0){
                $query->where('publish', '=', $condition['publish']);
            }
            return $query;

        });

        if(isset($relations) && !empty($relations)){
            foreach($relations as $relation){
                $query->withCount($relation);
            }
        }

        if(!empty($join)){
            $query->join(...$join);
        }

        return $query->paginate($perpage)
                     ->withQueryString()->withPath(env('APP_URL').$extend['path']);
                    
    }

    public function create(array $payload = []){
        $model = $this->model->create($payload);
        return $model->fresh();
    }

    public function update(int $id = 0, array $payload = [])
    {
        $model = $this->findById($id);
        return $model->update($payload);
    }

    public function updateByWhereIn($whereInField = '', array $whereIn = [], array $payload = [])
    {
        return $this->model->whereIn($whereInField, $whereIn)->update($payload);
    }

    public function delete(int $id = 0)
    {
        return $this->findById($id)->delete();
    }

    public function forceDelete(int $id = 0)
    {
        return $this->findById($id)->forceDelete();
    }

    public function findById(
        int $modelId,
        array $column = ['*'],
        array $relation = [],
    ){
        return $this->model->select($column)->with($relation)->findOrFail($modelId);
    }

    public function createLanguagePivot($model, array $payload = [])
    {
        return $model->languages()->attach($model->id, $payload);
    }

    

}