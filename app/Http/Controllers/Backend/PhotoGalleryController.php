<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class PhotoGalleryController extends BaseController
{
    public function photoGalleryUpload(){
        $this->getCategory();
        if(!isset($this->paramData['categoryId'])){
            \View::share('categoryId', 0);
        }

        return view('backend.photoGalleryUpload');
    }

    public function getCategory(){
        $repPgCategory = $this->baseGetRepository('RepPgCategory');
        $categorySelect = $repPgCategory->get();

        \View::share('categorySelect', $categorySelect);

        $categoryId = 0;
        if(isset($this->paramData['categoryId'])){
            $categoryId = $this->paramData['categoryId'];
        }
        else if(isset($categorySelect[0]->id)) {
            $categoryId = $categorySelect[0]->id;
        }
        \View::share('categoryId', $categoryId);

        return ['categoryId' => $categoryId];
    }

    public function getPhotoByCategoryId($categoryId){
        $rep = static::baseGetRepository('RepPhotoGallery');
        $photoData = $rep->get(['category_id' => $categoryId], ['img', 'name', 'id', 'show_index_web', 'state', 'sort'], ['sort' => 'asc']);
        return $photoData;
    }

    public function photoGalleryMgmt(){
        $categoryData = $this->getCategory();

        $photoData = $this->getPhotoByCategoryId($categoryData['categoryId']);
        \View::share('photoData', $photoData);

        return view('backend.photoGalleryMgmt');
    }

    public function pgCategoryMgmt(){
        return view('backend.pgCategoryMgmt');
    }

    public function pgCategoryMgmtEdit(Request $request){
        $type = $request->type;
        $dbId = ($type == 'add') ? 0 : $request->id;
        $detailList = $this->baseGetRepository('RepPgCategory')->getDetailList($dbId);

        \View::share('type', $type);
        \View::share('dbId', $dbId);
        \View::share('detailList', $detailList);

        return view('backend.pgCategoryMgmtEdit');
    }

    public function ajaxPhotoGalleryMgmt(){
        $data = [];
        $method = $this->paramData['ajaxType'];

        if(method_exists($this, $method)){
            $data = $this->$method();
        }

        $this->baseJsonOutput($data);
    }

    public function sortable(){
        $oldData = [];
        
        $categoryId = $this->paramData['categoryId'];
        $photoData = $this->getPhotoByCategoryId($categoryId);
        foreach($photoData as $v){
            $oldData[] = ['id' => $v->id, 'sort' => $v->sort];
        }

        if(count($this->paramData['sortData']) != count($photoData)) return ['errMsg' => '數量錯誤'];

        $rep = static::baseGetRepository('RepPhotoGallery');
        foreach($this->paramData['sortData'] as $i => $v){
            $id = str_replace('item-', '', $v);
            if($id == $oldData[$i]['id'] && $i + 1 == $oldData[$i]['sort']) continue;

            $rep->updateData(['sort' => $i + 1], 'edit', $id);
        }

        return ['success' => 1];
    }

    public function radioChange(){
        $rep = static::baseGetRepository('RepPhotoGallery');
        $rep->updateData(['show_index_web' => 0], 'edit', 0, ['category_id' => $this->paramData['categoryId'], 'show_index_web' => 1]);
        $rep->updateData(['show_index_web' => 1], 'edit', $this->paramData['id']);

        return ['success' => 1];
    }

    public function getPhoto(){
        return $this->getPhotoByCategoryId($this->paramData['categoryId']);
    }

    public function chStatus(){
        $sdIds = $this->paramData['sdIds'];
        if(count($sdIds) == 0) return ['errMsg' => '沒有圖片'];

        $rep = static::baseGetRepository('RepPhotoGallery');
        $rep->updateData(['state' => $this->paramData['state']], 'edit', 0, ['id' => $sdIds]);

        return ['success' => 1];
    }

    public function delPhoto(){
        $sdIds = $this->paramData['sdIds'];
        if(count($sdIds) == 0) return ['errMsg' => '沒有圖片'];

        $rep = static::baseGetRepository('RepPhotoGallery');
        $photoData = $rep->get(['id' => $sdIds], ['img', 'name', 'id']);

        $rep->updateData([], 'del', 0, ['id' => $sdIds]);

        foreach($photoData as $v){
            $imgPath = public_path() . '/' . explode('?', $v->img)[0];
            if(!file_exists($imgPath)) continue;

            unlink($imgPath);
        }

        return ['success' => 1];
    }

    public function getList(){
        $repPgCategory = $this->baseGetRepository('RepPgCategory');
        $data = $repPgCategory->get([], ['id', 'name', 'sort', 'state']);
        return ['data' => $data];
    }

    public function ajaxPgCategory(){
        $repPgCategory = $this->baseGetRepository('RepPgCategory');

        $data = $this->paramData['data'];
        $type = $this->paramData['type'];
        $dbId = $this->paramData['id'];

        $data = $this->basePretreatmentData($repPgCategory, $data, $type);

        $dbId = $repPgCategory->updateData($data, $type, $dbId);

        $this->reSorting();

        return ['success' => 1];
    }

    public function reSorting(){
        $rep = $this->baseGetRepository('RepPgCategory');
        $data = $rep->get([], ['id', 'sort'], ['sort' => 'asc']);
        foreach($data as $i => $v){
            $newSort = $i + 1;
            if($v->sort != $newSort) $rep->updateData(['sort' => $newSort], 'edit', $v->id);
        }
    }

    public function delList(){
        $this->baseGetRepository('RepPgCategory')->updateData(null, 'del', $this->paramData['id']);
        return ['success' => 1];
    }

    public function uploadPhoto(){
        $categoryId = $this->paramData['categoryId'];
        if($categoryId == 0){
            return ['errMsg' => '請先選擇圖片分類'];
        }

        $rep = $this->baseGetRepository('RepPhotoGallery');
        $oldData = $rep->get(['category_id' => $categoryId], ['*'], ['sort' => 'desc']);
        $sort = (isset($oldData[0])) ? $oldData[0]->sort + 1 : 1;

        $oldDataList = [];
        foreach($oldData as $v){
            $oldDataList[$v->name] = $v;
        }

        $updateForder = static::$pageKey;

        $checkFilePath = public_path() . '/backend/upload/logs';
        if (!file_exists($checkFilePath)) {
            mkdir($checkFilePath, 0777, true);
        }

        $cFileName = $this->paramData['checkFile'];
        $checkFile = $checkFilePath . '/' . $cFileName;
        $allFileCount = $this->paramData['allFileCount'];

        $cFileInfo = ['allFileCount' => $allFileCount, 'updatedCount' => 0];

        if (file_exists($checkFile)){
            $cFileInfo = json_decode(file_get_contents($checkFile), true);
        } else {
            file_put_contents($checkFile, json_encode($cFileInfo));
        }

        foreach($this->files as $id => $fileInfo){
            foreach($fileInfo as $name => $file){
                $partPath = 'backend/upload/' . $updateForder . '/' . $id . '/' . $categoryId . '/';
                $fullPath = public_path() . '/' . $partPath;

                $fileName = $file->getclientoriginalname();
                
                $file->move($fullPath, $fileName);

                if( !is_file($fullPath . $fileName) ) continue;

                $img = $partPath . $fileName . '?' . time();
                if(isset($oldDataList[$fileName])){
                    $type = 'edit';
                    $dbId = $oldDataList[$fileName]->id;
                    $data = [
                        'img' => $img,
                        'check_file' => $cFileName,
                    ];
                } else {
                    $type = 'add';
                    $dbId = 0;
                    $data = [
                        'category_id' => $categoryId,
                        'img' => $img,
                        'name' => $fileName,
                        'state' => 1,
                        'sort' => $sort,
                        'show_index_web' => ($sort == 1) ? 1 : 0,
                        'check_file' => $cFileName,
                    ];
                    $sort++;
                }
                $rep->updateData($data, $type, $dbId);
                $cFileInfo['updatedCount']++;

                file_put_contents($checkFile, json_encode($cFileInfo));
            }
        }

        return ['success' => 1, 'updatedCount' => $cFileInfo['updatedCount'], 'fileLen' => count($fileInfo)];
    }

    public function getUploadProgress(){
        $checkFilePath = public_path() . '/backend/upload/logs';
        $checkFile = $checkFilePath . '/' . $this->paramData['checkFile'];

        $cFileInfo = [];
        if (file_exists($checkFile)){
            $cFileInfo = json_decode(file_get_contents($checkFile));
        }
        return $cFileInfo;
    }

    public function delCheckFile(){
        $checkFilePath = public_path() . '/backend/upload/logs';
        $checkFile = $checkFilePath . '/' . $this->paramData['checkFile'];

        if (file_exists($checkFile)) unlink($checkFile);
    }
}