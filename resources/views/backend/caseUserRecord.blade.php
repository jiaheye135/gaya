@extends('backend.layouts.main')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">新增個案紀錄</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-3 mb-3">
                <h6 class="text-primary title">服務項目:</h6>
                <input id="title" name="title" type="text" class="form-control bg-light" placeholder="">
                <div class="my-error_msg"></div>
            </div>
            <div class="col-lg-3 mb-3">
                <h6 class="text-primary title">服務時間:</h6>
                <input id="title" name="title" type="text" class="form-control bg-light" placeholder="2023-01-01">
                <div class="my-error_msg"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-3">
                <h6 class="text-primary title">服務內容:</h6>
                <div class="item-group" style="display: block;">
                    <textarea id="2" name="2" class="editor"></textarea>
                    <div class="my-error_msg"></div>
                </div>  
            </div>  
        </div>
        <button name="save" type="submit" class="btn btn-info" style="width: 58px; height: 32.38px;">
            <img src="{{ $publicPath }}base/image/loading.gif" width="25px" style="display: none;">
            <span>儲存</span>
        </button>
    </div>
</div>

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

    function save(btnObj, groupClassName){
        if(!gCanSave) return;

        gMyJs.chearErrorMsg();
        
        var err = false, data = {};
        $('input,textarea').each(function(){
            var type = this.className, newVal = '';
            var group = $(this).parents('.' + groupClassName);
            var title = group.parents('.card').find('.card-header .title').text();

            var infoType = this.name;
            switch(type){
                case 'singlefile':
                    newVal = group.find('.my-file_name').text();
                    break;
                case 'editor':
                    newVal = CKEDITOR.instances[ this.id ].getData();
                    break;
                default:
                    newVal = this.value.trim();
            }

            var res = gMyJs.checkEmpty(newVal, group, null, title);
            if('error' in res){ err = true; }
            if('value' in res){
                data[infoType] = res.value;
            }
        });

        if(err){ alert('請檢查欄位'); return; }

        var formData = new FormData();
        formData.append('data', gMyJs.jwtEncode({'data': data}));

        for(var key in gMyJs.files){
            for(var name in gMyJs.files[key]){
                formData.append('files[' + key + '][' + name + ']', gMyJs.files[key][name]);
            }
        }

        setLoadingBtn(btnObj, 'open');

        gMyJs.doAjax('{{$basePath}}ajaxIndexMgmt', formData, 
            function(data, resData){
                setLoadingBtn(btnObj, 'close');

                if (resData.success) {
                    alert('儲存成功');
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

        gMyJs.setValus(gPublicPath, detailList, groupClassName);

        // editor init
        $('.editor').each(function(){ CKFinder.setupCKEditor(); CKEDITOR.replace( $(this).attr('id') ); });
        // img preview event
        $('.my-preview').parents('.' + groupClassName).find('input').on('change', function(){ gMyJs.preview(this, groupClassName); });

        $('button[name=save][type=submit]').click(function(){ save(this, groupClassName); });
    }

    var gCanSave = true;

    $(function(){
        var detailList = @json($detailList);
        buildDetail(detailList);
    })
</script>

@endsection