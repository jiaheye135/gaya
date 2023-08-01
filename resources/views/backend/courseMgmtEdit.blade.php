@extends('backend.layouts.main')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">*課程名稱</h6>
    </div>
    <div class="card-body">
        <div class="item-group">
            <input id="name" name="name" type="text" class="form-control bg-light" placeholder="">
            <div class="my-error_msg"></div>
        </div>    
    </div>
</div>
<hr>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="custom-control custom-checkbox">
            <input class="custom-control-input" id="start_class" type="checkbox">
            <label class="custom-control-label" for="start_class" style="font-weight: bolder;">是否開課</label>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="custom-control custom-checkbox">
            <input class="custom-control-input" id="is_meeting" type="checkbox">
            <label class="custom-control-label" for="is_meeting" style="font-weight: bolder;">是否為體驗會</label>
        </div>
    </div>
</div>

<div id="meeting_div" style="display: none;">
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary title">*體驗會日期<span class="my-sub_title">(至少填一個)</span></h6>
                </div>
                <div class="card-body">
                    <div class="item-group">
                        <div id="experience_meeting_date">
                            <input type="date" class="form-control bg-light" style="margin-bottom: 1rem" placeholder="YYYY/MM/DD" value=''>
                            <input type="date" class="form-control bg-light" style="margin-bottom: 1rem" placeholder="YYYY/MM/DD" value=''>
                            <input type="date" class="form-control bg-light" style="margin-bottom: 1rem" placeholder="YYYY/MM/DD" value=''>
                            <input type="date" class="form-control bg-light" style="margin-bottom: 1rem" placeholder="YYYY/MM/DD" value=''>
                        </div>
                        <div class="my-error_msg"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary title">*體驗會費用<span class="my-sub_title"></span></h6>
                </div>
                <div class="card-body">
                    <div class="item-group">
                        <input id="experience_meeting_fee" name="experience_meeting_fee" type="number" class="form-control bg-light" placeholder="" value=''>
                        <div class="my-error_msg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*首頁 按鈕圖片 size1<span class="my-sub_title">(建議尺寸:550x600)</span></h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <label class="btn btn-info" style="margin-bottom: 0;">
                        <input id="img1" name="img1" class="" style="display: none;" type="file" accept=".jpg,.jpeg,.png" data-type="singlefile">
                        <i class="fa fa-photo"></i><span style="margin-left: 0.5em;">上傳</span>
                    </label>
                    <div class="my-file_name" style="margin: 0.5em 0;"></div>
                    <div><img class="my-preview" src=""></div>
                    <div class="my-error_msg"></div>
                </div>    
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*首頁 按鈕圖片size2<span class="my-sub_title">(建議尺寸:1100x600)</span></h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <label class="btn btn-info" style="margin-bottom: 0;">
                        <input id="img2" name="img2" class="" style="display: none;" type="file" accept=".jpg,.jpeg,.png" data-type="singlefile">
                        <i class="fa fa-photo"></i><span style="margin-left: 0.5em;">上傳</span>
                    </label>
                    <div class="my-file_name" style="margin: 0.5em 0;"></div>
                    <div><img class="my-preview" src=""></div>
                    <div class="my-error_msg"></div>
                </div>    
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">*首頁 按鈕圖片 size3<span class="my-sub_title">(建議尺寸:1750x600)</span></h6>
    </div>
    <div class="card-body">
        <div class="item-group">
            <label class="btn btn-info" style="margin-bottom: 0;">
                <input id="img3" name="img3" class="" style="display: none;" type="file" accept=".jpg,.jpeg,.png" data-type="singlefile">
                <i class="fa fa-photo"></i><span style="margin-left: 0.5em;">上傳</span>
            </label>
            <div class="my-file_name" style="margin: 0.5em 0;"></div>
            <div><img class="my-preview" src=""></div>
            <div class="my-error_msg"></div>
        </div>    
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*首頁 按鈕文字</h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <textarea style="height: 10rem;" id="index_btn_Text" name="index_btn_Text" type="text" class="form-control bg-light" placeholder=""></textarea>
                    <div class="my-error_msg"></div>
                </div>    
            </div>
        </div>
    </div>
