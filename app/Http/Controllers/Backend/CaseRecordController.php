<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Repositories\CaseUserRepository;
use Illuminate\Http\Request;

class CaseRecordController extends BaseController
{
    private CaseUserRepository $caseUserRepo;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->caseUserRepo = app()->make(CaseUserRepository::class);
    }

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

    public function caseRecord()
    {
        return view('backend.caseRecord');
    }

    // 取得個案列表
    public function getCaseUserList()
    {
        $data = $this->caseUserRepo->get();
        return ['data' => $data];
    }

    // 個案資料
    public function caseUser(Request $request)
    {
        $dbId = $request->type == 'add' ? '' : $request->id;

        $detailList = $this->caseUserRepo->getDetailList($dbId);

        \View::share('detailList', $detailList);
        \View::share('doType', ['type' => $request->type, 'id' => $dbId]);
        return view('backend.caseUser');
    }

    // 編輯個案資料
    public function caseUserEdit()
    {
        $data = $this->paramData['data'];
        $type = $this->paramData['type'];
        $dbId = $this->paramData['id'];

        $detailList = $this->caseUserRepo->getDetailList($dbId);
        $data = $this->basePretreatmentDataV1($detailList, $data, $type);
        
        $dbId = $this->caseUserRepo->updateData($data, $type, $dbId);
        return ['success' => 1];
    }

    public function caseUserRecord()
    {
        \View::share('detailList', []);

        return view('backend.caseUserRecord');
    }
}
