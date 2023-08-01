<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class WebInfoController extends BaseController
{
    public function meetingInfo()
    {
        $repWebInfo = $this->baseGetRepository('RepWebInfo');

        $data = [];
        $m = $repWebInfo->get(['info_type' => [4, 5, 6]]);
        foreach($m as $v){
            $v->value = json_decode($v->value, true);
            $data[$v->info_type] = $v;
        }
        \View::share('data', $data);

        return view('backend.meetingInfo');
    }

    public function footerInfo(){
        $repWebInfo = $this->baseGetRepository('RepWebInfo');

        $data = [];
        $m = $repWebInfo->get(['info_type' => [1, 2, 3]]);
        foreach($m as $v){
            $v->value = json_decode($v->value, true);
            $data[$v->info_type] = $v;
        }
        \View::share('data', $data);

        return view('backend.footerInfo');
    }

    public function ajaxFooterInfo(){
        $repWebInfo = $this->baseGetRepository('RepWebInfo');
        $data = $this->paramData;

        $oldData = [];
        $m = $repWebInfo->get(['info_type' => array_keys($data)]);
        foreach($m as $v){
            $oldData[$v->info_type] = $v;
        }

        foreach($data as $infoType => $v){
            if(isset($oldData[$infoType])){
                $where = ['info_type' => $infoType];
                $dbData = [
                    'value' => json_encode($v)
                ];
                $repWebInfo->updateData($dbData, 'edit', 0, $where);
            } else {
                $dbData = [
                    'info_type' => $infoType,
                    'value' => json_encode($v)
                ];
                $repWebInfo->updateData($dbData, 'add');
            }
        }

        $this->baseJsonOutput(['success' => 1]);
    }
}
