<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class RepPgCategory
{
    public $detailList = [
        ['canEdit' => 1, 'title' => '*分類名稱', 'id' => 'name', 'type' => 'text', 'value' => ''],
        ['canEdit' => 1, 'title' => '簡介', 'id' => 'introduction', 'type' => 'text', 'value' => ''],
        ['canEdit' => 1, 'title' => '*排序', 'id' => 'sort', 'type' => 'number', 'value' => 1],
        ['canEdit' => 1, 'title' => '*狀態', 'id' => 'state', 'type' => 'select', 'value' => 1],
    ];

    protected $table = 'pg_category';

    public function getDetailList($dbId = 0){
        $detailList = $this->detailList;

        if($dbId > 0){
            $userData = $this->get(['id' => $dbId]);
            if(isset($userData[0])){
                $d = (array)$userData[0];

                foreach($detailList as $i => $v){
                    if(!isset($d[ $v['id'] ])) continue;

                    $detailList[$i]['value'] = $d[ $v['id'] ];
                }
            }
        } else {
            $m = $this->get([], ['sort'], ['sort' => 'desc'], false, 1);
            if($m[0]->sort){
                foreach($detailList as $i => $v){
                    if($v['id'] == 'sort') $detailList[$i]['value'] = $m[0]->sort + 1;
                }
            }
        }

        return $detailList;
    }

    public function getWhere($m, $where){
        foreach($where as $col => $val){
            switch($col){
                default:
                    if (is_array($val)){
                        $m->whereIn($col, $val);
                    } else {
                        $m->where($col, $val);
                    }
                    break;
            }
        }
        return $m;
    }

    public function get($where = [], $select = ['*'], $orderBy = [], $getLink = false, $limit = 0){
        $m = DB::table($this->table);
        $m = $this->getWhere($m, $where);

        foreach($orderBy as $col => $val){
            $m->orderBy($col, $val);
        }

        if($limit > 0) $m->limit($limit);

        $data = $m->select($select)->get();
        
        $data = $this->processData($data, $getLink);
        return $data;
    }

    public function updateData($data, $type, $dbId = 0, $where = []){
        $m = DB::table($this->table);
        $data = BaseController::baseGetAdminModel($data, $type);

        if($type == 'add'){
            $m->insert($data);
            $dbId = DB::getPdo()->lastInsertId();
        } else {
            if( count($where) == 0 ){ $where['id'] = $dbId; }
            $m = $this->getWhere($m, $where);

            if($type == 'edit'){
                $m->update($data);
            }

            if($type == 'del'){
                $m->delete();
            }
        }

        return $dbId;
    }

    public function processData($data, $getLink = false){
        foreach($data as $i => $v){
            if(isset($v->img)){
                $v->img = json_decode($v->img, true);

                if(isset($v->img)){
                    $v->img = $v->img[0];
                }
            }

            if($getLink) BaseController::baseGetArticleLink($v, 'pgCategory');
        }
        return $data;
    }
}