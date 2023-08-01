@extends('backend.layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*時間</h6>
            </div>
            <div class="card-body">
                <div class="item-group" name="4">
                    <input name="time" type="text" class="form-control bg-light" placeholder="" value='{{ $data[4]->value[0]['time'] }}'>
                    <div class="my-error_msg"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*地址</h6>
            </div>
            <div class="card-body">
                <div class="item-group" name="5">
                    <input name="address" type="text" class="form-control bg-light" placeholder="" value='{{ $data[5]->value[0]['address'] }}'>
                    <div class="my-error_msg"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">*交通資訊</h6>
    </div>
    <div class="card-body">
        <div class="item-group" name="6" style="display: block;">
            <textarea style="height: 10rem;" id="traffic_info" name="traffic_info" type="text" class="form-control bg-light" placeholder=""></textarea>
            <!-- <textarea id="traffic_info" name="traffic_info" class="editor"></textarea> -->
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

    function save(btnObj){
        if(!gCanSave) return;

        var err = false, data = {};

        $('.item-group').each(function(){
            var inputGroup = $(this).parent(), title = $(this).parents('.card').find('.card-header .title').text();
            var infoType = $(this).attr('name'), newVal = '';

            if ( !(infoType in data) ) data[infoType] = [];
            var tmp = {};

            $(this).find('input,textarea').each(function(){
                var key = this.name, type = this.className, id = this.id;
                if(!key) return;

                switch(type){
                    case 'editor':
                        newVal = CKEDITOR.instances[id].getData();
                        break;
                    default:
                        newVal = this.value.trim();
                }

                var res = gMyJs.checkEmpty(newVal, inputGroup, null, title);
                if('error' in res){ err = true; }
                if('value' in res){
                    tmp[key] = res.value;
                }
            });

            data[infoType].push(tmp);
        });

        if(err){ alert('請檢查欄位'); return; }

        setLoadingBtn(btnObj, 'open');

        gMyJs.doAjax('{{$basePath}}ajaxFooterInfo', {'data': gMyJs.jwtEncode(data)}, 
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
            }
        );
    }

    function buildDetail(){
        $('#traffic_info').val( @json($data[6])['value'][0]['traffic_info'] );
        // editor init
        $('.editor').each(function(){ CKFinder.setupCKEditor(); CKEDITOR.replace( $(this).attr('id') ); });
        $('button[name=save][type=submit]').click(function(){ save(this); });
    }

    var gCanSave = true;

    $(function(){
        buildDetail();
    })
</script>

@endsection