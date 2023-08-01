@extends('backend.layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*文章分類</h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <select id="category_id" name="category_id" class="form-control bg-light">
                    </select>
                    <div class="my-error_msg"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*文章標題</h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <input id="title" name="title" type="text" class="form-control bg-light" placeholder="">
                    <div class="my-error_msg"></div>
                </div>    
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">*文章內容</h6>
    </div>
    <div class="card-body">
        <div class="item-group">
            <textarea style="height: 20rem;" id="share_content" name="share_content" type="text" class="form-control bg-light" placeholder=""></textarea>
            {{-- <textarea id="share_content" class="editor"></textarea> --}}
            <div class="my-error_msg"></div>
        </div>    
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*狀態</h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <select id="state" name="state" class="form-control bg-light">
                        <option value=0>不啟用</option>
                        <option value=1>啟用</option>
                    </select>
                    <div class="my-error_msg"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*排序<span class="my-sub_title">( 由小到大，由新到舊請填9999，請填數字或小數 )</span></h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <input id="sort" name="sort" type="number" class="form-control bg-light" placeholder="" value=''>
                    <div class="my-error_msg"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<button class="btn btn-info" onclick="history.back()" style="margin-right: 0.5em;">返回</button>
<button name="save" type="submit" class="btn btn-info" style="width: 58px; height: 32.38px;">
    <img src="{{ $publicPath }}base/image/loading.gif" width="25px" style="display: none;">
    <span>儲存</span>
</button>

<script>
    function setLoadingBtn(btnObj, action){
        if(action == 'open'){
            gCanSave = false;
            $(btnObj).find('span').hide();
            $(btnObj).find('img').show();
        }

        if(action == 'close'){
            gCanSave = true;
            $(btnObj).find('span').show();
            $(btnObj).find('img').hide();
        }
    }

    function save(btnObj, submitList, groupClassName){
        if(!gCanSave) return;

        gMyJs.chearErrorMsg();

        var err = false, data = {};
        for(var id in submitList){
            var mData = submitList[id], obj = $('#' + id), newVal = '';
            var group = obj.parents('.' + groupClassName);
            var title = group.parents('.card').find('.card-header .title').text();

            switch(mData['type']){
                case 'singlefile':
                    newVal = group.find('.my-file_name').text();
                    break;
                case 'editor':
                    newVal = CKEDITOR.instances[id].getData();
                    break;
                case 'textarea':
                    newVal = obj.val().trim().replace(/\n/g, '<br>');
                    break;
                default:
                    newVal = obj.val().trim();
            }

            var res = gMyJs.checkEmpty(newVal, group, null, title, mData['type'], obj);
            if('error' in res){ err = true; }
            if('value' in res){
                data[id] = res.value;
            }
        };

        if(err){ alert('請檢查欄位'); return; }

        var formData = new FormData();
        formData.append('data', gMyJs.jwtEncode({'data': data, 'type': '{{ $type }}', 'id': {{ $dbId }}, 'ajaxType': 'ajaxArticleShare'}));

        for(var key in gMyJs.files){
            for(var name in gMyJs.files[key]){
                formData.append('files[' + key + '][' + name + ']', gMyJs.files[key][name]);
            }
        }

        setLoadingBtn(btnObj, 'open');

        gMyJs.doAjax('{{ $basePath }}ajaxArticleShareMgmt', formData, 
            function(data, resData){
                setLoadingBtn(btnObj, 'close');

                if (resData.success) {
                    alert('儲存成功');
                    redirect('articleShareMgmt');
                } else {
                    alert('儲存失敗');
                }
            },
            function(){
                setLoadingBtn(btnObj, 'close');
                
                alert('系統錯誤');
            }, 
            true
        );
    }

    function buildDetail(detailList){
        var groupClassName = 'item-group';

        var submitList = gMyJs.setValus(gPublicPath, detailList, groupClassName);

        // img preview event
        $('.my-preview').parents('.' + groupClassName).find('input').on('change', function(){ gMyJs.preview(this, groupClassName); });

        // editor init
        $('.editor').each(function(){ CKFinder.setupCKEditor(); CKEDITOR.replace( $(this).attr('id') ); });

        $('button[name=save][type=submit]').click(function(){ save(this, submitList, groupClassName); });
    }

    var gCanSave = true;
    
    $(function(){
        var detailList = @json($detailList);
        buildDetail(detailList);
    });
</script>

@endsection