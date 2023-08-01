<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class RepMeeting
{
    public $detailList = [
        ['canEdit' => 1, 'title' => '開啟體驗會',              'id' => 'has_experience_meeting',  'type' => 'checkbox',    'value' => 0],
        ['canEdit' => 1, 'title' => '*課程名稱',               'id' => 'name',                    'type' => 'text',        'value' => ''],
        ['canEdit' => 1, 'title' => '*體驗會日期',             'id' => 'experience_meeting_date', 'type' => 'json',        'value' => ''],
        ['canEdit' => 1, 'title' => '*體驗會費用',             'id' => 'experience_meeting_fee',  'type' => 'text',        'value' => ''],
        ['canEdit' => 1, 'title' => '*課程介紹頁 Banner 圖片', 'id' => 'detail_banner_img',       'type' => 'singlefile',  'value' => ''],
        ['canEdit' => 1, 'title' => '課程介紹頁 副標題文字',   'id' => 'detail_text',             'type' => 'text',        'value' => ''],
        ['canEdit' => 1, 'title' => '*課程介紹頁 內容',        'id' => 'detail_content',          'type' => 'editor',      'value' => ''],
        ['canEdit' => 1, 'title' => '*排序',                   'id' => 'sort',                    'type' => 'number',      'value' => 0],
    ];

    protected $table = 'meeting';

    public function getDetailList($dbId = 0){
        $detailList = $this->detailList;

        if($dbId > 0){
            $userData = $this->get(['courseId' => $dbId]);
            if(isset($userData[0])){
                $d = (array)$userData[0];

                foreach($detailList as $i => $v){
                    if(!isset($d[ $v['id'] ]) && $v['id'] != 'has_experience_meeting') continue;

                    if($v['id'] == 'has_experience_meeting'){
                        $m = BaseController::baseGetRepository('RepCourse')->get(['id' => $dbId], ['has_experience_meeting']);
                        $detailList[$i]['value'] = $m[0]->has_experience_meeting;
                    } else {
                        $detailList[$i]['value'] = $d[ $v['id'] ];
                    }
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
        $imgDataType = ['singlefile', 'json'];

        $metaData = [];
        $detailList = $this->detailList;
        foreach($detailList as $v){
            $metaData[ $v['id'] ] = $v['type'];
        }

        foreach($data as $i => $d){
            foreach($d as $key => $v){
                if(!isset($metaData[$key])) continue;

                if(in_array($metaData[$key], $imgDataType) && $v){
                    $d->{$key} = json_decode($v, true);

                    if($metaData[$key] == 'singlefile' && is_array($d->{$key}) && isset($d->{$key}[0])){
                        $d->{$key} = $d->{$key}[0];
                    } 
                }
            }

            if($getLink) $this->getCourceLink($d);
        }

        return $data;
    }

    public function getCourceLink($data){
        $getParam = [ 
            'time' => $data->created_at,
            'key' => md5($data->id),
        ];

        $data->href = BaseController::$publicPath . 'experienceMeeting?data=' . BaseController::baseJwtEncode($getParam);
    }
}