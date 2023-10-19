<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;

use App\Http\Controllers\Front\WebInfoController;
use App\Services\InstagramService;

date_default_timezone_set("Asia/Taipei");

class BaseController extends Controller
{
    /**
     * isMenu     = Int   0(不顯示在項目中)/1(顯示在項目中)
     * groupTitie = var   分類名稱(沒有的話填空值)
     * defActive  = Int   0(預設不顯示)/1(預設顯示)
     * menuType   = Int   1(有子選單)/2(無子選單)
     * subMenu    = Array 子選單列表
     * editPage   = Array 編輯頁
     */
    public static $backendMenu = [
        // 父選單
        'groupIndex' => [ 'isMenu' => 1, 'groupTitie' => '', 'title' => '首頁設定', 'defActive' => 0, 'iconClass' => 'fa-chart-area',
            'menuType' => 1, 'subMenu' => [
                // 子選單
                'bannerMgmt' => ['isMenu' => 1, 'groupTitie' => '', 'title' => 'Banner 管理', 'defActive' => 0,
                    'editPage' => [
                        'bannerMgmtEdit' => ['isMenu' => 0, 'groupTitie' => '', 'title' => 'Banner 內容', 'defActive' => 0],
                    ]
                ],
                // 子選單
                'lifeExploreIndex' => ['isMenu' => 1, 'groupTitie' => '', 'title' => '生命探索介紹', 'defActive' => 0],
                // 子選單
                // 'icelandArticleIndex' => ['isMenu' => 1, 'groupTitie' => '', 'title' => '冰山理論文章連結', 'defActive' => 0],
                // 子選單
                'studentShareIndex' => ['isMenu' => 1, 'groupTitie' => '', 'title' => '學員分享', 'defActive' => 0],
            ],
        ],
        // 父選單
        'aboutMenuMgmt' => [ 'isMenu' => 1, 'groupTitie' => '', 'title' => '關於生命探索', 'defActive' => 0, 'iconClass' => 'fa-chart-area',
            'menuType' => 2,
            'editPage' => [
                'aboutMenuMgmtEdit' => [ 'isMenu' => 0, 'groupTitie' => '', 'title' => '關於生命探索內容', 'defActive' => 0],
            ],
        ],
        // 父選單
        'courseMgmt' => [ 'isMenu' => 1, 'groupTitie' => '', 'title' => '課程介紹', 'defActive' => 0, 'iconClass' => 'fa-chart-area',
            'menuType' => 2,
            'editPage' => [
                'courseMgmtEdit' => [ 'isMenu' => 0, 'groupTitie' => '', 'title' => '課程內容', 'defActive' => 0],
            ],
        ],
        // 父選單
        'groupArticleShare' => [ 'isMenu' => 1, 'groupTitie' => '', 'title' => '文章分享分類', 'defActive' => 0, 'iconClass' => 'fa-chart-area',
            'menuType' => 1, 'subMenu' => [
                // // 子選單
                // 'asCategoryMgmt' => ['isMenu' => 1, 'groupTitie' => '', 'title' => '文章分享分類', 'defActive' => 0,
                //     'editPage' => [
                //         'asCategoryMgmtEdit' => ['isMenu' => 0, 'groupTitie' => '', 'title' => '文章分享分類內容', 'defActive' => 0],
                //     ]
                // ],
                // 子選單
                'articleShareMgmt' => ['isMenu' => 1, 'groupTitie' => '', 'title' => '文章分享文章', 'defActive' => 0,
                    'editPage' => [
                        'articleShareMgmtEdit' => ['isMenu' => 0, 'groupTitie' => '', 'title' => '文章分享文章內容', 'defActive' => 0],
                    ]
                ],
            ],
        ],
        // 父選單
        'meetingInfo' => [ 'isMenu' => 1, 'groupTitie' => '', 'title' => '體驗會資訊', 'defActive' => 0, 'iconClass' => 'fa-chart-area',
            'menuType' => 2
        ],
        // 父選單
        'groupPhotoGallery' => [ 'isMenu' => 1, 'groupTitie' => '', 'title' => '花絮相簿管理', 'defActive' => 0, 'iconClass' => 'fa-chart-area',
            'menuType' => 1, 'subMenu' => [
                // 子選單
                'pgCategoryMgmt' => ['isMenu' => 1, 'groupTitie' => '', 'title' => '相簿分類', 'defActive' => 0,
                    'editPage' => [
                        'pgCategoryMgmtEdit' => ['isMenu' => 0, 'groupTitie' => '', 'title' => '相簿分類內容', 'defActive' => 0],
                    ]
                ],
                // 子選單
                'photoGalleryUpload' => ['isMenu' => 1, 'groupTitie' => '', 'title' => '相片上傳', 'defActive' => 0],
                // 子選單
                'photoGalleryMgmt' => ['isMenu' => 1, 'groupTitie' => '', 'title' => '相片管理', 'defActive' => 0],
            ],
        ],
        // 父選單
        'footerInfo' => [ 'isMenu' => 1, 'groupTitie' => '', 'title' => '頁尾資訊', 'defActive' => 0, 'iconClass' => 'fa-chart-area',
            'menuType' => 2
        ],
    ];
    /**
     * isMenu     = Int   0(不顯示在項目中)/1(顯示在項目中)
     * groupTitie = var   分類名稱(沒有的話填空值)
     * defActive  = Int   0(預設不顯示)/1(預設顯示)
     * menuType   = Int   1(有子選單)/2(無子選單)
     * subMenu    = Array 子選單列表
     * editPage   = Array 編輯頁
     */

