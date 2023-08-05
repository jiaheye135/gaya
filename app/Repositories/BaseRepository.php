<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasCrud;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    use HasCrud;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string
     */
    protected $uniqueIdCol;

    /**
     * @param Application $app
     *
     * @throws \Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
        $this->setUniqueIdCol();
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    abstract public function model();

    /**
     * Make Model instance
     *
     * @throws \Exception
     *
     * @return Model
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Configure the Unique Id Column
     *
     * @return string
     */
    abstract public function uniqueIdCol();

    /**
     * Configure the Unique ID Column
     *
     * @return void
     */
    protected function setUniqueIdCol(){
        $this->uniqueIdCol = $this->uniqueIdCol();
    }

    /**
     * 檢查唯一值是否存在
     *
     * @param mixed $id
     * @return boolean
     * @author Rick
     */
    public function isUniqueIdExists($id): bool
    {
        return $this->model->newQuery()->where($this->uniqueIdCol, $id)->exists();
    }

    /**
     * 建立唯一ID
     *
     * @param array &$checkDup 目前尚未新增DB但已產生的ID
     *
     * @return string 唯一ID
     */
    public function createUniqueId(array &$checkDup = [])
    {
        while(true){
            $id = md5(uniqid() . microtime(true));
            $exists = $this->isUniqueIdExists($id);
            if( !$exists && !in_array($id, $checkDup) ){
                $checkDup[] = $id;
                break;
            }
        }
        return $id;
    }

    /**
     * Find model record for given id
     *
     * @param int $id
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function findOneById($id, $columns = ['*'])
    {
        $query = $this->model->newQuery();

        return $query->where($this->uniqueIdCol, $id)->select($columns)->first();
    }

    /**
     * Find model record for given multiple ids
     *
     * @param int $id
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findMultiByIds(array $ids, $columns = ['*'])
    {
        $query = $this->model->newQuery();

        return $query->whereIn($this->uniqueIdCol, $ids)->select($columns)->get();
    }

    /**
     * Create model record
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input)
    {
        $model = $this->model->newInstance($input);

        $model->save();

        return $model;
    }

    /**
     * Update model record for given id
     *
     * @param array $input
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function update($input, $id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * Update model record by unique id
     *
     * @param array $input
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function updateByUniqueId($input, $id)
    {
        $query = $this->model->newQuery();

        $model = $query->where($this->uniqueIdCol, $id)->firstOrFail();

        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * @param int $id
     *
     * @throws \Exception
     *
     * @return bool|mixed|null
     */
    public function delete($id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        return $model->delete();
    }

    /**
     * Delete model record by unique id
     *
     * @param string $id
     *
     * @return void
     */
    public function deleteByUniqueId($id): void
    {
        $query = $this->model->newQuery();

        $model = $query->where($this->uniqueIdCol, $id)->delete();
    }

    /**
     * 篩選條件取得記錄
     *
     * @param array $where
     * @author Ryuk
     */
    public function showSingle(array $where)
    {
        return $this->model
        ->where($where)
        ->first();
    }

    /**
     * 執行 Query
     *
     * @param string $query
     * @author Ryuk
     */
    public function executeQuery(string $query)
    {
        return DB::select($query);
    }

    /**
     * where eloquent集合
     *
     * @param Illuminate\Database\Eloquent\Model $query
     * @param array $where
     * @return Illuminate\Database\Eloquent\Builder
     * @author Jiahe
     */
    public function getWhere($query, $where): Builder
    {
        foreach ($where as $whereArr)
        {
            if (count($whereArr) == 2 && is_array($whereArr[1])) {
                $query = $query->whereIn($whereArr[0], $whereArr[1]);
            }
            else if (count($whereArr) == 2) {
                $query = $query->where($whereArr[0], $whereArr[1]);
            }
            else {
                if ($whereArr[1] == 'between') {
                    $query = $query->whereBetween($whereArr[0], $whereArr[2]);
                }
                else if ($whereArr[1] == 'like') {
                    $query = $query->where($whereArr[0], $whereArr[1], "%{$whereArr[2]}%");
                }
                else {
                    $query = $query->where($whereArr[0], $whereArr[1], $whereArr[2]);
                }
            }
        }

        return $query;
    }

    /**
     * 依照狀況select DB
     *
     * @param array $where
     * @param array $select
     * @param array $orderBy
     * @param Illuminate\Database\Eloquent\Model $query
     * @param boolean $getFirst
     * @param boolean $toArray
     * @param integer $offset
     * @param integer $limit
     * @param boolean $debug
     * @return Illuminate\Database\Eloquent\Collection|Illuminate\Database\Eloquent\Model|array|null
     * @author Jiahe
     */
    public function selectWithConditions($where = [], $select = ['*'], 
        $orderBy  = [],
        $query    = null,
        $getFirst = false,
        $toArray  = true,
        $offset   = 0,
        $limit    = 0,
        $debug    = false): Collection|Model|array|null
    {
        if(empty($query)) $query = $this->model->newQuery();
        $query = $this->getWhere($query, $where);

        foreach ($orderBy as $column => $sort) {
            $query = $query->orderBy($column, $sort);
        }

        if($offset > 0 && $limit > 0) $offset = ($offset - 1) * $limit;

        if($offset > 0){
            $query = $query->offset($offset);
        }

        if($limit > 0){
            $query = $query->limit($limit);
        }

        if($debug){
            $query = $query->select($select)->dd();
        }

        if($getFirst){
            $data = $query->select($select)->first();
        }
        else {
            $data = $query->select($select)->get();
        }

        if($toArray){
            return $data ? $data->toArray() : [];
        }

        return $data;
    }

    /**
     * 檢查資料是否存在
     *
     * @param array $where
     * @return boolean
     * @author Jiahe
     */
    public function checkExists(array $where): bool
    {
        return $this->getWhere($this->model->newQuery(), $where)->exists();
    }
    
    private function getTimeModel($data, $type)
    {
        $now = date('Y-m-d H:i:s');

        $data['updated_at'] = $now;
        if($type == 'add'){
            $data['created_at'] = $now;
        }

        return $data;
    }

    public function updateData($data, $type, $dbId = '', $where = [])
    {
        $m = DB::table($this->model->getTable());
        $data = $this->getTimeModel($data, $type);

        if($type == 'add'){
            if($this->uniqueIdCol != 'id'){
                $data[$this->uniqueIdCol] = $this->createUniqueId();
            }
            $dbId = $this->create($data)->{$this->uniqueIdCol};
        } else {
            if($type == 'edit'){
                $this->updateByUniqueId($data, $dbId);
            }

            if($type == 'del'){
                $this->deleteByUniqueId($dbId);
            }
        }

        return $dbId;
    }
}
