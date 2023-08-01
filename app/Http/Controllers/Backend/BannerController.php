<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class BannerController extends BaseController
{
    public function bannerMgmt(Request $request){
        return view('backend.bannerMgmt');
    }

    public function bannerMgmtEdit(Request $request){
        $type = $request->type;
        $dbId = ($type == 'add') ? 0 : $request->id;
        $detailList = $this->baseGetRepository('RepBanner')->getDetailList($dbId);

        \View::share('type', $type);
        \View::share('dbId', $dbId);
        \View::share('detailList', $detailList);

        return view('backend.bannerMgmtEdit');
    }

    public function ajaxBannerMgmt(){
        $data = [];
        $method = $this->paramData['ajaxType'];

        if(method_exists($this, $method)){
            $data = $this->$method();
        }

        $this->baseJsonOutput($data);
    }

    public function getList(){
        $repBanner = $this->baseGetRepository('RepBanner');
        $data = $repBanner->get();
        return ['data' => $data];
    }

    public function editDetail(){
        $repBanner = $this->baseGetRepository('RepBanner');

        $data = $this->paramData['data'];
        $type = $this->paramData['type'];
        $dbId = $this->paramData['id'];

        $data = $this->basePretreatmentData($repBanner, $data, $type);

        $dbId = $repBanner->updateData($data, $type, $dbId);

        // 上傳圖片
        $this->baseUploadImgs($repBanner, $dbId);

        return ['success' => 1];
    }

    public function delList(){
        $this->baseGetRepository('RepBanner')->updateData(null, 'del', $this->paramData['id']);
        return ['success' => 1];
    }
}