    public static $backendMainMenu = [
        // 系統設定 (2層)
        'groupSystem' => [ 'isMenu' => 1, 'groupTitie' => '', 'title' => '系統設定', 'defActive' => 0, 'iconClass' => 'fa-chart-area',
            'menuType' => 1, 'subMenu' => [
                // 子選單
                'adminList' => ['isMenu' => 1, 'groupTitie' => '', 'title' => '管理員列表', 'defActive' => 0,
                    'editPage' => [
                        'adminListEdit' => ['isMenu' => 0, 'groupTitie' => '', 'title' => '管理員內容', 'defActive' => 0],
                    ],
                ],
            ],
        ],
        // 服務項目
        'service_items' => [ 'isMenu' => 1, 'groupTitie' => '', 'title' => '服務項目', 'defActive' => 1, 'iconClass' => 'fa-chart-area',
            'menuType' => 2
        ],
        // 個案紀錄
        'case-record' => [ 'isMenu' => 1, 'groupTitie' => '', 'title' => '個案紀錄', 'defActive' => 1, 'iconClass' => 'fa-chart-area',
            'menuType' => 2, 
            'editPage' => [
                'case-user'        => [ 'isMenu' => 0, 'groupTitie' => '', 'title' => '個案明細', 'defActive' => 0],
                'case-user-record' => [ 'isMenu' => 0, 'groupTitie' => '', 'title' => '新增紀錄', 'defActive' => 0],
            ],
        ],
    ];

    protected static $frontMap = [
        'aboutLE'                => ['level' => 2, 'parentKey' => '',                      'title' => '關於生命探索'],
        'course'                 => ['level' => 2, 'parentKey' => '',                      'title' => '課程介紹'],
        'studentsShareCategory'  => ['level' => 2, 'parentKey' => '',                      'title' => '學員分享'],
        'studentsShare'          => ['level' => 3, 'parentKey' => 'studentsShareCategory', 'title' => '學員分享文章'],
        'articlesShareCategory'  => ['level' => 2, 'parentKey' => '',                      'title' => '文章分享'],
        'articlesShare'          => ['level' => 3, 'parentKey' => 'articlesShareCategory', 'title' => '文章分享文章'],
        'photoGallery'           => ['level' => 2, 'parentKey' => '',                      'title' => '花絮紀錄'],
    ];

    public static $webTitle = '';

    public static $publicPath;
    public static $basePath;
    protected $webPath;
    public static $pageKey;
    public static $platform; // front / backend
    protected $breadcrumb = [];
    protected $paramData;
    protected $files = [];
    public static $repositoryList;
    public static $pageInfo = [];
    public $httpRequest = null;
    public $clientIp;
    
