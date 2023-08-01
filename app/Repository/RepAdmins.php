<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController;

class RepAdmins
{
    public $detailList = [
        ['canEdit' => 1, 'title' => '*帳號', 'id' => 'account', 'type' => 'text',   'value' => ''],
        ['canEdit' => 1, 'title' => '*姓名', 'id' => 'name',    'type' => 'text',   'value' => ''],
        ['canEdit' => 1, 'title' => '*密碼', 'id' => 'pwd',     'type' => 'pwd',    'value' => ''],
        ['canEdit' => 1, 'title' => '*狀態', 'id' => 'state',   'type' => 'select', 'value' => 1],
    ];

    protected $table = 'admins';

    public function getDetailList($dbId = 0){
        $detailList = $this->detailList;
        $data = null;

        if($dbId > 0){ // edit
            $userData = $this->get(['id' => $dbId]);
            if(isset($userData[0])){
                $data = (array)$userData[0];

                foreach($detailList as $i => $v){
                    if($v['id'] == 'pwd'){
                        unset($detailList[$i]); continue;
                    }

                    if(!isset($data[ $v['id'] ])) continue;

                    $detailList[$i]['value'] = $data[ $v['id'] ];

                    if($v['id'] == 'account') $detailList[$i]['canEdit'] = 0;
                }

                $detailList = array_values($detailList);
            }
        }

        return [$detailList, $data];
    }

    public function getWhere($m, $where){
        foreach($where as $col => $val){
            switch($col){
                case 'pwd':
                    break;
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
        
        if( count($data) > 0 && isset($where['pwd']) && !$this->checkPwd($where['pwd'], $data[0]->pwd) ){
            return [];
        }

        $data = $this->processData($data);
        return $data;
    }

    public function checkPwd($pwd, $refer){
        return Hash::check($pwd, $refer);
    }

    public function makePwd($pwd){
        return Hash::make($pwd);
    }

    public function processData($data){
        foreach($data as $i => $d){
            foreach($d as $key => $v){
                if($key == 'auth'){
                    $d->{$key} = json_decode($v, true);
                }
            }
        }

        return $data;
    }
    
    public function updateData($data, $type, $dbId = 0, $where = []){
        $m = DB::table($this->table);
        $data = BaseController::baseGetAdminModel($data, $type);

        if(isset($data['pwd'])){
            $data['pwd'] = $this->makePwd($data['pwd']);
        }

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