</div>
<hr>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">*課程介紹頁 Banner 圖片<span class="my-sub_title">(建議尺寸:3841*1393)</span></h6>
    </div>
    <div class="card-body">
        <div class="item-group">
            <label class="btn btn-info" style="margin-bottom: 0;">
                <input id="detail_banner_img" name="detail_banner_img" class="" style="display: none;" type="file" accept=".jpg,.jpeg,.png" data-type="singlefile">
                <i class="fa fa-photo"></i><span style="margin-left: 0.5em;">上傳</span>
            </label>
            <div class="my-file_name" style="margin: 0.5em 0;"></div>
            <div><img class="my-preview" src=""></div>
            <div class="my-error_msg"></div>
        </div>    
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">課程介紹頁 副標題文字</h6>
    </div>
    <div class="card-body">
        <div class="item-group">
            <input id="detail_text" name="detail_text" type="text" class="form-control bg-light" placeholder="">
            <div class="my-error_msg"></div>
        </div>    
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">*課程介紹頁 內容</h6>
    </div>
    <div class="card-body">
        <div class="item-group">
            <textarea style="height: 10rem;" id="detail_content" name="detail_content" type="text" class="form-control bg-light" placeholder=""></textarea>
            <!-- <textarea id="detail_content" class="editor"></textarea> -->
            <div class="my-error_msg"></div>
        </div>    
    </div>
</div>
<hr>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*排序<span class="my-sub_title">(由小到大)</span></h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <input id="sort" name="sort" type="number" class="form-control bg-light" placeholder="" value=''>
                    <div class="my-error_msg"></div>
                </div>
            </div>
        </div>
    </div>
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
</div>
<hr>

<button class="btn btn-info" onclick="history.back()" style="margin-right: 0.5em;">返回</button>
<button name="save" type="submit" class="btn btn-info" style="width: 58px; height: 32.38px;">
    <img src="{{ $publicPath }}base/image/loading.gif" width="24px" style="display: none;">
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
                    newVal = obj.val().trim().replace(/\n/g, "<br>");
                    break;
                case 'checkbox':
                    newVal = $(obj).prop('checked') ? '1' : '0';
                    break;
                case 'json':
                    var newVal = [];
                    $(obj).find('input').each(function(){
                        if(this.value) newVal.push(this.value);
                    });
                    newVal = (newVal.length > 0) ? JSON.stringify(newVal) : '';
                    break;
                default:
                    newVal = obj.val().trim();
            }

            var res = gMyJs.checkEmpty(newVal, group, null, title);
            if('error' in res){ err = true; }
            if('value' in res){
                data[id] = res.value;
            }

            if(id == 'is_meeting' && res.value == 0){
                delete submitList['experience_meeting_date'];
                delete submitList['experience_meeting_fee'];
            }
        };

        if(err){ alert('請檢查欄位'); return; }

        var ajaxType = '<?php echo ($meetingMode) ? "editMeetingDetail" : "editDetail"; ?>';

        var formData = new FormData();
        formData.append('data', gMyJs.jwtEncode({'data': data, 'type': '{{ $type }}', 'id': {{ $dbId }}, 'ajaxType': ajaxType}));

        for(var key in gMyJs.files){
            for(var name in gMyJs.files[key]){
                formData.append('files[' + key + '][' + name + ']', gMyJs.files[key][name]);
            }
        }

        setLoadingBtn(btnObj, 'open');

        gMyJs.doAjax('{{ $basePath }}ajaxCourseMgmt', formData, 
            function(data, resData){
                setLoadingBtn(btnObj, 'close');

                if (resData.success) {
                    alert('儲存成功');
                    redirect('courseMgmt');
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

    function checkboxChange(obj){
        if($(obj).prop('checked')){
            $('#meeting_div').show();
        } else {
            $('#meeting_div').hide();
        }
    }

    function buildDetail(detailList){
        var groupClassName = 'item-group';

        var submitList = gMyJs.setValus(gPublicPath, detailList, groupClassName);
        
        if(submitList['experience_meeting_date']){
            var emd = submitList['experience_meeting_date']['value'];
            for(var i=0; i<emd.length; i++){
                $('#experience_meeting_date input:eq(' + i + ')').val(emd[i]);
            }
        }
        
        // checkbox event
        $('#is_meeting').change(function(){ checkboxChange(this); });
        checkboxChange($('#is_meeting'));

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