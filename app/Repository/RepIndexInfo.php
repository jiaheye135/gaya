<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class RepIndexInfo
{
    public $keyList = [
        'lifeExploreIndex' => [
            ['canEdit' => 1, 'title' => '*生命探索介紹圖片', 'id' => 1, 'type' => 'singlefile',  'value' => ''],
            ['canEdit' => 1, 'title' => '*生命探索介紹內容', 'id' => 2, 'type' => 'editor',  'value' => ''],
        ]
    ];

    public $detailList = [];

    protected $table = 'index_info';

    public function __construct(){
        $this->detailList = $this->keyList[BaseController::$pageKey];
    }

    public function getDetailList($where){
        $detailList = $this->detailList;

        if( count($where) > 0 ){
            $userData = $this->get($where);
            foreach($userData as $d){
                $d = (array)$d;

                foreach($detailList as $i => $v){
                    if($v['id'] != $d['info_type']) continue;

                    $detailList[$i]['value'] = $d['value'];
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

    public function get($where, $select = ['*']){
        $m = DB::table($this->table);
        $m = $this->getWhere($m, $where);
        $data = $m->select($select)->get();
        
        $data = $this->processData($data);
        return $data;
    }

    public function getMetaData(){
        $metaData = [];
        $detailList = $this->detailList;
        foreach($detailList as $v){
            $metaData[ $v['id'] ] = $v['type'];
        }
        return $metaData;
    }

    public function processData($data){
        $imgDataType = ['singlefile', 'json'];

        $metaData = $this->getMetaData();

        foreach($data as $i => $d){
            $key = $d->info_type;

            if(!isset($metaData[$key])) continue;

            if(in_array($metaData[$key], $imgDataType) && $d->value){
                $d->value = json_decode($d->value, true);

                if($metaData[$key] == 'singlefile' && is_array($d->value) && isset($d->value[0])){
                    $d->value = $d->value[0];
                } 
            }
        }

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
}