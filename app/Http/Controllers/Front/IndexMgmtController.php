<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;

class IndexMgmtController extends BaseController
{
    public static function getIndexLifeExplore()
    {
        static::$pageKey = 'lifeExploreIndex';
        
        $repIndexInfo = static::baseGetRepository('RepIndexInfo');
        $indexInfo = $repIndexInfo->get(['info_type' => [1, 2], 'state' => 1]);

        return $indexInfo;
    }

    public static function getIndexIcelandArticle()
    {
        $mobileIconPosition = [
            "icon-01" => '30,90,185,215',
            "icon-02" => '57,245,199,352',
            "icon-03" => '153,348,304,455',
            "icon-04" => '47,474,191,617',
            "icon-05" => '474,117,620,233',
            "icon-06" => '387,295,530,413',
            "icon-07" => '453,479,604,614',
        ];

        $rep = static::baseGetRepository('RepIndexIceland');

        $select = ['item_key', 'item_img', 'article_type', 'article_id', 'student_share.title', 'ss_category.name as category_name', 'student_share.id', 'student_share.created_at'];
        $data = $rep->get([], $select, [], true);

        $icelandArticleInfo = [];
        foreach ($data as $v){
            if(isset($mobileIconPosition[$v->item_key])){
                $v->position = $mobileIconPosition[$v->item_key];
            }
            $v->myTitle = $v->category_name . ' - ' . $v->title;
            $icelandArticleInfo[$v->item_key] = $v;
        }

        return $icelandArticleInfo;
    }

    public static function getIndexStudentShare()
    {
        $rep = static::baseGetRepository('RepIndexStudentShare');

        $select = [
            'student_share.title',
            'student_share.share_content',
            // 'ss_category.name as category_name',
            'index_student_share.show_name',
            'index_student_share.article_type',
            'student_share.created_at',
            'student_share.id',
        ];
        $data = $rep->get(['index_student_share.state' => 1, 'index_student_share.article_id%more%' => 0], $select, ['index_student_share.sort' => 'asc'], true);

        foreach ($data as $v){
            $v->introduction = mb_substr(html_entity_decode(strip_tags($v->share_content)), 0, 130) . ' .....';
        }
        
        return $data;
    }
}