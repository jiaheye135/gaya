<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class CouponMemberController extends BaseController
{
    public function ajaxCouponMember(){
        $data = [];
        $method = $this->paramData['ajaxType'];

        if(method_exists($this, $method)){
            $data = $this->$method();
        }

        $this->baseJsonOutput($data);
    }

    public function getList(){
        $rep = $this->baseGetRepository('RepCouponMember');

        $where = [];
        if(isset($this->paramData['courseName']) && $this->paramData['courseName']){
            $where['course_name'] = $this->paramData['courseName'];
        }
        if(isset($this->paramData['checkIn']) && $this->paramData['checkIn'] > -1){
            $where['check_in'] = $this->paramData['checkIn'];
        }

        $data = $rep->get($where, ['*'], ['created_at'=> 'desc']);
        return ['data' => $data];
    }

    public function checkIn(){
        $checkInAt = date('Y-m-d H:i:s');
        $rep = $this->baseGetRepository('RepCouponMember');
        $rep->updateData(['check_in' => 1, 'check_in_at' => $checkInAt], 'edit', $this->paramData['id']);

        return ['success' => 1, 'checkInAt' => $checkInAt];
    }

    public function couponMember(){
        $courseList = $this->baseGetRepository('RepCouponMember')->getCourseList();
        \View::share('courseList', $courseList);

        return view('backend.couponMember');
    }
}
