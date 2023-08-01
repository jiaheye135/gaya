@extends('backend.layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">地址</h6>
            </div>
            <div class="card-body">
                <div class="input-group" name="1">
                    <input name="address" type="text" class="form-control bg-light" placeholder="" value='{{ $data[1]->value[0]['address'] }}'>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">聯絡人</h6>
            </div>
            <div class="card-body">
                <?php foreach ($data[2]->value as $i => $v){
                        $style = ($i == 0) ? '' : 'margin-top: 1em;'; ?>

                    <div class="input-group" name="2" style="{{ $style }}">
                        <input name="name" type="text" class="form-control bg-light" placeholder="輸入姓名" value='{{ $v['name'] }}'>
                        <input name="phone" type="text" class="form-control bg-light" style="margin-left: 1em;"
                            placeholder="輸入手機" value='{{ $v['phone'] }}'>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">信箱</h6>
            </div>
            <div class="card-body">
                <div>
                    <div class="input-group" name="3">
                        <input name="email" type="text" class="form-control bg-light" placeholder="" value='{{ $data[3]->value[0]['email'] }}'>
                    </div>
                    <div class="my-error_msg"></div>
                </div>
            </div>
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

        $('.input-group').each(function(){
            var inputGroup = $(this).parent(), title = $(this).parents('.card').find('.card-header .title').text();
            var infoType = $(this).attr('name');
            
            if ( !(infoType in data) ) data[infoType] = [];
            var tmp = {};

            $(this).find('input').each(function(){
                var key = this.name;
                if(!key) return;

                var res = gMyJs.checkEmpty(this.value.trim(), inputGroup, null, title);
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

    var gCanSave = true;

    $(function(){
        $('button[name=save][type=submit]').click(function(){ save(this); });
    })
</script>

@endsection