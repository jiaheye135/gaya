<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class MenuController extends BaseController
{
    public function aboutLE()
    {
        $data = ['hasCourse' => 0];

        $repCourse = $this->baseGetRepository('RepAboutMenu');
        $m = $repCourse->get(['created_at' => $this->paramData['time']], ['*']);

        if(count($m) > 0 && $this->paramData['key'] == md5($m[0]->id) && $m[0]->state){
            $data['hasCourse'] = 1;

            $courseInfo = $m[0];
            $data['courseInfo'] = $courseInfo;

            // baseRewriteWebInfo
            $breadcrumbData = [
                static::$pageKey => [
                    'title' => $this->breadcrumb[static::$pageKey]['title'] . " (" . $courseInfo->item_title . ")",
                ],
            ];

            $this->baseRewriteWebInfo($breadcrumbData, $courseInfo->item_title);
        }

        \View::share('data', $data);

        return view('front.aboutLE');
    }
}