    public function __construct(Request $request)
    {
        $data = $request->all();
        if(count($data) > 0){
            $this->baseParseParam($data);
        }

        static::$publicPath = asset('/');
        \View::share('publicPath', static::$publicPath);

        $this->httpRequest = $request;
        $this->clientIp = (!empty($this->baseGetClientIp())) ? $this->baseGetClientIp() : $this->httpRequest->ip();

        // 後台
        if (trim($request->route()->getPrefix(), '/') == 'admin-backend') {
            static::$platform = 'backend';
            static::$basePath = static::$publicPath . 'admin-backend/';

            static::$pageKey = str_replace(static::$basePath, '', $request->url());
            \View::share('route', static::$pageKey);

            $pageInfo = $this->baseGetPageInfo(static::$pageKey);
            \View::share('openMenuKey', $pageInfo['openMenuKey']);

            static::$pageInfo = $pageInfo['pageInfo'];
            \View::share('pageInfo', static::$pageInfo);
        }
        // 前台
        else {
            static::$platform = 'front';
            static::$basePath = static::$publicPath;

            static::$pageKey = str_replace(static::$basePath, '', $request->url());

            static::$pageInfo = WebInfoController::getFooterInfo();
            \View::share('pageInfo', static::$pageInfo);

            $this->baseGetFrontMenu();

            $this->baseGetBreadcrumb();
            $this->baseGetFrontTitle();

            // IG
            $serv = new InstagramService();
            \View::share('IGInfo', $serv->getMediaId());
        }

        \View::share('basePath', static::$basePath);

        $this->webPath = static::$publicPath . static::$platform . '/';
        \View::share('webPath', $this->webPath);

        // $this->middleware(function ($request, $next) {
        //     return $next($request);
        // });
    }

    public function baseGetFrontTitle($title = ''){
        $pageTitleList = [
            // 'studentsShare' => '學員分享',
        ];

        $webTitle = '';

        if(isset($pageTitleList[static::$pageKey])){
            $webTitle .= $pageTitleList[static::$pageKey];
        }

        if($title){
            $webTitle .= ($webTitle) ? ' - ' . $title : $title;
        }

        if($webTitle){ $webTitle .= ' - '; }
        $webTitle .= '生命探索';

        \View::share('webTitle', $webTitle);
    }

    public function baseGetBreadcrumb(){
        if(!isset(static::$frontMap[static::$pageKey])) return;

        $cur = static::$frontMap[static::$pageKey];

        $breadcrumb = [];
        
        $key = static::$pageKey;
        for($i = 1; $i < $cur['level']; $i++){
            $breadcrumb[$key] = static::$frontMap[$key];

            $key = static::$frontMap[$key]['parentKey'];
            if(!$key) break;
        }

        $this->breadcrumb = array_reverse($breadcrumb);
        \View::share('breadcrumb', $this->breadcrumb);
    }

    public function baseRewriteWebInfo($breadcrumbData, $webTitle = ''){
        foreach($breadcrumbData as $key => $data){
            if(isset($data['id']) && isset($data['createdAt'])){
                $linkData = (object)['id' => $data['id'], 'created_at' => $data['createdAt']];
                $this->baseGetArticleLink($linkData, $key);

                $this->breadcrumb[$key]['link'] = $linkData->href;
            }

            if(isset($data['title'])){
                $this->breadcrumb[$key]['title'] = $data['title'];
            }
        }
        \View::share('breadcrumb', $this->breadcrumb);

        if($webTitle) $this->baseGetFrontTitle($webTitle);
    }

    public function baseParseParam($data){
        foreach($data as $key => $v){
            switch($key){
                case 'data':
                    $this->paramData = $this->baseJwtDecode($v);
                    break;
                case 'files':
                    $this->files = $v;
                    break;
            }
        }
    }

    public function baseGetPageInfoFunc($backendMenu, $pageKey){
        $pageInfo = ['openMenuKey' => '', 'pageInfo' => []];

        foreach($backendMenu as $key => $v){
            if($key == $pageKey){
                $pageInfo = ['openMenuKey' => $key, 'pageInfo' => $v];
                return $pageInfo;
            }

            // edit page 內容頁
            if(isset($v['editPage'])){
                foreach($v['editPage'] as $editPageKey => $v1){
                    if($editPageKey == $pageKey) { 
                        $pageInfo = ['openMenuKey' => $key, 'pageInfo' => $v1];
                        return $pageInfo;
                    }
                }
            }

            if($v['menuType'] == 1){
                foreach($v['subMenu'] as $subMenuKey => $v1){
                    if($subMenuKey == $pageKey) {
                        $pageInfo = ['openMenuKey' => $subMenuKey, 'pageInfo' => $v1];
                        return $pageInfo;
                    }

                    // edit page 內容頁
                    if(isset($v1['editPage'])){
                        foreach($v1['editPage'] as $editPageKey => $v2){
                            if($editPageKey == $pageKey) { 
                                $pageInfo = ['openMenuKey' => $subMenuKey, 'pageInfo' => $v2];
                                return $pageInfo;
                            }
                        }
                    }
                }
            }
        }
        return $pageInfo;
    }

