<?php

namespace App\Repositories;

use App\Models\CaseUser;

class CaseUserRepository extends BaseRepository
{
    /**
     * Configure the Model
     */
    public function model()
    {
        return CaseUser::class;
    }

    /**
     * Configure the Unique Id Column
     */
    public function uniqueIdCol()
    {
        return 'user_id';
    }

    public $detailList = [
        ['canEdit' => 1, 'title' => '*姓名', 'id' => 'name', 'type' => 'text', 'value' => ''],
        ['canEdit' => 1, 'title' => '生日', 'id' => 'birthday', 'type' => 'text', 'value' => ''],
        ['canEdit' => 1, 'title' => '手機', 'id' => 'cellphone', 'type' => 'text', 'value' => ''],
        ['canEdit' => 1, 'title' => 'LINE ID', 'id' => 'line_id', 'type' => 'text', 'value' => ''],
        ['canEdit' => 1, 'title' => 'FB', 'id' => 'fb', 'type' => 'text', 'value' => ''],
    ];

    public function get($where = [], $select = ['*'], $orderBy = [], $query = null, $getFirst = false)
    {
        $data = $this->selectWithConditions($where, $select, $orderBy, $query, $getFirst);
        return $data;
    }

    public function getDetailList($dbId)
    {
        $detailList = $this->detailList;
        if($dbId){ // edit
            $userData = $this->get([['user_id', $dbId]], ['*'], [], null, true);
            if(!empty($userData)){
                foreach($detailList as $i => $v){
                    if(!isset($userData[ $v['id'] ])) continue;
                    $detailList[$i]['value'] = $userData[ $v['id'] ];
                }
            }
        }
        return $detailList;
    }
}
