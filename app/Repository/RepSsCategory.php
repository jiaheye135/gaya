<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class RepSsCategory
{
    public $detailList = [
        ['canEdit' => 1, 'title' => '*分類圖片', 'id' => 'img', 'type' => 'singlefile', 'value' => ''],
        ['canEdit' => 1, 'title' => '*分類名稱', 'id' => 'name', 'type' => 'text', 'value' => ''],
        ['canEdit' => 1, 'title' => '*排序', 'id' => 'sort', 'type' => 'number', 'value' => 0],
        ['canEdit' => 1, 'title' => '*狀態', 'id' => 'state', 'type' => 'select', 'value' => 1],
    ];

    protected $table = 'ss_category';

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

    public function get($where = [], $select = ['*'], $orderBy = [], $getLink = false){
        $m = DB::table($this->table);
        $m = $this->getWhere($m, $where);

        foreach($orderBy as $col => $val){
            $m->orderBy($col, $val);
        }

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
        foreach($data as $d){
            if(isset($d->img)){
                $d->img = json_decode($d->img, true);

                if(isset($d->img)){
                    $d->img = $d->img[0];
                }
            }

            if($getLink) BaseController::baseGetArticleLink($d, 'ssCategory');
        }
        return $data;
    }
}