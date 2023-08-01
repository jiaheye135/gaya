@extends('backend.layouts.main')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">Iceland Article List</h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%; text-align: center;">
        </table>
    </div>
</div>

<script>
    function selectArticle(obj, id){
        var newArticleType = $(obj).parents('td').find('select:eq(0) option:selected').text();
        var newArticleTitle = $(obj).parents('td').find('select:eq(1) option:selected').text();
        if($(obj).parents('tr').find('.a-title').text() == newArticleTitle && $(obj).parents('tr').find('.a-type').text() == newArticleType) return;

        if( !confirm('確定選擇文章?') ) return;

        var wData = {'id': id, 'ajaxType': 'selectArticle'};
        wData['articleType'] = $(obj).parents('td').find('select:eq(0)').val();
        wData['articleId'] = $(obj).parents('td').find('select:eq(1)').val();
        wData['pageKey'] = '{{$pageKey}}';

        gMyJs.doAjax(gBasePath + 'ajaxIndex', {'data': gMyJs.jwtEncode(wData)},
            function(data, resData){
                if (resData.success) {
                    $(obj).parents('tr').find('.a-type').text( $(obj).parents('td').find('select:eq(0) option[value=' + wData['articleType'] + ']').text() );
                    $(obj).parents('tr').find('.a-title').text( $(obj).parents('td').find('select:eq(1) option[value=' + wData['articleId'] + ']').text() );
                } else {
                    alert(resData.errMsg);
                }
            },
            function(){
                alert('系統錯誤');
            }
        );
    }

    var gDataTable = null;

    $(function(){
        var selectList = @json($selectList);

        gDataTable = $('#dataTable').DataTable({
            "order": [],
            "searching": false,
            // "autoWidth": false,
            "scrollY": "500px",
            "scrollX": true,
            "fixedColumns": {
                leftColumns: 1,
            },
            "columnDefs": [
                { 
                    "targets": 0, "width": "133px",
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        $(nTd).css('min-width', '133px');
                    }
                },
                { 
                    "targets": 1,
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        $(nTd).css('line-height', 6);
                        $(nTd).addClass('a-type');
                    }
                },
                { 
                    "targets": 2,
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        $(nTd).css('line-height', 6);
                        $(nTd).addClass('a-title');
                    }
                },
                { 
                    "targets": 3, "width": "420px",
                    "fnCreatedCell": function (nTd) {
                        $(nTd).css('text-align', 'left');
                    }
                },
            ],
            "aoColumns": [
                { "sTitle": "項目", "mData": "item_img", "mRender": function(data, type, row){
                        return '<img src="' + gPublicPath + data + '" width="100%">'; 
                    },
                    "orderable": false
                },
                { "sTitle": "文章類型", "mData": "article_type_title", "orderable": false },
                { "sTitle": "文章標題", "mData": "title", "mRender": function(data, type, row){
                        return (data) ? '(' + row.category_name + ') ' + data : '';
                    },
                    "orderable": false
                },
                { "sTitle": "選擇文章", "mData": "article_id", "mRender": function(data, type, row){
                        var h = '';
                        h += '<div style="display: inline-block;">';
                        h +=    '<select class="select-aricle form-control bg-light">';
                        for (var key in selectList) {
                            h +=    '<option value="' + key + '">' + selectList[key]['name'] + '</option>';
                        }
                        h +=    '</select>';

                        h +=    '<select class="select-aricle form-control bg-light mt-3 mr-3">';
                        for (var key in selectList[ Object.keys(selectList)[0] ]['list']) {
                            var d = selectList[ Object.keys(selectList)[0] ]['list'][key];
                            h +=    '<option value="' + d.id + '">' + '(' + d.category_name + ') ' + d.title + '</option>';
                        }
                        h +=    '</select>';
                        h += '</div>';

                        h += '<div style="display: inline-block;">';
                        h +=    '<button type="button" onclick="selectArticle(this, ' + row.id + ')" class="btn btn-info">選擇文章</button>';
                        h += '</div>';
                        return h;
                    },
                    "orderable": false
                },
            ],
            "ajax": {
                "headers": { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                "url": gBasePath + 'ajaxIndex',
                "type": "POST",
                "data": function (d) {
                    var data = {
                        'ajaxType': 'getList',
                    };
                    return $.extend({}, d, {'data': gMyJs.jwtEncode(data)});
                }
            },
        });
    });
</script>

@endsection