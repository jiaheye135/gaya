<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Repositories\CaseServiceItemRepository;
use Illuminate\Http\Request;

class ServiceItemsController extends BaseController
{
    private CaseServiceItemRepository $caseServiceItemRepo;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->caseServiceItemRepo = app()->make(CaseServiceItemRepository::class);
    }

    public function serviceItems()
    {
        return view('backend.caseServiceItems');
    }

    public function editServiceIiem(Request $request)
    {
        $type = $request->type;
        $dbId = $request->id;
        $name = $request->name;
        $data = [];

        if($type == 'add' && $name){
            if($this->caseServiceItemRepo->checkExists([['name', $name]])){
                return ['success' => 0, 'errMsg' => '"' . $name . '" 已存在'];
            }
            $data['name'] = $name;
            $dbId = '';
        }

        $dbId = $this->caseServiceItemRepo->updateData($data, $type, $dbId);
        return ['success' => 1, 'service_items_id' => $dbId];
    }

    public function getServiceIiems()
    {
        $data = $this->caseServiceItemRepo->all();
        return ['data' => $data];
    }
}
