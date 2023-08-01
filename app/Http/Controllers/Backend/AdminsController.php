<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class AdminsController extends BaseController
{
    public function adminList(){
        return view('backend.adminList');
    }

    public function buildAuthHtml($backendMenu){
        $h = '';
        $i = 1; 
        foreach($backendMenu as $key => $v){ 
            $c1 = ''; $c2 = 'checked';
            if(isset($v['defActive']) && $v['defActive'] == 1) { 
                $c1 = 'checked'; $c2 = ''; 
            }

            $h .= '<div class="radio_row">';
            $h .=   '<div class="l1"> <!-- 第一層 -->';
            $h .=       '<span class="auth_name">' . $i . '. ' . $v['title'] . '</span>';
            $h .=       '<label><input name="' . $key . '" type="radio" value=1 ' . $c1 . ' style="margin-right: 0.2rem;">啟用</label>';
            $h .=       '<label><input name="' . $key . '" type="radio" value=0 ' . $c2 .' style="margin-right: 0.2rem;">不啟用</label>';

            if($v['menuType'] == 1){
                $j = 1;
                foreach($v['subMenu'] as $subMenuKey => $v1){ 
                    $c1 = ''; $c2 = 'checked';
                    if( isset($v1['defActive']) && $v1['defActive'] == 1) { 
                        $c1 = 'checked'; $c2 = ''; 
                    }

                    $h .= '<div class="l2"> <!-- 第二層 -->';
                    $h .=   '<span class="auth_name">' . $i . '.' . $j . '. ' . $v1['title'] . '</span>';
                    $h .=   '<label><input name="' . $subMenuKey . '" type="radio" value=1 ' . $c1 . ' style="margin-right: 0.2rem;">啟用</label>';
                    $h .=   '<label><input name="' . $subMenuKey . '" type="radio" value=0 ' . $c2 . ' style="margin-right: 0.2rem;">不啟用</label>';
                            
                    if(isset($v1['editPage'])){
                        foreach($v1['editPage'] as $editPageKey => $v2){
                            $c1 = ''; $c2 = 'checked';
                            if( isset($v2['defActive']) && $v2['defActive'] == 1) { 
                                $c1 = 'checked'; $c2 = ''; 
                            }

                            $h .= '<div class="l3"> <!-- 內容頁 -->';
                            $h .=   '<span class="auth_name">' . $v2['title'] . '</span>';
                            $h .=   '<label><input name="' . $editPageKey . '" type="radio" value=1 ' . $c1 . ' style="margin-right: 0.2rem;">啟用</label>';
                            $h .=   '<label><input name="' . $editPageKey . '" type="radio" value=0 ' . $c2 . ' style="margin-right: 0.2rem;">不啟用</label>';
                            $h .= '</div>';
                        }
                    }

                    $h .= '</div>';
                    $j++;
                }
            }

            if(isset($v['editPage'])){
                foreach($v['editPage'] as $editPageKey => $v1){ 
                    $c1 = ''; $c2 = 'checked';
                    if( isset($v1['defActive']) && $v1['defActive'] == 1) { 
                        $c1 = 'checked'; $c2 = ''; 
                    }

                    $h .= '<div class="l2"> <!-- 內容頁 -->';
                    $h .=   '<span class="auth_name">' . $v1['title'] . '</span>';
                    $h .=   '<label><input name="' . $editPageKey . '" type="radio" value=1 ' . $c1 . ' style="margin-right: 0.2rem;">啟用</label>';
                    $h .=   '<label><input name="' . $editPageKey . '" type="radio" value=0 ' . $c2 . ' style="margin-right: 0.2rem;">不啟用</label>';
                    $h .= '</div>';
                }
            }
            $i++;
            $h .=   '</div>';
            $h .= '</div>';
        }
        return $h;
    }

    public function adminListEdit(Request $request){
        $type = $request->type;
        $dbId = ($type == 'add') ? 0 : $request->id;
        list($detailList, $data) = $this->baseGetRepository('RepAdmins')->getDetailList($dbId);

        \View::share('type', $type);
        \View::share('dbId', $dbId);
        \View::share('detailList', $detailList);

        $backendMenu = $this->baseGetBackendMenu(static::$backendMenu, $data['auth'], 'getAuth');
        \View::share('backendMenu', $this->buildAuthHtml($backendMenu));

        $backendMainMenu = $this->baseGetBackendMenu(static::$backendMainMenu, $data['auth'], 'getAuth');
        \View::share('backendMainMenu', $this->buildAuthHtml($backendMainMenu));

        return view('backend.adminListEdit');
    }

    public function ajaxAdminMgmt(){
        $data = [];
        $method = $this->paramData['ajaxType'];

        if(method_exists($this, $method)){
            $data = $this->$method();
        }

        $this->baseJsonOutput($data);
    }

    public function getList(){
        $repAdmins = $this->baseGetRepository('RepAdmins');
        $data = $repAdmins->get([]);
        return ['data' => $data];
    }

    public function editDetail(){
        $repAdmins = $this->baseGetRepository('RepAdmins');

        $data = $this->paramData['data'];
        $type = $this->paramData['type'];
        $dbId = $this->paramData['id'];

        if($type == 'add'){
            if( !(isset($data['rePwd']) && $data['pwd'] == $data['rePwd']) ){
                return ['errMsg' => '密碼不一致', 'id' => 'rePwd'];
            }
            unset($data['rePwd']);
        }

        if($type == 'edit' && isset($data['pwd'])){ // 更改密碼
            $oldData = $repAdmins->get(['id' => $dbId])[0];
            if(!$repAdmins->checkPwd($data['curPwd'], $oldData->pwd)){
                return ['errMsg' => '原始密碼錯誤', 'id' => 'curPwd'];
            }

            if( !(isset($data['rePwd']) && $data['pwd'] == $data['rePwd']) ){
                return ['errMsg' => '密碼不一致', 'id' => 'rePwd'];
            }
            unset($data['curPwd']);
            unset($data['rePwd']);
        }

        $data = $this->basePretreatmentData($repAdmins, $data, $type);

        $dbId = $repAdmins->updateData($data, $type, $dbId);

        // 上傳圖片
        $this->baseUploadImgs($repAdmins, $dbId);

        // 更新登入者session
        if($this->baseGetSession('backend.user.data')->id == $dbId){
            $newData = $repAdmins->get(['id' => $dbId])[0];
            $this->baseSessionControl($newData);
        }

        return ['success' => 1];
    }

    public function delList(){
        $this->baseGetRepository('RepAdmins')->updateData(null, 'del', $this->paramData['id']);
        return ['success' => 1];
    }
}