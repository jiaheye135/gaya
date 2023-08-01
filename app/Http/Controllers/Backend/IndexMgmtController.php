<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;

class IndexMgmtController extends BaseController
{
    public function editStudentShare(){
        $update = [];
        if (isset($this->paramData['newTitle']) && $this->paramData['newTitle']){
            $update['show_name'] = $this->paramData['newTitle'];
        }
        if (isset($this->paramData['newState'])){
            $update['state'] = $this->paramData['newState'];
        }

        if (count($update) > 0)
        {
            $rep = $this->baseGetRepository('RepIndexStudentShare');
            $rep->updateData($update, 'edit', $this->paramData['id']);

            return ['success' => 1];
        }

        return ['errMsg' => '參數錯誤'];
    }

    public function studentShareIndex(){
        $selectKey = 'studentShare';
        \View::share('selectKey', $selectKey);

        $selectList = $this->getArticleTypeSelect([$selectKey]);
        \View::share('selectList', $selectList[$selectKey]['list']);

        $rep = $this->baseGetRepository('RepIndexStudentShare');
        $select = [
            'index_student_share.id', 
            'index_student_share.article_id', 
            'student_share.title',
            'ss_category.name as category_name',
            'index_student_share.show_name',
            'index_student_share.sort',
            'index_student_share.state'
        ];
        $data = $rep->get([], $select, ['index_student_share.sort' => 'asc']);
        \View::share('data', $data);

        \View::share('pageKey', static::$pageKey);

        return view('backend.studentShareIndex');
    }

    public function getArticleType($key){
        $mapping = [
            'studentShare' => '學員分享',
        ];
        return isset($mapping[$key]) ? $mapping[$key] : $key ;
    }

    public function getArticleTypeSelect($range = ['all']){
        $selectList = [];

        if (in_array('all', $range) || in_array('studentShare', $range))
        {
            // 學員分享
            $list = [];

            $rep = $this->baseGetRepository('RepStudentShare');
            $studentShare = $rep->get([], ['student_share.id', 'title', 'category_id', 'name as category_name'], ['category_id' => 'asc', 'student_share.id' => 'asc']);

            foreach ($studentShare['data'] as $v){
                $list[] = $v;
            }

            $key = 'studentShare';
            $selectList[$key]['name'] = $this->getArticleType($key);
            $selectList[$key]['list'] = $list;
        }

        return $selectList;
    }

    public function icelandArticleIndex(){
        $selectList = $this->getArticleTypeSelect();
        \View::share('selectList', $selectList);

        \View::share('pageKey', static::$pageKey);

        return view('backend.icelandArticle');
    }

    public function ajaxIndex(){
        $data = [];
        $method = $this->paramData['ajaxType'];

        if(method_exists($this, $method)){
            $data = $this->$method();
        }

        $this->baseJsonOutput($data);
    }

    public function getList(){
        $rep = $this->baseGetRepository('RepIndexIceland');
        $data = $rep->get([], ['index_iceland.id', 'item_img', 'article_type', 'student_share.title', 'article_id', 'ss_category.name as category_name']);
        return ['data' => $data];
    }

    public function selectArticle(){
        switch ($this->paramData['articleType']) {
            case 'studentShare':
                $rep = $this->baseGetRepository('RepStudentShare');
                $articleInfo = $rep->get(['student_share.id' => $this->paramData['articleId']], ['student_share.category_id']);
                $articleCategoryId = $articleInfo['data'][0]->category_id;
                break;
            default:
                return ['errMeg' => '參數錯誤'];
        }

        $data = [
            'article_type' => $this->paramData['articleType'],
            'article_id' => $this->paramData['articleId'],
            'article_category_id' => $articleCategoryId,
        ];

        $rep = null;
        if ($this->paramData['pageKey'] == 'icelandArticleIndex') $rep = $this->baseGetRepository('RepIndexIceland');
        if ($this->paramData['pageKey'] == 'studentShareIndex')   $rep = $this->baseGetRepository('RepIndexStudentShare');

        if (!$rep) return ['errMsg' => '系統錯誤'];

        $rep->updateData($data, 'edit', $this->paramData['id']);

        return ['success' => 1];
    }

    public function lifeExploreIndex(){
        $repIndexInfo = $this->baseGetRepository('RepIndexInfo');

        $detailList = $repIndexInfo->getDetailList(['info_type' => [1, 2]]);
        \View::share('detailList', $detailList);

        return view('backend.lifeExploreIndex');
    }

    public function ajaxIndexMgmt(){
        static::$pageKey = 'lifeExploreIndex';

        $errMsg = '';

        $repIndexInfo = $this->baseGetRepository('RepIndexInfo');
        $data = $this->paramData['data'];

        $oldData = [];
        $m = $repIndexInfo->get(['info_type' => array_keys($data)]);
        foreach($m as $v){
            $oldData[$v->info_type] = $v;
        }

        $metaData = $repIndexInfo->getMetaData();

        $imgType = ['multiple', 'singlefile'];
        foreach($data as $infoType => $v){
            $isImg = in_array($metaData[$infoType], $imgType);

            if(isset($oldData[$infoType])){
                if($isImg){
                    $dbId = $oldData[$infoType]->id;
                } else {
                    $where = ['info_type' => $infoType];
                    $dbData = [
                        'value' => $v
                    ];
                    $dbId = $repIndexInfo->updateData($dbData, 'edit', 0, $where);
                }
            } else {
                if($isImg) $v = '';

                $dbData = [
                    'info_type' => $infoType,
                    'value' => $v
                ];
                $dbId = $repIndexInfo->updateData($dbData, 'add');
            }

            if($isImg){
                // 上傳圖片
                $res = $this->baseUploadImgs($repIndexInfo, $dbId, '', 'value');
                if(isset($res['errMsg'])) $errMsg = $res['errMsg'];
            }
        }

        if($errMsg){
            $this->baseJsonOutput(['errMsg' => $errMsg]);
        } else {
            $this->baseJsonOutput(['success' => 1]);
        }
    }
}