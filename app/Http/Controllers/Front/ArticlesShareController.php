<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class ArticlesShareController extends BaseController
{
    public function ajaxGetArticleShare(Request $request)
    {
        $page   = $request->pageNumber;
        $limit  = $request->pageSize;
        $offset = ($page - 1) * $limit;

        $cid = $request->cid;

        return $this->getArticleShare($cid, $offset, $limit);
    }

    public function getArticleShare($cid, $offset = 0, $limit = 0)
    {
        $rep = $this->baseGetRepository('RepArticleShare');
        $where = [
            'article_share.category_id' => $cid,
            'as_category.state' => 1,
            'article_share.state' => 1,
        ];
        $select = ['article_share.id', 'article_share.created_at', 'article_share.title', 'article_share.share_content', 'article_share.photo'];
        $data = $rep->get($where, $select, ['article_share.sort' => 'asc', 'article_share.id' => 'desc'], true, $offset, $limit);

        return $data;
    }
    
    public function articlesShareCategory(Request $request)
    {
        $cid = 0; $cName = '';

        $rep = $this->baseGetRepository('RepAsCategory');
        $categoryData = $rep->get(['state' => 1], ['id', 'name', 'created_at'], ['sort' => 'asc']);
        if(isset($categoryData[0])){
            $cid = $categoryData[0]->id;
            $cName = $categoryData[0]->name;
        }

        \View::share('categoryData', $categoryData);

        if(isset($this->paramData['time'])) {
            foreach($categoryData as $v){
                if($v->created_at == $this->paramData['time'] && md5($v->id) == $this->paramData['key']){
                    $cid = $v->id;
                    $cName = $v->name;
                }
            }
        }

        \View::share('cid', $cid);

        // $page   = 1;
        // $limit  = 6;
        // $offset = ($page - 1) * $limit;

        // $data = $this->getArticleShare($cid, $offset, $limit);
        // \View::share('data', $data);

        // baseRewriteWebInfo
        $breadcrumbData = [
            static::$pageKey => [
                'title' => $this->breadcrumb[static::$pageKey]['title'] . " (" . $cName . ")",
            ],
        ];

        $this->baseRewriteWebInfo($breadcrumbData, $cName);

        return view('front.articlesShareCategory');
    }

    public function articlesShare(Request $request)
    {
        $data = ['hasArticlesShare' => 0];

        $repArticleShare = $this->baseGetRepository('RepArticleShare');

        $select = [
            'article_share.id',
            'article_share.state',
            'article_share.title',
            'article_share.share_content',
            'article_share.content_photo',
            'as_category.id as cId',
            'as_category.name as cName',
            'as_category.created_at as cCreated',
        ];

        $m = $repArticleShare->get(['article_share.created_at' => $this->paramData['time']], $select);
        $m = $m['data'];

        if(count($m) > 0 && $this->paramData['key'] == md5($m[0]->id) && $m[0]->state){
            $data['hasArticlesShare'] = 1;

            $articlesShareInfo = $m[0];

            $myTitle = $articlesShareInfo->cName . ' - ' . $articlesShareInfo->title;
            $articlesShareInfo->myTitle = $myTitle;

            $data['articlesShareInfo'] = $articlesShareInfo;

            // baseRewriteWebInfo
            $breadcrumbData = [
                'articlesShareCategory' => [
                    'id' => $articlesShareInfo->cId,
                    'createdAt' => $articlesShareInfo->cCreated,
                    'title' => $this->breadcrumb['articlesShareCategory']['title'] . " (" . $articlesShareInfo->cName . ")",
                ],
                static::$pageKey => [
                    'title' => $articlesShareInfo->title,
                ],
            ];

            $this->baseRewriteWebInfo($breadcrumbData, $articlesShareInfo->title);
        }

        \View::share('data', $data);

        return view('front.articlesShare');
    }
}
