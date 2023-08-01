@extends('backend.layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*帳號<span class="my-sub_title"></span></h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <input id="account" name="account" type="text" class="form-control bg-light" placeholder="" value=''>
                    <div class="my-error_msg"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*姓名</h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <input id="name" name="name" type="text" class="form-control bg-light" placeholder="" value=''>
                    <div class="my-error_msg"></div>
                </div>
            </div>
        </div>
    </div>
    
    <?php if($type == 'edit'){ ?>
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">原始密碼<span class="my-sub_title"></span></h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <input id="curPwd" name="curPwd" type="password" class="form-control bg-light" placeholder="" value='' autocomplete="something">
                    <div class="my-error_msg"></div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

</div>
<div class="row">
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <?php $pwdTitle = ($type == 'edit') ? '更新密碼' : '*密碼';  ?>
                <h6 class="m-0 font-weight-bold text-primary title">{{ $pwdTitle }}<span class="my-sub_title"></span></h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <input id="pwd" name="pwd" type="password" class="form-control bg-light" placeholder="" value='' autocomplete="something">
                    <div class="my-error_msg"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <?php $rePwdTitle = ($type == 'edit') ? '確認密碼' : '*確認密碼';  ?>
                <h6 class="m-0 font-weight-bold text-primary title">{{ $rePwdTitle }}<span class="my-sub_title"></span></h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <input id="rePwd" name="rePwd" type="password" class="form-control bg-light" placeholder="" value='' autocomplete="something">
                    <div class="my-error_msg"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
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
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*前台網站設定</h6>
            </div>
            <div id="groupFrontSetMenu" class="card-body auth-block">
                <div class="item-group">
                    <div>
                        <button type="button" onclick="allSet(this, 1)" style="margin: 0 0.5em 1em 0;" class="btn btn-success">全部啟用</button>
                        <button type="button" onclick="allSet(this, 0)" style="margin: 0 0.5em 1em 0;" class="btn btn-danger">全部不啟用</button>
                        {!! $backendMenu !!}
                    </div>
                    <div class="my-error_msg"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*後台功能選單</h6>
            </div>
            <div id="mainMenu" class="card-body auth-block">
                <div class="item-group">
                    <div>
                        <button type="button" onclick="allSet(this, 1)" style="margin: 0 0.5em 1em 0;" class="btn btn-success">全部啟用</button>
                        <button type="button" onclick="allSet(this, 0)" style="margin: 0 0.5em 1em 0;" class="btn btn-danger">全部不啟用</button>
                        {!! $backendMainMenu !!}
                    </div>
                    <div class="my-error_msg"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<button class="btn btn-info" onclick="history.back()" style="margin-right: 0.5em;">返回</button>
<button name="save" type="submit" class="btn btn-info" style="width: 58px; height: 32.38px;">
    <img src="{{ $publicPath }}base/image/loading.gif" width="24px" style="display: none;">
    <span>儲存</span>
</button>

<style>
    label{
        cursor: pointer;
        margin-right: 0.5rem;
    }

    .auth_name{
        display: inline-block;
        margin: 0.2em 0.5em 0.2em 0;
        font-weight: bold;
    }

    .l2, .l3{
        margin: 0 2.5em;
    }
</style>

<script>
    function allSet(obj, value){
        $(obj).parent().find('input[value=' + value + ']').prop('checked', true);
    }

    function getMenuAuth(){
        var menuAuth = {};
        $('#groupFrontSetMenu input[type=radio]:checked').each(function(){
            menuAuth[this.name] = this.value;
        });

        $('#mainMenu input[type=radio]:checked').each(function(){
            menuAuth[this.name] = this.value;
        });
        return JSON.stringify(menuAuth);
    }

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
                default:
                    newVal = obj.val().trim();
            }

            var res = gMyJs.checkEmpty(newVal, group, null, title);
            if('error' in res){ err = true; }
            if('value' in res){
                if(id == 'pwd'){
                    if(res.value != $('#rePwd').val()){
                        gMyJs.showErrorMsg( $('#rePwd').parents('.' + groupClassName) , '密碼不一致');
                        err = true;
                    } else {
                        data[id] = res.value;
                        data['rePwd'] = $('#rePwd').val();
                    }
                } else {
                    data[id] = res.value;
                }
            }
        };

        if(err){ alert('請檢查欄位'); return; }

        if( '{{ $type }}' == 'edit' && $('#pwd').val() ){
            data['curPwd'] = $('#curPwd').val();
            data['pwd'] = $('#pwd').val();
            data['rePwd'] = $('#rePwd').val();
        }

        data['auth'] = getMenuAuth();

        var formData = new FormData();
        formData.append('data', gMyJs.jwtEncode({'data': data, 'type': '{{ $type }}', 'id': {{ $dbId }}, 'ajaxType': 'editDetail'}));

        for(var key in gMyJs.files){
            for(var name in gMyJs.files[key]){
                formData.append('files[' + key + '][' + name + ']', gMyJs.files[key][name]);
            }
        }

        setLoadingBtn(btnObj, 'open');

        gMyJs.doAjax('{{ $basePath }}ajaxAdminMgmt', formData, 
            function(data, resData){
                setLoadingBtn(btnObj, 'close');

                if (resData.success) {
                    alert('儲存成功');
                    redirect('adminList');
                } else {
                    if (resData.errMsg) {
                        if (resData.id) {
                            var group = $('#' + resData.id).parents('.' + groupClassName);
                            gMyJs.showErrorMsg(group, resData.errMsg);
                            alert('請檢查欄位');
                        }
                    } else {
                        alert('儲存失敗');
                    }
                }
            },
            function(){
                setLoadingBtn(btnObj, 'close');
                
                alert('系統錯誤');
            }, 
            true
        );
    }

    function levelChange(obj, disabledDiv){
        if( !$(obj).prop('checked') ) return;

        $(obj).parents('.' + disabledDiv).find('input[value=0]').prop('checked', true);
    }

    function buildDetail(detailList){
        var groupClassName = 'item-group';

        var submitList = gMyJs.setValus(gPublicPath, detailList, groupClassName);

        $('.l1 >> input[value=0]').change(function(){ levelChange(this, 'l1'); });
        $('.l2 >> input[value=0]').change(function(){ levelChange(this, 'l2'); });

        $('button[name=save][type=submit]').click(function(){ save(this, submitList, groupClassName); });
    }
    
    var gCanSave = true;

    $(function(){
        var detailList = @json($detailList);
        buildDetail(detailList);
    });
</script>

@endsection