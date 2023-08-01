<?php

namespace App\Services;

use App\Http\Controllers\BaseController;

class InstagramService
{
    protected $filePath = '/home/xjxqpogs/public_html/IG/token.log';
    protected $accessToken = '';
    protected $userId = '';

    public function __construct(){
        list(
            ,
            $this->accessToken,
            ,
            $this->userId
        ) = explode("\n", file_get_contents(base_path('IG/token.log')));
    }

    public function getToken(){
        $rep = BaseController::baseGetRepository('RepFacebookDeveloper');
        $where = [
            'facebook_developer.title' => 'ig_access_token',
        ];
        $select = ['facebook_developer.value'];
        $this->accessToken = $rep->get($where, $select)[0]->value;
    }

    public function getUserID($accessToken){
        $url = 'https://graph.instagram.com/me?fields=id,username&access_token=' . $accessToken;
        $res = $this->curlGet($url);
        $userInfo = json_decode($res, true);
        return isset($userInfo['id']) ? $userInfo['id'] : '';
    }

    // 取得圖片 media id
    public function getMediaId(){
        $url = 'https://graph.instagram.com/' . $this->userId . '?fields=media&access_token=' . $this->accessToken;
        $res = $this->curlGet($url);
        $mediaIds = json_decode($res, true);
        $detail = $this->getPhotoDetail($mediaIds);
        return $detail;
    }

    // 取得取得圖片資訊
    public function getPhotoDetail($mediaIds){
        $detail = [];
        $i = 0;
        if (isset($mediaIds['media']['data'])){
            foreach ($mediaIds['media']['data'] as $v){
                $url = 'https://graph.instagram.com/' . $v['id'] . '?fields=id,media_type,media_url,username,timestamp&access_token=' . $this->accessToken;
                $res = $this->curlGet($url);
                $detail[] = json_decode($res, true);
                $i++;
                if ($i == 9) break;
            }
        }
        return $detail;
    }

    public function getNewToken(){
        $url = "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=" . $this->accessToken;
        $res = $this->curlGet($url);
        $token = json_decode($res, true);

        $data   = [date('Y/m/d H:i:s')];
        $data[] = isset($token['access_token']) ? $token['access_token']                   : '';
        $data[] = isset($token['expires_in'])   ? $token['expires_in']                     : '';
        $data[] = isset($token['access_token']) ? $this->getUserID($token['access_token']) : '';

        file_put_contents('/home/xjxqpogs/public_html/IG/token.log', implode("\n", $data));
    }

    public function curlGet($url, $curlSetting = []){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if(!empty($curlSetting)){
            foreach($curlSetting as $option => $value){
                curl_setopt($ch, $option, $value);
            }
        }

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);

        curl_close($ch);

        return $result;
    }
}