    public function baseGetPageInfo($pageKey){
        $pageInfo = $this->baseGetPageInfoFunc(static::$backendMenu, $pageKey);
        if( count($pageInfo['pageInfo']) == 0 ){
            $pageInfo = $this->baseGetPageInfoFunc(static::$backendMainMenu, $pageKey);
        }

        // if(!isset($pageInfo['title'])) $pageInfo['title'] = '';
        // if(!isset($page_info['sub_title']))   $page_info['sub_title'] = '';
        // if(!isset($page_info['breadcrumbs'])) $page_info['breadcrumbs'] = [];
        // if(!isset($page_info['footer']))      $page_info['footer'] = 'backend.layouts.footer2';
        
        return $pageInfo;
    }

    public function baseGetFrontMenu()
    {
        $frontMenu = [
            'aboutMenu'    => ['title' => '關於馨靈魂', 'subMenu' => []],
            'course'       => ['title' => '服務介紹', 'subMenu' => []],
            'studentShare' => ['title' => '改變的旅程', 'subMenu' => []],
            'articleShare' => ['title' => '好文共享', 'subMenu' => []],
            'photoGallery' => ['title' => '活動訊息', 'subMenu' => []],
        ];

        // 關於生命探索
        $repAboutMenu = $this->baseGetRepository('RepAboutMenu');
        $data = $repAboutMenu->get(['state' => 1], ['item_title as name', 'id', 'created_at'], ['sort' => 'asc'], true);
        $frontMenu['aboutMenu']['subMenu'] = $data;

        // 課程介紹
        $repCourse = static::baseGetRepository('RepCourse');
        $data = $repCourse->get(['state' => 1], ['name', 'id', 'created_at'], ['sort' => 'asc'], true);
        $frontMenu['course']['subMenu'] = $data;

        // 學員分享
        $rep = static::baseGetRepository('RepSsCategory');
        $data = $rep->get(['state' => 1], ['name', 'id', 'created_at'], ['sort' => 'asc'], true);
        $frontMenu['studentShare']['subMenu'] = $data;

        // 文章分享
        $rep = static::baseGetRepository('RepAsCategory');
        $data = $rep->get(['state' => 1], ['name', 'id', 'created_at'], ['sort' => 'asc'], true);
        $frontMenu['articleShare']['subMenu'] = $data;

        // 花絮紀錄
        $rep = static::baseGetRepository('RepPgCategory');
        $data = $rep->get(['state' => 1], ['name', 'id', 'created_at'], ['sort' => 'asc'], true);
        $frontMenu['photoGallery']['subMenu'] = $data;

        \View::share('frontMenu', $frontMenu);
    }

    public static function baseCheckAuth($authKey){
        $hasAuth = false;

        $userAuth = static::baseGetSession('backend.user.data')->auth;
        if( isset($userAuth[$authKey]) && $userAuth[$authKey] == 1 ){
            $hasAuth = true;
        }

        return $hasAuth;
    }

