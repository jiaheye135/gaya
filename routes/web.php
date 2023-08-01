<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('testThirdLogin{testId}', 'Front\LoginController@testThirdLogin');

// front
Route::get('/', 'Front\IndexController@index');
Route::get('aboutLE', 'Front\MenuController@aboutLE');
Route::get('artice', 'Front\ArticeController@artice');
Route::get('course', 'Front\CourseController@course');
Route::get('experienceMeeting', 'Front\ExperienceMeetingController@experienceMeeting');
Route::get('studentsShare', 'Front\StudentsShareController@studentsShare');
Route::get('studentsShareCategory', 'Front\StudentsShareController@studentsShareCategory');
Route::get('articlesShare', 'Front\ArticlesShareController@articlesShare');
Route::get('articlesShareCategory', 'Front\ArticlesShareController@articlesShareCategory');
Route::get('photoGallery', 'Front\PhotoGalleryController@photoGallery');

Route::get('ajaxGetStudentShare', 'Front\StudentsShareController@ajaxGetStudentShare');
Route::get('ajaxGetArticleShare', 'Front\ArticlesShareController@ajaxGetArticleShare');
Route::post('ajaxJoinMeet', 'Front\CourseController@ajaxJoinMeet');

// Route::get('sendEmailCoupon', 'Front\CourseController@sendEmailCoupon');

// facebook webhook
Route::any('fbWebhook', 'MessengerController@webhook');

// backend
Route::group(['prefix' => 'admin-backend'], function () {
    Route::get('login', 'Backend\LoginController@login');
    Route::post('ajaxLogin', 'Backend\LoginController@ajaxLogin');

    Route::group(['middleware' => 'session.has.account'], function () {
        Route::get('index', 'Backend\IndexController@index');

        Route::get('bannerMgmt', 'Backend\BannerController@bannerMgmt');
        Route::get('bannerMgmtEdit', 'Backend\BannerController@bannerMgmtEdit');
        Route::post('ajaxBannerMgmt', 'Backend\BannerController@ajaxBannerMgmt');

        Route::get('lifeExploreIndex', 'Backend\IndexMgmtController@lifeExploreIndex');
        Route::post('ajaxIndexMgmt', 'Backend\IndexMgmtController@ajaxIndexMgmt');

        Route::get('icelandArticleIndex', 'Backend\IndexMgmtController@icelandArticleIndex');
        Route::post('ajaxIndex', 'Backend\IndexMgmtController@ajaxIndex');

        Route::get('studentShareIndex', 'Backend\IndexMgmtController@studentShareIndex');

        Route::get('courseMgmt', 'Backend\CourseController@courseMgmt');
        Route::get('courseMgmtEdit', 'Backend\CourseController@courseMgmtEdit');
        Route::post('ajaxCourseMgmt', 'Backend\CourseController@ajaxCourseMgmt');

        Route::get('aboutMenuMgmt', 'Backend\MenuController@aboutMenuMgmt');
        Route::get('aboutMenuMgmtEdit', 'Backend\MenuController@aboutMenuMgmtEdit');
        Route::post('ajaxAboutMenuMgmt', 'Backend\MenuController@ajaxAboutMenuMgmt');

        Route::get('ssCategoryMgmt', 'Backend\StudentShareController@ssCategoryMgmt');
        Route::get('ssCategoryMgmtEdit', 'Backend\StudentShareController@ssCategoryMgmtEdit');
        Route::post('ajaxStudentShareMgmt', 'Backend\StudentShareController@ajaxStudentShareMgmt');

        Route::get('studentShareMgmt', 'Backend\StudentShareController@studentShareMgmt');
        Route::get('studentShareMgmtEdit', 'Backend\StudentShareController@studentShareMgmtEdit');

        Route::get('asCategoryMgmt', 'Backend\ArticleShareController@asCategoryMgmt');
        Route::get('asCategoryMgmtEdit', 'Backend\ArticleShareController@asCategoryMgmtEdit');
        Route::post('ajaxArticleShareMgmt', 'Backend\ArticleShareController@ajaxArticleShareMgmt');

        Route::get('articleShareMgmt', 'Backend\ArticleShareController@articleShareMgmt');
        Route::get('articleShareMgmtEdit', 'Backend\ArticleShareController@articleShareMgmtEdit');

        Route::get('meetingMgmtEdit', 'Backend\CourseController@meetingMgmtEdit');
        
        Route::get('pgCategoryMgmt', 'Backend\PhotoGalleryController@pgCategoryMgmt');
        Route::get('pgCategoryMgmtEdit', 'Backend\PhotoGalleryController@pgCategoryMgmtEdit');
        Route::post('ajaxPhotoGalleryMgmt', 'Backend\PhotoGalleryController@ajaxPhotoGalleryMgmt');

        Route::get('photoGalleryUpload', 'Backend\PhotoGalleryController@photoGalleryUpload');
        Route::get('photoGalleryMgmt', 'Backend\PhotoGalleryController@photoGalleryMgmt');

        Route::get('footerInfo', 'Backend\WebInfoController@footerInfo');
        Route::post('ajaxFooterInfo', 'Backend\WebInfoController@ajaxFooterInfo');

        Route::get('meetingInfo', 'Backend\WebInfoController@meetingInfo');

        Route::get('couponMember', 'Backend\CouponMemberController@couponMember');
        Route::post('ajaxCouponMember', 'Backend\CouponMemberController@ajaxCouponMember');

        Route::get('adminList', 'Backend\AdminsController@adminList');
        Route::get('adminListEdit', 'Backend\AdminsController@adminListEdit');
        Route::post('ajaxAdminMgmt', 'Backend\AdminsController@ajaxAdminMgmt');
    });
});
