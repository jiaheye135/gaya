<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;
use App\Repository\RepAdmins;

class LoginController extends BaseController
{
    public function logout(){
        $this->baseForgetSession('backend.account');
        $this->baseForgetSession('backend.user.data');
    }

    public function login(Request $request){
        $this->logout();
        return view('backend.login');
    }

    public function returnData($errMsg = '', $url = ''){
        $data = [];
        if($errMsg){
            $data['errMsg'] = $errMsg;
        } else {
            $data['success'] = 1;
            $data['url']     = $url;
        }

        $this->baseJsonOutput($data);
    }

    public function ajaxLogin(Request $request){

        $repAdmins = static::baseGetRepository('RepAdmins');

        $where = [
            'account' => $this->paramData['account'],
            'pwd' => $this->paramData['pwd'],
        ];
        
        $dbUser = $repAdmins->get($where);
        if( count($dbUser) == 0 ) return $this->returnData('帳號或密碼輸入錯誤');

        if( $dbUser[0]->state != 1 ) return $this->returnData('此帳號為關閉狀態');

        $this->baseSessionControl($dbUser[0]);

        // 登入後要去的頁面
        $url = (static::baseGetSession('default_page')) ?? static::$basePath . 'bannerMgmt';
        static::baseForgetSession('default_page');

        return $this->returnData('', $url);
    }
}