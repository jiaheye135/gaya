@extends('backend.layouts.main')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">Students Share List</h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%; text-align: center;">
            <thead>
                <tr>
                    <td>排序</td>
                    <td>文章標題</td>
                    <td>選擇文章</td>
                    <td>顯示標題</td>
                    <td>啟用狀態</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i => $v)
                <tr>
                    <td>{{$v->sort}}</td>
                    <td>{{($v->title) ? $v->title . '(' . $v->category_name . ')' : ''}}</td>
                    <td>
                        <div style="display: inline-block;">
                            <select class="select-aricle form-control bg-light mr-1">
                                @foreach ($selectList as $sv)
                                <option value="{{$sv->id}}">{{$sv->title . '(' . $sv->category_name . ')'}}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <div class="title-div">
                            <button type="button" onclick="selectArticle(this, {{$v->id}})" class="btn btn-info">選擇文章</button>
                        </div>
                    </td>
                    <td>
                        <div class="title-div mr-1 show">{{$v->show_name}}</div>
                        <div class="title-div">
                            <button type="button" onclick="editTitle(this, {{$i}})" class="btn btn-info">編輯</button>
                            <button type="button" onclick="copyTitle(this, {{$i}})" class="btn btn-dark">複製文章標題</button>
                        </div>
                    </td>
                    <td>
                        <?php $r0 = ($v->state == 0) ? 'checked' : ''; $r1 = ($v->state == 1) ? 'checked' : ''; ?>
                        <div class="custom-control custom-radio" style="display: inline-block; margin: 0 0.25em;">
                            <input class="custom-control-input" id="{{$i}}_1" type="radio" name="name_{{$i}}" value=1 {{$r1}}>
                            <label class="custom-control-label" for="{{$i}}_1" style="font-weight: bolder; vertical-align: unset;">啟用</label>
                        </div>
                        <div class="custom-control custom-radio" style="display: inline-block; margin: 0 0.25em;">
                            <input class="custom-control-input" id="{{$i}}_0" type="radio" name="name_{{$i}}" value=0 {{$r0}}>
                            <label class="custom-control-label" for="{{$i}}_0" style="font-weight: bolder; vertical-align: unset;">不啟用</label>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function changeState(){
        var data = {id: @json($data)[this.id.split('_')[0]].id, newState: this.value, ajaxType: 'editStudentShare'};
        doAjax(data);
    }

    function doEdit(newTitle, i){
        if (newTitle == gTmpTitle) return
        
        var data = {id: @json($data)[i].id, newTitle: newTitle, ajaxType: 'editStudentShare'};
        doAjax(data);
    }

    function doAjax(data){
        gMyJs.doAjax(gBasePath + 'ajaxIndex', {'data': gMyJs.jwtEncode(data)},
            function(data, resData){
                if (resData.success != 1) {
                    alert(resData.errMsg);
                }
            },
            function(){
                alert('系統錯誤');
            }
        );
    }

    var gTmpTitle = '';
    function editTitle(obj, i){
        var div = $(obj).parents('td').find("div:first");
        if(div.hasClass("show")){
            gTmpTitle = div.text();
            var input = $.parseHTML('<input class="form-control" type="text" value="' + gTmpTitle + '">');

            div.removeClass("show").addClass("edit").html(input);
            $(obj).removeClass("btn-info").addClass("btn-danger").text('完成');

            $(input).select().keydown(function(e){ if(e.which == 13){ editTitle(obj, i); } });
        } 
        else if(div.hasClass("edit")){
            var newTitle = div.find('input').val();
            if (!newTitle){
                alert('請輸入標題');
                return;
            }

            div.removeClass("edit").addClass("show").html(newTitle);
            $(obj).removeClass("btn-danger").addClass("btn-info").text('編輯');

            doEdit(newTitle, i);
        }
    }

    function copyTitle(obj, i){
        var newTitle = $(obj).parents('tr').find('.a-title').text();
        if (!newTitle) return;

        var div = $(obj).parents('td').find("div:first");
        if (newTitle == div.text()) return;

        if(div.hasClass("show")){
            if( !confirm('確定複製?') ) return;

            div.text(newTitle);
            doEdit(newTitle, i);
        } else if(div.hasClass("edit")){
            div.find('input').val(newTitle);
        }
    }

    function selectArticle(obj, id){
        var newArticleTitle = $(obj).parents('td').find('select:eq(0) option:selected').text();
        if($(obj).parents('tr').find('.a-title').text() == newArticleTitle) return;
        
        if( !confirm('確定選擇文章?') ) return;

        var wData = {'id': id, 'ajaxType': 'selectArticle'};
        wData['articleType'] = '{{$selectKey}}';
        wData['articleId'] = $(obj).parents('td').find('select:eq(0)').val();
        wData['pageKey'] = '{{$pageKey}}';

        gMyJs.doAjax(gBasePath + 'ajaxIndex', {'data': gMyJs.jwtEncode(wData)},
            function(data, resData){
                if (resData.success) {
                    $(obj).parents('tr').find('.a-title').text( $(obj).parents('td').find('select:eq(0) option[value=' + wData['articleId'] + ']').text() );
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
        $("input[type=radio]").change(changeState);

        gDataTable = $('#dataTable').DataTable({
            "order": [],
            "searching": false,
            "ordering": false,
            "columnDefs": [
                { 
                    "targets": 0, "width": "2.5rem",
                },
                { 
                    "targets": 1,
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        $(nTd).addClass('a-title');
                    }
                },
                { 
                    "targets": 3,
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        $(nTd).css('min-width', '26rem');
                    }
                },
            ],
        });
    });
</script>

@endsection