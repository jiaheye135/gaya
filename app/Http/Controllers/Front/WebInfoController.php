<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;

class WebInfoController extends BaseController
{
    public static function getFooterInfo()
    {
        $footerInfo = [];
        $repWebInfo = static::baseGetRepository('RepWebInfo');
        $m = $repWebInfo->get(['info_type' => [1, 2, 3]]);
        foreach($m as $v){
            $v->value = json_decode($v->value, true);
            $footerInfo[$v->info_type] = $v;
        }

        return $footerInfo;
    }

    public static function getMeetingData($courseInfo)
    {
        $meetingData = [];
        $repWebInfo = static::baseGetRepository('RepWebInfo');
        $m = $repWebInfo->get(['info_type' => [4, 5, 6]]);
        foreach($m as $v){
            $v->value = json_decode($v->value, true);
            $meetingData[$v->info_type] = $v;
        }

        $experienceMeetingDate = [];
        $week = ['日', '一', '二', '三', '四', '五', '六'];
        foreach($courseInfo->experience_meeting_date as $v){
            $experienceMeetingDate[] = date('Y/m/d', strtotime($v)) . '(' . $week[date('w', strtotime($v))] . ')';
        }

        $html = '';
        if($courseInfo->start_class == 1){
            foreach($experienceMeetingDate as $d){
                $html .= '<div class="subtitle"><span class="square-middle"></span>' . $d . '</div>';
            }
        } else {
            $html .= '<div class="on_open">尚未開課，敬請期待~</div>';
        }

        $meetingData['experience_meeting_date'] = $html;
        $meetingData['experience_meeting_fee'] = $courseInfo->experience_meeting_fee;

        return $meetingData;
    }
}