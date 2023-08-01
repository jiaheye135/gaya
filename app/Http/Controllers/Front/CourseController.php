<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;
use App\Services\SendEmailService;

class CourseController extends BaseController
{
    public function sendEmailCoupon(){
        $meetingData = [];
        $repWebInfo = static::baseGetRepository('RepWebInfo');
        $m = $repWebInfo->get(['info_type' => [2, 3, 4, 5, 6]]);
        foreach($m as $v){
            $v->value = json_decode($v->value, true);
            $meetingData[$v->info_type] = $v;
        }
        $repCourse = $this->baseGetRepository('RepCourse');
        $course = $repCourse->get(['id' => 15], ['name', 'experience_meeting_date']);
        $meetingDate = $course[0]->experience_meeting_date;
        var_dump($meetingData);
        $week = ['日', '一', '二', '三', '四', '五', '六'];
        foreach($meetingDate as $i => $v){
            $meetingDate[$i] = date('Y/m/d', strtotime($v)) . '(' . $week[date('w', strtotime($v))] . ')';
        }
        \View::share('meetingData', $meetingData);
        \View::share('courseName', '生命探索體驗會');
        \View::share('meetingDate', $meetingDate);
        \View::share('randomCode', '123456');
        \View::share('memberName', '123456');
        \View::share('memberTel', '123456');
        \View::share('memberEmail', '123456');

        return view('front.emails.coupon');
    }
    
    public function sendMeetCoupon($memberEmail, $emailData){
        $meetingData = [];
        $repWebInfo = static::baseGetRepository('RepWebInfo');
        $m = $repWebInfo->get(['info_type' => [2, 3, 4, 5, 6]]);
        foreach($m as $v){
            $v->value = json_decode($v->value, true);
            $meetingData[$v->info_type] = $v;
        }
        $pageData = [
            'meetingData' => $meetingData,
            'courseName'  => $emailData['courseName'],
            'randomCode'  => $emailData['randomCode'],
            'meetingDate' => $emailData['meetingDate'],
            'memberName'  => $emailData['memberName'],
            'memberTel'   => $emailData['memberTel'],
            'memberEmail' => $emailData['memberEmail'],
        ];

        $sendEmailServ = new SendEmailService();

        $emailTitle = '歡迎領取' . $pageData['courseName'] . '優惠券';
        return $sendEmailServ->sendEmail('front.emails.coupon',  $emailTitle, [$memberEmail], $pageData);
    }

    public function ajaxJoinMeet(){
        $memberName = $this->paramData['data']['member_name'];
        $memberTel = $this->paramData['data']['member_tel'];
        $memberEmail = $this->paramData['data']['member_email'];
        $courseId = $this->paramData['meetId'];

        $repCourse = $this->baseGetRepository('RepCourse');
        $course = $repCourse->get(['id' => $courseId], ['name', 'experience_meeting_date']);

        if( count($course) == 0 ){
            return ['errMsg' =>'無此課程'];
        }

        $courseName = $course[0]->name;
        $meetingDate = $course[0]->experience_meeting_date;

        $week = ['日', '一', '二', '三', '四', '五', '六'];
        foreach($meetingDate as $i => $v){
            $meetingDate[$i] = date('Y/m/d', strtotime($v)) . '(' . $week[date('w', strtotime($v))] . ')';
        }

        $rep = $this->baseGetRepository('RepCouponMember');
        $oldData = $rep->get(['member_email' => $memberEmail, 'course_id' => $courseId], ['*']);

        if( count($oldData) > 0 ){
            return ['errMsg' =>'您已經領過' . $oldData[0]->course_name . '優惠券了!'];
        }

        $file = storage_path() . '/randcode/usedcode';
        $usedCode = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

        $randomCode = 'M' . $this->baseBuildRandomCode();
        while(in_array($randomCode, $usedCode)){
            $randomCode = 'M' . $this->baseBuildRandomCode();
        }

        $usedCode[] = $randomCode;
        file_put_contents($file, json_encode($usedCode));

        $emailData = [
            'courseName' => $courseName,
            'randomCode' => $randomCode,
            'meetingDate' => $meetingDate,
            'memberName' => $memberName,
            'memberTel' => $memberTel,
            'memberEmail' => $memberEmail,
        ];

        $sendError = $this->sendMeetCoupon($memberEmail, $emailData);
        if( count($sendError) > 0) return ['errMsg' => '寄信失敗'];

        $data = [
            'member_name' => $memberName,
            'member_tel' => $memberTel,
            'member_email' => $memberEmail,
            'course_id' => $courseId,
            'course_name' => $course[0]->name,
            'coupon_code' => $randomCode,
            'ip' => $this->clientIp,
        ];

        $rep->updateData($data, 'add');

        return ['success' => 1, 'msg' => $courseName . '優惠券已經寄到 ' . $memberEmail .'，請確認您的信箱!'];
    }

    public function course()
    {
        $data = ['hasCourse' => 0];

        $repCourse = $this->baseGetRepository('RepCourse');
        $m = $repCourse->get(['created_at' => $this->paramData['time']], ['*']);

        if(count($m) > 0 && $this->paramData['key'] == md5($m[0]->id) && $m[0]->state){
            $data['hasCourse'] = 1;

            $courseInfo = $m[0];
            $courseInfo->has_experience_meeting = 0;

            $m = $repCourse->get(['name' => $courseInfo->name . '體驗會', 'is_meeting' => 1, 'state' => 1], ['experience_meeting_fee']);
            if(count($m) > 0){  // 檢查是否有體驗會
                $courseInfo->has_experience_meeting = 1;
                $courseInfo->experience_meeting_fee = $m[0]->experience_meeting_fee;
            }

            $data['courseInfo'] = $courseInfo;

            if($courseInfo->is_meeting == 1){ // 體驗會資訊
                $meetingData = WebInfoController::getMeetingData($courseInfo);
                \View::share('meetingData', $meetingData);

                $meets = $repCourse->get(['is_meeting' => 1, 'state' => 1], ['name', 'id', 'created_at'], ['sort' => 'asc'], true);
                \View::share('meets', $meets);
            }

            // baseRewriteWebInfo
            $breadcrumbData = [
                static::$pageKey => [
                    'title' => $this->breadcrumb[static::$pageKey]['title'] . " (" . $courseInfo->name . ")",
                ],
            ];

            $this->baseRewriteWebInfo($breadcrumbData, $courseInfo->name);
        }

        \View::share('data', $data);

        return view('front.course');
    }

    public static function getIndexCourse()
    {
        $repCourse = static::baseGetRepository('RepCourse');
        $courseInfo = $repCourse->get(['state' => 1], ['*'], ['sort' => 'asc'], true);

        return static::courseIndexStyle($courseInfo);
    }

    public static function courseIndexStyle($data)
    {
        $rowMax = 3;

        /**
         * 定義 style
         * key: 餘數
         * value: style name
         */
        $style = [
            0 => 'style1',
            2 => 'style2',
            1 => 'style3',
        ];

        $len = count($data);
        $remainder = $len % $rowMax;
        $data[ $len - 1 ]->htmlStyle = $style[ $remainder ];

        if($remainder == 2){
            $data[ $len - 2 ]->htmlStyle = $style[ $remainder ];
        }

        return $data;
    }
}