    public static function baseGetBackendMenu($backendMenu, $userAuth = [], $type = '')
    {
        $noShowKey = 0; $noShowKey1 = 0;
        $backendMenuNew = [];

        foreach ($backendMenu as $groupKey => $v) {
            if( isset($userAuth[$groupKey]) ) $v['defActive'] = $userAuth[$groupKey]; // 更新用戶權限

            $subMenu = isset($v['subMenu']) ? $v['subMenu'] : [];
            $v['subMenu'] = [];

            if($type == 'getMenu'){
                if( isset($v['isMenu']) && $v['isMenu'] == 0 ){ continue; } // 隱藏 isMenu = 0
                if( $v['defActive'] == 0 ) { continue; } // 沒有權限
                
                $v['groupTitie'] = ($v['groupTitie'] == '') ? 'no_show' . $noShowKey : $v['groupTitie'];

                $backendMenuNew[ $v['groupTitie'] ][ $groupKey ] = $v;
            }

            if($type == 'getAuth'){
                $backendMenuNew[$groupKey] = $v;
            }

            if ($v['menuType'] == 1) { // 有子選單 (第二層)
                foreach ($subMenu as $subMenuKey => $v1) {
                    if( isset($userAuth[$subMenuKey]) ) $v1['defActive'] = $userAuth[$subMenuKey]; // 更新用戶權限

                    if($type == 'getMenu'){
                        if( isset($v1['isMenu']) && $v1['isMenu'] == 0 ){ continue; } // 隱藏 isMenu = 0
                        if( $v1['defActive'] == 0 ) { continue; } // 沒有權限

                        $v1['groupTitie'] = ($v1['groupTitie'] == '') ? 'no_show' . $noShowKey1 : $v1['groupTitie'];

                        $backendMenuNew[ $v['groupTitie'] ][ $groupKey ]['subMenu'][ $v1['groupTitie'] ][ $subMenuKey ] = $v1;
                    }

                    if($type == 'getAuth'){
                        $backendMenuNew[$groupKey]['subMenu'][$subMenuKey] = $v1;
                    }

                    // edit page 內容頁
                    $editPage = isset($v1['editPage']) ? $v1['editPage'] : [];
                    $v1['editPage'] = [];

                    foreach($editPage as $editPageKey => $v2){
                        if( isset($userAuth[$editPageKey]) ) $v2['defActive'] = $userAuth[$editPageKey]; // 更新用戶權限

                        if($type == 'getAuth'){
                            $backendMenuNew[$groupKey]['subMenu'][$subMenuKey]['editPage'][$editPageKey] = $v2;
                        }
                    }

                    $noShowKey1++;
                }
            }

            // edit page 內容頁
            $editPage = isset($v['editPage']) ? $v['editPage'] : [];
            $v['editPage'] = [];

            foreach($editPage as $editPageKey => $v1){
                if( isset($userAuth[$editPageKey]) ) $v1['defActive'] = $userAuth[$editPageKey]; // 更新用戶權限

                if($type == 'getAuth'){
                    $backendMenuNew[$groupKey]['editPage'][$editPageKey] = $v1;
                }
            }

            $noShowKey++;
        }
        
        return $backendMenuNew;
    }

    public static function baseGetRepository($repKey)
    {
        if (!isset(static::$repositoryList[$repKey])) {
            $repName = 'App\\Repository\\' . $repKey;
            static::$repositoryList[$repKey] = new $repName();
        }

        return static::$repositoryList[$repKey];
    }

    public static function baseGetAdminModel($data, $type){
        if (static::$platform == 'backend') {
            $adminId = static::baseGetSession(static::$platform . '.user.data')->id;

            $data['updater_id'] = $adminId;
            if($type == 'add'){
                $data['creator_id'] = $adminId;
            }
        }
        
        return static::baseGetTimeModel($data, $type);
    }

    public static function baseGetTimeModel($data, $type){
        $now = date('Y-m-d H:i:s');

        $data['updated_at'] = $now;
        if($type == 'add'){
            $data['created_at'] = $now;
        }

        return $data;
    }

    public function baseJsonOutput($data = null)
    {
        response()->json($data)->send();
    }

    public function baseSessionControl($dbUser = null)
    {
        if ($dbUser) {
            static::baseSetSession(static::$platform . '.account', $dbUser->account);
            static::baseSetSession(static::$platform . '.user.data', $dbUser);
        }
    }

    public static function baseSetSession($key, $value)
    {
        Session::put($key, $value);
    }

    public static function baseGetSession($key)
    {
        return Session::get($key);
    }

    public function baseForgetSession($key)
    {
        Session::forget($key);
    }

    public function baseExtractPost($post)
    {
        if (strpos($post, ".")) {
            $postArray = explode(".", $post);
            $data["token"] = $postArray[0];
            $data["data"] = $this->baseJwtDecode($postArray[1]);
        } else {
            $data["data"] = $this->baseJwtDecode($post);
        }

        return $data;
    }

    public function baseJwtDecode($jwt)
    {
        return json_decode(urldecode(base64_decode(urldecode($jwt))), true);
    }

