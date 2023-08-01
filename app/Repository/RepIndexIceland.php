<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class RepIndexIceland
{
    public $keyList = [
        'icelandArticleIndex' => [
        //     ['canEdit' => 1, 'title' => '*生命探索介紹圖片', 'id' => 1, 'type' => 'singlefile',  'value' => ''],
        //     ['canEdit' => 1, 'title' => '*生命探索介紹內容', 'id' => 2, 'type' => 'editor',  'value' => ''],
        ]
    ];

    public $detailList = [];

    protected $table = 'index_iceland';

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

    public function get($where = [], $select = ['*'], $orderBy = [], $getLink = false){
        $m = DB::table($this->table);

        $m->LeftJoin('student_share', function($join){
            $join->on('student_share.id', 'index_iceland.article_id')
                ->LeftJoin('ss_category', 'ss_category.id', '=', 'student_share.category_id')
                ->where('index_iceland.article_type', 'studentShare');
        });

        $m = $this->getWhere($m, $where);

        foreach($orderBy as $col => $val){
            $m->orderBy($col, $val);
        }

        $data = $m->select($select)->get();
        
        $data = $this->processData($data, $getLink);
        return $data;
    }

    public function processData($data, $getLink = false){
        foreach($data as $i => $d){
            $d->article_type_title = $this->getArticleType($d->article_type);

            if($getLink) BaseController::baseGetArticleLink($d, $d->article_type);
        }

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

    public function getArticleType($key){
        $mapping = [
            'studentShare' => '學員分享',
        ];
        return isset($mapping[$key]) ? $mapping[$key] : $key ;
    }
}