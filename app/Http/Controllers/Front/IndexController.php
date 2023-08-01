<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        $repBanner = $this->baseGetRepository('RepBanner');
        $bannerInfo = $repBanner->get(['state' => 1], ['*'], ['sort' => 'asc']);

        \View::share('bannerInfo', $bannerInfo);

        $data = [
            'indexInfo' => IndexMgmtController::getIndexLifeExplore(),
            'courseInfo' => CourseController::getIndexCourse(),
            'icelandArticleInfo' => IndexMgmtController::getIndexIcelandArticle(),
            'studentShareInfo' => IndexMgmtController::getIndexStudentShare(),
            'photoGalleryInfo' => PhotoGalleryController::getIndexPhotoGallery(),
        ];

        \View::share('data', $data);

        return view('front.index');
    }
}
