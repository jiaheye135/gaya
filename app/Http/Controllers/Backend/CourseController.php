<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class CourseController extends BaseController
{
    public function courseMgmt(Request $request){
        return view('backend.courseMgmt');
    }

    public function courseMgmtEdit(Request $request){
        \View::share('meetingMode', false);

        $type = $request->type;
        $dbId = ($type == 'add') ? 0 : $request->id;
        $detailList = $this->baseGetRepository('RepCourse')->getDetailList($dbId);

        \View::share('type', $type);
        \View::share('dbId', $dbId);
        \View::share('detailList', $detailList);

        return view('backend.courseMgmtEdit');
    }

    public function ajaxCourseMgmt(){
        $data = [];
        $method = $this->paramData['ajaxType'];

        if(method_exists($this, $method)){
            $data = $this->$method();
        }

        $this->baseJsonOutput($data);
    }

    public function getList(){
        $repCourse = $this->baseGetRepository('RepCourse');
        $data = $repCourse->get();
        return ['data' => $data];
    }

    public function editDetail(){
        $repCourse = $this->baseGetRepository('RepCourse');

        $data = $this->paramData['data'];
        $type = $this->paramData['type'];
        $dbId = $this->paramData['id'];

        $data = $this->basePretreatmentData($repCourse, $data, $type);

        $dbId = $repCourse->updateData($data, $type, $dbId);

        // 上傳圖片
        $this->baseUploadImgs($repCourse, $dbId);

        return ['success' => 1];
    }

    public function delList(){
        $this->baseGetRepository('RepCourse')->updateData(null, 'del', $this->paramData['id']);
        return ['success' => 1];
    }

    public function editMeetingDetail(){
        $repMeeting = $this->baseGetRepository('RepMeeting');

        $data = $this->paramData['data'];
        $type = $this->paramData['type'];
        $courseId = $this->paramData['id'];

        $hasExperienceMeeting = $data['has_experience_meeting'];
        unset($data['has_experience_meeting']);

        $this->baseGetRepository('RepCourse')->updateData(['has_experience_meeting' => $hasExperienceMeeting], 'edit', $courseId);

        $oldData = $repMeeting->get(['courseId' => $courseId]);
        if(count($oldData) > 0){
            $type = 'edit';
            $dbId = $oldData[0]->id;
        } else {
            $type = 'add';
            $dbId = 0;
        }
        
        $data['courseId'] = $courseId;
        $data['state'] = $hasExperienceMeeting;

        $data = $this->basePretreatmentData($repMeeting, $data, $type);

        $dbId = $repMeeting->updateData($data, $type, $dbId);

        // 上傳圖片
        $this->baseUploadImgs($repMeeting, $dbId, 'ajaxMeetingMgmt');

        return ['success' => 1];
    }

    public function meetingMgmtEdit(Request $request){
        \View::share('meetingMode', true);

        $type = $request->type;
        $dbId = ($type == 'add') ? 0 : $request->id;

        \View::share('type', $type);
        \View::share('dbId', $dbId);

        $mCourseData = [];
        $detailList = $this->baseGetRepository('RepCourse')->getDetailList($dbId);
        foreach($detailList as $i => $v){
            $mCourseData[$v['id']] = $v;
        }

        $detailList = $this->baseGetRepository('RepMeeting')->getDetailList($dbId);
        foreach($detailList as $i => $v){
            if($v['id'] == 'name' && !$v['value']) $detailList[$i]['value'] = $mCourseData['name']['value'] . '體驗會';
        }
        \View::share('detailList', $detailList);

        static::$pageInfo['title'] = $mCourseData['name']['value'] . static::$pageInfo['title'];
        \View::share('pageInfo', static::$pageInfo);

        return view('backend.courseMgmtEdit');
    }
}