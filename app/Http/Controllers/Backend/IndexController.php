<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class IndexController extends BaseController
{
    public function index(Request $request){
        return view('backend.index');
    }
}