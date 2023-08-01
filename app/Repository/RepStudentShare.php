<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class RepStudentShare
{
    public $detailList = [
        ['canEdit' => 1, 'title' => '*文章分類', 'id' => 'category_id',   'type' => 'select',     'value' => 0],
        ['canEdit' => 1, 'title' => '*文章標題', 'id' => 'title',         'type' => 'text',       'value' => ''],
        ['canEdit' => 1, 'title' => '*文章內容', 'id' => 'share_content', 'type' => 'textarea',   'value' => ''],
        ['canEdit' => 1, 'title' => '影片',      'id' => 'video_urls',    'type' => 'video_urls', 'value' => ''],
        ['canEdit' => 1, 'title' => '*狀態',     'id' => 'state',         'type' => 'select',     'value' => 1],
        ['canEdit' => 1, 'title' => '*排序',     'id' => 'sort',          'type' => 'text',       'value' => 9999],
    ];

    protected $table = 'student_share';

    public function getDetailList($dbId = 0, $selectAdd = []){
        $detailList = $this->detailList;
        $d = [];

        if($dbId > 0){
            $userData = $this->get(['student_share.id' => $dbId], [
                'student_share.category_id',
                'student_share.title',
                'student_share.share_content',
                'student_share.video_urls',
                'student_share.state',
                'student_share.sort',
            ]);

            $userData = $userData['data'];
            if(isset($userData[0])){
                $d = (array)$userData[0];
            }
        }

        foreach($detailList as $i => $v){
            if($v['type'] == 'select'){
                $detailList[$i]['option'] = $this->getOption($v['id'], $selectAdd);
            }

            if(!isset($d[ $v['id'] ])) continue;

            $detailList[$i]['value'] = $d[ $v['id'] ];
        }

        return $detailList;
    }

    public function getOption($id, $selectAdd = []){
        $option = [];

        if(isset($selectAdd[$id])){
            foreach($selectAdd[$id] as $k => $v){
                $option[$k] = $v;
            }
        }

        switch($id){
            case 'category_id':
                $m = BaseController::baseGetRepository('RepSsCategory')->get([], ['id', 'name'], ['sort' => 'asc']);
                foreach($m as $v){
                    $option[$v->id] = $v->name;
                }
                break;
        }
        return $option;
    }

    public function getWhere($m, $where){
        foreach($where as $col => $val){
            if(strpos($col, '<') !== false){
                $m->where(str_replace('<', '', $col), '<', $val);
            } else {
                if (is_array($val)){
                    $m->whereIn($col, $val);
                } else {
                    $m->where($col, $val);
                }
            }
        }
        return $m;
    }

    public function get($where = [], $select = ['*'], $orderBy = [], $getLink = false, $offset = 0, $limit = 0){
        $m = DB::table($this->table);

        $m->LeftJoin('ss_category', 'student_share.category_id', '=', 'ss_category.id');

        $m = $this->getWhere($m, $where);

        $length = $m->count();

        if ($limit != 0){
            $m->skip($offset)->take($limit);
        }

        foreach($orderBy as $col => $val){
            $m->orderBy($col, $val);
        }

        $data = $m->select($select)->get();
        
        $data = $this->processData($data, $getLink);
        return ['data' => $data, 'length' => $length];
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

            if(isset($v->category_name) && isset($v->title)){
                $v->myTitle = $v->category_name . ' - ' . $v->title;
            }

            if($getLink) $this->getStudentShareLink($v);
        }
        return $data;
    }

    public function getStudentShareLink($data){
        $getParam = [ 
            'time' => $data->created_at,
            'key' => md5($data->id),
        ];

        $data->href = BaseController::$publicPath . 'studentsShare?data=' . BaseController::baseJwtEncode($getParam);
    }
}