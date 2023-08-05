<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait HasCrud
{
    /**
     * 建立唯一ID
     * @param string $hash 雜湊碼
     * @return string 唯一ID
     */
    public function createUniqueId(string $hash = '')
    {
        while(true){
            $id = md5($hash . uniqid() . microtime(true));
            $exists = $this->model->newQuery()->where($this->uniqueIdCol, $id)->exists();
            if( !$exists ){
                break;
            }
        }
        return $id;
    }

    /**
     * Find a record by ID
     * @param unknown $id
     * @param array $select
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id, $select = ['*'])
    {
        return $this->model->find($id, $select);
    }

    /**
     * Find a record by Unique ID
     * @param unknown $id
     * @param array $with
     * @param array $select
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByUniqueId($id, $select = ['*'])
    {
        return $this->model->where($this->uniqueIdCol, $id)->select($select)->first();
    }

    /**
     * Add a new record
     * @param array $attributes
     * @param boolean $forceFill
     * @return boolean|Illuminate\Database\Eloquent\Model
     */
    public function add(array $attributes = [], $forceFill = false)
    {
        $model = $this->model->newInstance();

        if ($forceFill) {
            $model->forceFill($attributes);
        } else {
            $model->fill($attributes);
        }
        if ($model->save()) {
            return $model;
        }

        return false;
    }

    /**
     * Add a new record(multi)
     * @param array $attributesArr
     * @param boolean $forceFill
     * @return boolean|Illuminate\Database\Eloquent\Model
     */
    public function insert(array $attributesArr = [], $forceFill = false)
    {
        $model = $this->model->newInstance();

        // if ($forceFill) {
        //     $model->forceFill($attributesArr);
        // } else {
        //     $model->fill($attributesArr);
        // }
        if ($model->insert($attributesArr)) {
            return $model;
        }

        return false;
    }

    /**
     * Edit a specific record
     * @param unknown $id
     * @param array $attributes
     * @param boolean $forceFill
     * @return boolean|Illuminate\Database\Eloquent\Model
     */
    public function edit($id, array $attributes = [], $forceFill = false)
    {
        $model = $this->model->findOrFail($id);
        if ($forceFill) {
            if ($model->forceFill($attributes)->save()) {
                return $model;
            }
        } else {
            if ($model->fill($attributes)->save()) {
                return $model;
            }
        }

        return false;
    }

    /**
     * Edit a specific record (By Unique ID)
     * @param unknown $id
     * @param array $attributes
     * @param boolean $forceFill
     * @return boolean|Illuminate\Database\Eloquent\Model
     */
    public function editByUniqueId($id, array $attributes = [], $forceFill = false)
    {
        $query = $this->model->newQuery();

        $model = $query->where($this->uniqueIdCol, $id)->firstOrFail();

        if ($forceFill) {
            if ($model->forceFill($attributes)->save()) {
                return $model;
            }
        } else {
            if ($model->fill($attributes)->save()) {
                return $model;
            }
        }

        return false;
    }

    /**
     * Delete a specific record
     * @param unknown $ids
     * @return integer
     */
    public function delete($ids)
    {
        return $this->model->destroy($ids);
    }

    /**
     * Delete a specific record (By Unique ID)
     * @param unknown $ids
     * @return integer
     */
    public function deleteByUniqueId($id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        return $model->delete();
    }

    /**
     * Retrieve all records.
     * @param array $select
     * @return \Illuminate\Support\Collection
     */
    public function all($select = ['*'], $sort = [])
    {
        $results = $this->model;

        foreach ($sort as $column => $order) {
            $results->orderBy($column, $order);
        }

        return $results->get($select);
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
        $toArray  = false,
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
}
