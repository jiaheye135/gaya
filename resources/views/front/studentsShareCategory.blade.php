@extends('front.layouts.main')

@section('content')

@include('front.include.breadcrumb')

<!-- END MAIN CONTENT -->
<div class="main_content">
    <!-- START SECTION -->
    <div class="section pb_40 article_list">
        <!-- <div class="course-header">
            <img src="assets/images/pages/article-img-header-2@2x.png">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <h2 class="course-title">文章分享列表</h2>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12" style="">
                    <div class="select-search-bar">
                        <div class="custom-select">
                            <select id="category" onchange="categoryChange()">
                                @foreach ($categoryData as $v)
                                <option value="{{ $v->id }}" {!! ($cid == $v->id) ? 'selected' : '' !!}>{{ $v->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row"></div>
            <div id="pagination-tab-a"></div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT -->

<!-- pagination -->
<link rel="stylesheet" href="{{ $webPath }}assets/css/pagination.css">
<script src="{{ $webPath }}assets/js/pagination.js"></script>

<style>
    html{
        overflow-y: scroll;
    }
</style>

<script>
    //分頁
    function pagination(name) {
        var cid = $('#category').val();
        if(cid == gCid) return;

        gCid = cid;

        var container = $("#pagination-" + name);
        container.html('');
        
        var options = {
            dataSource: '{{ $basePath }}ajaxGetStudentShare?cid=' + cid,
            locator: 'data',
            totalNumberLocator: function(response) {
                return response.length;
            },
            pageSize: 6,
            pageRange: 1,
            ajax: {
                beforeSend: function() {
                    container.prev().html('<div style="margin-bottom: 1em; width: 100%; text-align: center; color: #D0D0D0;">Loading data ...</div>');
                }
            },
            callback: function (response, pagination) {
                var dataHtml = '';
        
                $.each(response, function (index, item) {
                    dataHtml += '<div class="col-lg-4 col-sm-4"><a href="' + item.href + '"><img src="{{ $publicPath }}' + item.photo + '"></a>';
                    dataHtml +=     '<h2 class="title">'+ item.title + "</h2>";
                    dataHtml +=     '<div class="short-content">' + item.share_content + '</div>';
                    dataHtml +=     '<div class="more-link" style="cursor: pointer;" onclick="javascript:location.href=\'' + item.href + '\';">more</div>';
                    dataHtml += '</div>';
                });
        
                dataHtml += '';
            
                container.prev().html(dataHtml);
            },
        };

        container.pagination(options);
    }

    function categoryChange(){
        pagination("tab-a");
    }

    var gCid = 0;
    pagination("tab-a");
</script>

@endsection