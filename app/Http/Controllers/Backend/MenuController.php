<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class MenuController extends BaseController
{
    public function aboutMenuMgmt(Request $request){
        return view('backend.aboutMenuMgmt');
    }

    public function aboutMenuMgmtEdit(Request $request){
        $type = $request->type;
        $dbId = ($type == 'add') ? 0 : $request->id;
        $detailList = $this->baseGetRepository('RepAboutMenu')->getDetailList($dbId);

        \View::share('type', $type);
        \View::share('dbId', $dbId);
        \View::share('detailList', $detailList);

        return view('backend.aboutMenuMgmtEdit');
    }

    public function ajaxAboutMenuMgmt(){
        $data = [];
        $method = $this->paramData['ajaxType'];

        if(method_exists($this, $method)){
            $data = $this->$method();
        }

        $this->baseJsonOutput($data);
    }

    public function getList(){
        $repAboutMenu = $this->baseGetRepository('RepAboutMenu');
        $data = $repAboutMenu->get();
        return ['data' => $data];
    }

    public function editDetail(){
        $repAboutMenu = $this->baseGetRepository('RepAboutMenu');

        $data = $this->paramData['data'];
        $type = $this->paramData['type'];
        $dbId = $this->paramData['id'];

        $data = $this->basePretreatmentData($repAboutMenu, $data, $type);

        $dbId = $repAboutMenu->updateData($data, $type, $dbId);

        // 上傳圖片
        $this->baseUploadImgs($repAboutMenu, $dbId);

        return ['success' => 1];
    }

    public function delList(){
        $this->baseGetRepository('RepAboutMenu')->updateData(null, 'del', $this->paramData['id']);
        return ['success' => 1];
    }
}