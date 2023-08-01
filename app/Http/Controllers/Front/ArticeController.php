<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class ArticeController extends BaseController
{
    public function artice(Request $request)
    {
        return view('front.artice');
    }
}
