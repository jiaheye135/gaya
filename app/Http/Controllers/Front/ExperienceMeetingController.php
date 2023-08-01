<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class ExperienceMeetingController extends BaseController
{
    public function experienceMeeting(Request $request)
    {
        $data = ['hasCourse' => 0];

        $repMeeting = $this->baseGetRepository('RepMeeting');
        $courseInfo = $repMeeting->get(['created_at' => $this->paramData['time']], ['*']);

        if(count($courseInfo) > 0 && $this->paramData['key'] == md5($courseInfo[0]->id) && $courseInfo[0]->state){
            $data['hasCourse'] = 1;
            $data['courseInfo'] = $courseInfo[0];

            $this->breadcrumb['cource'] = ['title' => $courseInfo[0]->name];
            \View::share('breadcrumb', $this->breadcrumb);

            $meetingData = [];
            $repWebInfo = $this->baseGetRepository('RepWebInfo');
            $m = $repWebInfo->get(['info_type' => [4, 5, 6]]);
            foreach($m as $v){
                $v->value = json_decode($v->value, true);
                $meetingData[$v->info_type] = $v;
            }

            $experienceMeetingDate = $courseInfo[0]->experience_meeting_date;
            $week = ['日', '一', '二', '三', '四', '五', '六'];
            foreach($experienceMeetingDate as $i => $v){
                $experienceMeetingDate[$i] = date('Y/m/d', strtotime($v)) . '(' . $week[date('w', strtotime($v))] . ')';
            }

            $meetingData['experience_meeting_date'] = $experienceMeetingDate;
            $meetingData['experience_meeting_fee'] = $courseInfo[0]->experience_meeting_fee;
            
            \View::share('meetingData', $meetingData);
        }

        \View::share('data', $data);

        return view('front.experienceMeeting');
    }
}
