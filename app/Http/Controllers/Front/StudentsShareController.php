<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class StudentsShareController extends BaseController
{
    public function ajaxGetStudentShare(Request $request)
    {
        $page   = $request->pageNumber;
        $limit  = $request->pageSize;
        $offset = ($page - 1) * $limit;

        $cid = $request->cid;

        return $this->getStudentShare($cid, $offset, $limit);
    }

    public function getStudentShare($cid, $offset = 0, $limit = 0)
    {
        $rep = $this->baseGetRepository('RepStudentShare');
        $where = [
            'student_share.category_id' => $cid,
            'ss_category.state' => 1,
            'student_share.state' => 1,
        ];
        $select = ['student_share.id', 'student_share.created_at', 'student_share.title', 'student_share.share_content', 'student_share.photo'];
        $data = $rep->get($where, $select, ['student_share.sort' => 'asc', 'student_share.id' => 'desc'], true, $offset, $limit);

        return $data;
    }
    
    public function studentsShareCategory(Request $request)
    {
        $cid = 0; $cName = '';

        $rep = $this->baseGetRepository('RepSsCategory');
        $categoryData = $rep->get(['state' => 1], ['id', 'name', 'created_at'], ['sort' => 'asc']);
        if(isset($categoryData[0])){
            $cid = $categoryData[0]->id;
            $cName = $categoryData[0]->name;
        }

        \View::share('categoryData', $categoryData);

        if(isset($this->paramData['time'])) {
            foreach($categoryData as $v){
                if($v->created_at == $this->paramData['time'] && md5($v->id) == $this->paramData['key']){
                    $cid = $v->id;
                    $cName = $v->name;
                }
            }
        }

        \View::share('cid', $cid);

        // $page   = 1;
        // $limit  = 6;
        // $offset = ($page - 1) * $limit;

        // $data = $this->getStudentShare($cid, $offset, $limit);
        // \View::share('data', $data);

        // baseRewriteWebInfo
        $breadcrumbData = [
            static::$pageKey => [
                'title' => $this->breadcrumb[static::$pageKey]['title'] . " (" . $cName . ")",
            ],
        ];

        $this->baseRewriteWebInfo($breadcrumbData, $cName);

        return view('front.studentsShareCategory');
    }

    public function studentsShare(Request $request)
    {
        $data = ['hasStudentsShare' => 0];

        $repStudentShare = $this->baseGetRepository('RepStudentShare');

        $select = [
            'student_share.id',
            'student_share.state',
            'student_share.title',
            'student_share.share_content',
            'student_share.content_photo',
            'student_share.video_urls',
            'ss_category.id as cId',
            'ss_category.name as cName',
            'ss_category.created_at as cCreated',
        ];

        $m = $repStudentShare->get(['student_share.created_at' => $this->paramData['time']], $select);
        $m = $m['data'];

        if(count($m) > 0 && $this->paramData['key'] == md5($m[0]->id) && $m[0]->state){
            $data['hasStudentsShare'] = 1;

            $studentsShareInfo = $m[0];

            $myTitle = $studentsShareInfo->cName . ' - ' . $studentsShareInfo->title;
            $studentsShareInfo->myTitle = $myTitle;

            $data['studentsShareInfo'] = $studentsShareInfo;

            // baseRewriteWebInfo
            $breadcrumbData = [
                'studentsShareCategory' => [
                    'id' => $studentsShareInfo->cId,
                    'createdAt' => $studentsShareInfo->cCreated,
                    'title' => $this->breadcrumb['studentsShareCategory']['title'] . " (" . $studentsShareInfo->cName . ")",
                ],
                static::$pageKey => [
                    'title' => $studentsShareInfo->title,
                ],
            ];

            $this->baseRewriteWebInfo($breadcrumbData, $studentsShareInfo->title);
        }

        \View::share('data', $data);

        return view('front.studentsShare');
    }
}
