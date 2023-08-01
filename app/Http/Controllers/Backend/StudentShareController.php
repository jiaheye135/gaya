<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class StudentShareController extends BaseController
{
    public function studentShareMgmt(){
        $cSelect = $this->baseGetRepository('RepSsCategory')->get([], ['id', 'name']);
        \View::share('cSelect', $cSelect);

        return view('backend.studentShareMgmt');
    }

    public function studentShareMgmtEdit(Request $request){
        $type = $request->type;
        $dbId = ($type == 'add') ? 0 : $request->id;
        $detailList = $this->baseGetRepository('RepStudentShare')->getDetailList($dbId, ['category_id' => [0 => '請選擇']]);

        \View::share('type', $type);
        \View::share('dbId', $dbId);
        \View::share('detailList', $detailList);

        return view('backend.studentShareMgmtEdit');
    }

    public function ssCategoryMgmt(){
        return view('backend.ssCategoryMgmt');
    }

    public function ssCategoryMgmtEdit(Request $request){
        $type = $request->type;
        $dbId = ($type == 'add') ? 0 : $request->id;
        $detailList = $this->baseGetRepository('RepSsCategory')->getDetailList($dbId);

        \View::share('type', $type);
        \View::share('dbId', $dbId);
        \View::share('detailList', $detailList);

        return view('backend.ssCategoryMgmtEdit');
    }

    public function ajaxStudentShareMgmt(){
        $data = [];
        $method = $this->paramData['ajaxType'];

        if(method_exists($this, $method)){
            $data = $this->$method();
        }

        $this->baseJsonOutput($data);
    }

    public function getList(){
        $repSsCategory = $this->baseGetRepository('RepSsCategory');
        $data = $repSsCategory->get();
        return ['data' => $data];
    }

    public function ajaxSsCategory(){
        $repSsCategory = $this->baseGetRepository('RepSsCategory');

        $data = $this->paramData['data'];
        $type = $this->paramData['type'];
        $dbId = $this->paramData['id'];

        $data = $this->basePretreatmentData($repSsCategory, $data, $type);

        $dbId = $repSsCategory->updateData($data, $type, $dbId);

        // 上傳圖片
        $this->baseUploadImgs($repSsCategory, $dbId);

        return ['success' => 1];
    }

    public function delList(){
        $repKey = '';
        if(isset($this->paramData['delType']) && $this->paramData['delType'] == 'studentShareCategory'){
            $repKey = 'RepSsCategory';
        }
        if(isset($this->paramData['delType']) && $this->paramData['delType'] == 'studentShare'){
            $repKey = 'RepStudentShare';
        }

        if(!$repKey) return ['errMsg' => '系統錯誤(-1)'];

        $this->baseGetRepository($repKey)->updateData(null, 'del', $this->paramData['id']);
        return ['success' => 1];
    }

    public function getStudentShareList(){
        $where = [];
        if(isset($this->paramData['cid']) && $this->paramData['cid'] > 0){
            $where['category_id'] = $this->paramData['cid'];
        }
        $repStudentShare = $this->baseGetRepository('RepStudentShare');
        $select = [
            'student_share.id', 
            'title', 
            'student_share.state', 
            'student_share.photo',
            'student_share.content_photo',
            'ss_category.id as cId', 
            'ss_category.name as cName', 
            'student_share.created_at',
        ];
        $data = $repStudentShare->get($where, $select, ['ss_category.id' => 'asc', 'student_share.sort' => 'asc', 'student_share.id' => 'desc']);

        return ['data' => $data['data']];
    }

    public function ajaxStudentShare(){
        $rep = $this->baseGetRepository('RepStudentShare');

        $data = $this->paramData['data'];
        $type = $this->paramData['type'];
        $dbId = $this->paramData['id'];

        $data = $this->basePretreatmentData($rep, $data, $type);

        $autoSetPhoto = false;
        $def = 'front/assets/images/pages/img-s1@2x.png';

        $autoSetSsPhoto = false;
        $ssDef = 'front/assets/images/pages/ms-article-img-1@2x.png';

        if($type == 'add'){ $autoSetPhoto = true; $autoSetSsPhoto = true; }

        if($type == 'edit'){
            $oldData = $rep->get(['student_share.id' => $dbId], ['student_share.photo', 'student_share.content_photo']);
            if(!isset($oldData['data'][0])) return ['errMsg' => '無此文章'];

            if(!$oldData['data'][0]->photo || $oldData['data'][0]->photo == $def) $autoSetPhoto = true;
            if(!$oldData['data'][0]->content_photo || $oldData['data'][0]->content_photo == $ssDef) $autoSetSsPhoto = true;
        }

        if($autoSetPhoto) $data['photo'] = $this->autoSetPhoto($data['category_id'], $def, 'ssCategoryPhoto'); // 配文章分類圖
        if($autoSetSsPhoto) $data['content_photo'] = $this->autoSetPhoto($data['category_id'], $ssDef, 'ssPhoto'); // 配文章內容圖
        
        $dbId = $rep->updateData($data, $type, $dbId);

        $this->reSorting($data['category_id']);

        // 上傳圖片
        $this->baseUploadImgs($rep, $dbId);

        return ['success' => 1];
    }

    public function reSorting($category_id){
        $rep = $this->baseGetRepository('RepStudentShare');
        $data = $rep->get(['student_share.category_id' => $category_id, 'student_share.sort<' => 9999], ['student_share.id', 'student_share.sort'], ['student_share.sort' => 'asc', 'student_share.id' => 'desc']);
        foreach($data['data'] as $i => $v){
            $newSort = $i + 1;
            if($v->sort != $newSort) $rep->updateData(['sort' => $newSort], 'edit', $v->id);
        }
    }

    public function autoSetPhoto($categoryId, $def, $photoType){
        $ssC = $this->baseGetRepository('RepSsCategory')->get(['id' => $categoryId]);
        if(!isset($ssC[0]) || !$ssC[0]->photo_group) return $def;

        $path = 'backend/' . $photoType . '/' . $ssC[0]->photo_group;
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
            $photoType = 'ssCategoryPhoto'; 
            $dbColumn = 'photo'; 
            $def = 'front\assets\images\pages\img-s1@2x.png';
        }
        if($this->paramData['photoType'] == 'sPhoto'){ 
            $photoType = 'ssPhoto'; 
            $dbColumn = 'content_photo'; 
            $def = 'front/assets/images/pages/ms-article-img-1@2x.png';
        }

        if(!$photoType) return ['errMsg' => '圖片類型錯誤'];

        $rep = $this->baseGetRepository('RepStudentShare');

        $oldData = $rep->get(['student_share.id' => $dbId], ['student_share.category_id']);
        if(!isset($oldData['data'][0])) return ['errMsg' => '無此文章'];

        $data = [];
        $data[$dbColumn] = $this->autoSetPhoto($oldData['data'][0]->category_id, $def, $photoType); // 配文章分類圖

        $rep->updateData($data, 'edit', $dbId);
        
        return ['success' => 1, 'photo' => $data[$dbColumn]];

    }
}