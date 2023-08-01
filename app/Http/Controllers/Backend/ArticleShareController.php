<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class ArticleShareController extends BaseController
{
    public function articleShareMgmt(){
        $cSelect = $this->baseGetRepository('RepAsCategory')->get([], ['id', 'name']);
        \View::share('cSelect', $cSelect);

        return view('backend.articleShareMgmt');
    }

    public function articleShareMgmtEdit(Request $request){
        $type = $request->type;
        $dbId = ($type == 'add') ? 0 : $request->id;
        $detailList = $this->baseGetRepository('RepArticleShare')->getDetailList($dbId, ['category_id' => [0 => '請選擇']]);

        \View::share('type', $type);
        \View::share('dbId', $dbId);
        \View::share('detailList', $detailList);

        return view('backend.articleShareMgmtEdit');
    }

    public function asCategoryMgmt(){
        return view('backend.asCategoryMgmt');
    }

    public function asCategoryMgmtEdit(Request $request){
        $type = $request->type;
        $dbId = ($type == 'add') ? 0 : $request->id;
        $detailList = $this->baseGetRepository('RepAsCategory')->getDetailList($dbId);

        \View::share('type', $type);
        \View::share('dbId', $dbId);
        \View::share('detailList', $detailList);

        return view('backend.asCategoryMgmtEdit');
    }

    public function ajaxArticleShareMgmt(){
        $data = [];
        $method = $this->paramData['ajaxType'];

        if(method_exists($this, $method)){
            $data = $this->$method();
        }

        $this->baseJsonOutput($data);
    }

    public function getList(){
        $repAsCategory = $this->baseGetRepository('RepAsCategory');
        $data = $repAsCategory->get();
        return ['data' => $data];
    }

    public function ajaxAsCategory(){
        $repAsCategory = $this->baseGetRepository('RepAsCategory');

        $data = $this->paramData['data'];
        $type = $this->paramData['type'];
        $dbId = $this->paramData['id'];

        $data = $this->basePretreatmentData($repAsCategory, $data, $type);

        $dbId = $repAsCategory->updateData($data, $type, $dbId);

        // 上傳圖片
        $this->baseUploadImgs($repAsCategory, $dbId);

        return ['success' => 1];
    }

    public function delList(){
        $repKey = '';
        if(isset($this->paramData['delType']) && $this->paramData['delType'] == 'articleShareCategory'){
            $repKey = 'RepAsCategory';
        }
        if(isset($this->paramData['delType']) && $this->paramData['delType'] == 'articleShare'){
            $repKey = 'RepArticleShare';
        }

        if(!$repKey) return ['errMsg' => '系統錯誤(-1)'];

        $this->baseGetRepository($repKey)->updateData(null, 'del', $this->paramData['id']);
        return ['success' => 1];
    }

    public function getArticleShareList(){
        $where = [];
        if(isset($this->paramData['cid']) && $this->paramData['cid'] > 0){
            $where['category_id'] = $this->paramData['cid'];
        }
        $repArticleShare = $this->baseGetRepository('RepArticleShare');
        $select = [
            'article_share.id', 
            'title', 
            'article_share.state', 
            'article_share.photo',
            'article_share.content_photo',
            'as_category.id as cId', 
            'as_category.name as cName', 
            'article_share.created_at',
        ];
        $data = $repArticleShare->get($where, $select, ['as_category.id' => 'asc', 'article_share.sort' => 'asc', 'article_share.id' => 'desc']);

        return ['data' => $data['data']];
    }

    public function ajaxArticleShare(){
        $rep = $this->baseGetRepository('RepArticleShare');

        $data = $this->paramData['data'];
        $type = $this->paramData['type'];
        $dbId = $this->paramData['id'];

        $data = $this->basePretreatmentData($rep, $data, $type);

        $autoSetPhoto = false;
        $def = 'front/assets/images/pages/img-s1@2x.png';

        $autoSetAsPhoto = false;
        $ssDef = 'front/assets/images/pages/ms-article-img-1@2x.png';

        if($type == 'add'){ $autoSetPhoto = true; $autoSetAsPhoto = true; }

        if($type == 'edit'){
            $oldData = $rep->get(['article_share.id' => $dbId], ['article_share.photo', 'article_share.content_photo']);
            if(!isset($oldData['data'][0])) return ['errMsg' => '無此文章'];

            if(!$oldData['data'][0]->photo || $oldData['data'][0]->photo == $def) $autoSetPhoto = true;
            if(!$oldData['data'][0]->content_photo || $oldData['data'][0]->content_photo == $ssDef) $autoSetAsPhoto = true;
        }

        if($autoSetPhoto) $data['photo'] = $this->autoSetPhoto($data['category_id'], $def, 'asCategoryPhoto'); // 配文章分類圖
        if($autoSetAsPhoto) $data['content_photo'] = $this->autoSetPhoto($data['category_id'], $ssDef, 'asPhoto'); // 配文章內容圖
        
        $dbId = $rep->updateData($data, $type, $dbId);

        $this->reSorting($data['category_id']);

        // 上傳圖片
        $this->baseUploadImgs($rep, $dbId);

        return ['success' => 1];
    }

    public function reSorting($category_id){
        $rep = $this->baseGetRepository('RepArticleShare');
        $data = $rep->get(['article_share.category_id' => $category_id, 'article_share.sort<' => 9999], ['article_share.id', 'article_share.sort'], ['article_share.sort' => 'asc', 'article_share.id' => 'desc']);
        foreach($data['data'] as $i => $v){
            $newSort = $i + 1;
            if($v->sort != $newSort) $rep->updateData(['sort' => $newSort], 'edit', $v->id);
        }
    }

    public function autoSetPhoto($categoryId, $def, $photoType){
        $asC = $this->baseGetRepository('RepAsCategory')->get(['id' => $categoryId]);
        if(!isset($asC[0]) || !$asC[0]->photo_group) return $def;

        $path = 'backend/' . $photoType . '/' . $asC[0]->photo_group;
        $dir = public_path() . '/' . $path;
        if(!is_dir($dir)) return $def;

        $files = scandir($dir);
        $size = count($files) - 2;
        if($size <= 0) return $def;

        $photo = $path . '/' . $files[rand(1, $size) + 1];

        return is_file(public_path() . '/' . $photo) ? $photo : $def;
    }

    public function reSetPhoto(){
        $photoType = ''; $dbColumn = ''; $def = '';
        
        $dbId = $this->paramData['id'];
        if($this->paramData['photoType'] == 'cPhoto'){ 
            $photoType = 'asCategoryPhoto'; 
            $dbColumn = 'photo'; 
            $def = 'front\assets\images\pages\img-s1@2x.png';
        }
        if($this->paramData['photoType'] == 'sPhoto'){ 
            $photoType = 'asPhoto'; 
            $dbColumn = 'content_photo'; 
            $def = 'front/assets/images/pages/ms-article-img-1@2x.png';
        }

        if(!$photoType) return ['errMsg' => '圖片類型錯誤'];

        $rep = $this->baseGetRepository('RepArticleShare');

        $oldData = $rep->get(['article_share.id' => $dbId], ['article_share.category_id']);
        if(!isset($oldData['data'][0])) return ['errMsg' => '無此文章'];

        $data = [];
        $data[$dbColumn] = $this->autoSetPhoto($oldData['data'][0]->category_id, $def, $photoType); // 配文章分類圖

        $rep->updateData($data, 'edit', $dbId);
        
        return ['success' => 1, 'photo' => $data[$dbColumn]];

    }
}