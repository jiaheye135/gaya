<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class PhotoGalleryController extends BaseController
{
    public static function getIndexPhotoGallery(){
        $rep = static::baseGetRepository('RepPgCategory');
        $data = $rep->get(['state' => 1], ['name', 'id', 'created_at'], ['sort' => 'asc'], true);

        $rep = static::baseGetRepository('RepPhotoGallery');
        $photoData = $rep->get(['category_id' => array_column($data->toArray(), 'id'), 'show_index_web' => 1, 'state' => 1], ['category_id', 'img']);

        $m = []; foreach($photoData as $v){ $m[$v->category_id] = $v->img; }

        foreach($data as $v){
            $v->img = isset($m[$v->id]) ? $m[$v->id] : '';
        }
        
        return $data;
    }

    public function photoGallery(){
        $rep = static::baseGetRepository('RepPgCategory');
        $categorySelect = $rep->get(['state' => 1], ['name', 'id', 'created_at', 'introduction'], ['sort' => 'asc'], true);
        $category = isset($categorySelect[0]) ? $categorySelect[0] : null;
        $selectedI = 0;
        foreach($categorySelect as $i => $v){
            $v->selected = '';
            if(isset($this->paramData['time']) && $this->paramData['time'] == $v->created_at && 
                isset($this->paramData['key']) && $this->paramData['key'] == md5($v->id)){
                $v->selected = 'selected';
                $category = $v;
                $selectedI = $i;
            }
        }

        \View::share('selectedI', $selectedI);
        \View::share('categorySelect', $categorySelect);
        \View::share('category', $category);

        $photoData = [];
        if($category){
            $rep = static::baseGetRepository('RepPhotoGallery');
            $photoData = $rep->get(['category_id' => $category->id, 'state' => 1], ['img', 'name'], ['sort' => 'asc']);

            // baseRewriteWebInfo
            $breadcrumbData = [
                static::$pageKey => [
                    'title' => $this->breadcrumb[static::$pageKey]['title'] . " (" . $category->name . ")",
                ],
            ];

            $this->baseRewriteWebInfo($breadcrumbData, $category->name);
        }

        \View::share('photoData', $photoData);

        return view('front.photoGallery');
    }
}