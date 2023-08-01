<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;

class LoginController extends BaseController
{
    public function testThirdLogin($testId)
    {
        return view("front.testThirdLogin$testId");
    }
}