<?php

namespace App\Http\Middleware;

use Closure;

use App\Http\Controllers\BaseController;

class SessionHasAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if(session()->has(BaseController::$platform . '.account')) {
            // 後台選單
            if(BaseController::$platform == 'backend')
            {
                $backendMenuAuth = BaseController::baseGetBackendMenu( BaseController::$backendMenu, BaseController::baseGetSession('backend.user.data')->auth, 'getMenu');
                \View::share('backendMenuAuth', $backendMenuAuth);  // 前台網站設定

                $backendMainMenuAuth = BaseController::baseGetBackendMenu( BaseController::$backendMainMenu, BaseController::baseGetSession('backend.user.data')->auth, 'getMenu');
                \View::share('backendMainMenuAuth', $backendMainMenuAuth);  // 後台主目錄

                $hasAuth = BaseController::baseCheckAuth(BaseController::$pageKey);
                \View::share('hasAuth', $hasAuth);
            }
            return $next($request);
        }

        // 登入失敗時轉跳登入頁, 同時把要轉跳的頁面存入session
        BaseController::baseSetSession('default_page', $request->fullUrl());

        return redirect(BaseController::$basePath . 'login');
    }
}
