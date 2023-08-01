@extends('backend.layouts.main')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">*生命探索介紹圖片<span class="my-sub_title">(建議尺寸:300*300)</span></h6>
    </div>
    <div class="card-body">
        <div class="item-group">
            <label class="btn btn-info" style="margin-bottom: 0;">
                <input id="1" name="1" class="singlefile" style="display: none;" type="file" accept=".jpg,.jpeg,.png" data-type="singlefile">
                <i class="fa fa-photo"></i><span style="margin-left: 0.5em;">上傳</span>
            </label>
            <div class="my-file_name" style="margin: 0.5em 0;"></div>
            <div><img class="my-preview" src="" style="width: 30%;"></div>
            <div class="my-error_msg"></div>
        </div>    
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">*生命探索介紹內容</h6>
    </div>
    <div class="card-body">
        <div class="item-group" style="display: block;">
            <textarea id="2" name="2" class="editor"></textarea>
            <div class="my-error_msg"></div>
        </div>    
    </div>
</div>
<hr>
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