    public static function baseJwtEncode($data)
    {
        return urlencode(base64_encode(urlencode(json_encode($data))));
    }

    public function basePretreatmentData($rep, $data, $type)
    {
        $disabledType = ['multiple', 'singlefile'];
        $detailList = $rep->detailList;

        foreach($detailList as $row){
            if(!in_array($row['type'], $disabledType)) continue;

            $id = $row['id'];
            if(!isset($data[$id])) continue;

            if($type == 'add'){
                $data[$id] = '';
            }

            if($type == 'edit'){
                unset($data[$id]);
            }
        }

        return $data;
    }

    public function basePretreatmentDataV1($detailList, $data, $type)
    {
        $disabledType = ['multiple', 'singlefile'];

        foreach($detailList as $row){
            if(!in_array($row['type'], $disabledType)) continue;

            $id = $row['id'];
            if(!isset($data[$id])) continue;

            if($type == 'add'){
                $data[$id] = '';
            }

            if($type == 'edit'){
                unset($data[$id]);
            }
        }

        return $data;
    }

    public function baseUploadImgs($rep, $dbId, $updateForder = '', $dbColumn = '')
    {
        $typeList = ['singlefile'];

        $detailList = $rep->detailList;
        
        if($updateForder == '') $updateForder = static::$pageKey;

        foreach($this->files as $id => $fileInfo){
            $type = '';
            foreach($detailList as $row){
                if($row['id'] == $id) $type = $row['type'];
            }

            if(!in_array($type, $typeList)){
                return ['errMsg' => '上傳圖片錯誤'];
            }

            $dbData = [];

            $check = [];
            foreach($dbData as $v){
                $check[] = explode('?', $v)[0];
            }

            foreach($fileInfo as $name => $file){
                $partPath = 'backend/upload/' . $updateForder . '/' . $id . '/' . $dbId . '/';
                $fullPath = public_path() . '/' . $partPath;

                // $file_type = $file->getMimeType();
                $fileName = $file->getclientoriginalname();
                $dbImgName = $partPath . $fileName;

                if( in_array($dbImgName, $check) ) continue;

                if($type == 'singlefile'){
                    $this->baseCheckFolder($fullPath);
                }

                $file->move($fullPath, $fileName);
                if( is_file($fullPath . $fileName) ){
                    $dbData[] = $dbImgName.'?'.time();
                }

                $column = ($dbColumn) ? $dbColumn : $id;
                $rep->updateData([$column => json_encode($dbData)], 'edit', $dbId);
            }
        }
    }

    public function baseCheckFolder($path){
        if( !is_dir($path) ) return;
        $d = scandir($path);
        foreach($d as $val){
            if($val == "." || $val == "..") continue;
            if( is_dir($path . $val) ){
                $this->baseCheckFolder($path . $val . '/');
                @rmdir($path . $val  .'/');
            } else {
                unlink($path . $val);
            }
        }
    }

    public static function baseGetArticleLink($data, $articleType){
        $getParam = [ 
            'time' => $data->created_at,
            'key' => md5($data->id),
        ];

        $map = [
            'aboutMenu'    => 'aboutLE',
            'studentShare' => 'studentsShare',
            'articleShare' => 'articlesShare',
            'pgCategory'   => 'photoGallery',
            'ssCategory'   => 'studentsShareCategory',
            'asCategory'   => 'articlesShareCategory',

            'studentsShareCategory' => 'studentsShareCategory',
        ];

        $data->href = '';
        if (isset($map[$articleType])) {
            $data->href = BaseController::$publicPath . $map[$articleType] . '?data=' . BaseController::baseJwtEncode($getParam);
        }
    }

    public static function baseIsJSON($string){
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    public static function baseBuildRandomCode($codeLen = 6){
        $code = '';
        $word = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789'; //字典檔
        $len = strlen($word); // 取得字典檔長度

        for($i = 0; $i < $codeLen; $i++){
            $code .= $word[ rand() % $len ];
        }

        return $code;
    }

    public function baseGetClientIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }

    public function getOption($data, $key, $val, $add = []){
        $option = [];

        // if(isset($selectAdd[$id])){
        //     foreach($selectAdd[$id] as $k => $v){
        //         $option[$k] = $v;
        //     }
        // }

        foreach($data as $v){ $option[$v->{$key}] = $v->{$val}; }
        return $option;
    }
}
