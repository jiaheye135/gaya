@extends('backend.layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*圖片分類</h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <select id="category_id" name="category_id" class="form-control bg-light">
                        <option value=0>請選擇</option>
                        @foreach ($categorySelect as $v)
                            <option value={{$v->id}} {{ ($v->id == $categoryId) ? 'selected' : '' }}>{{$v->name}}</option>
                        @endforeach
                    </select>
                    <div class="my-error_msg"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">*圖片上傳(可多張)</h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <div id="img" class="drop_image" ondragover="dragoverHandler(this, event);" ondrop="dropHandler(this, event);" ondragleave="dragLeave(this, event);">
                        <img src="{{ $webPath }}assets/images/upload-to-cloud.png" style="width: 100px;">
                        <div style="margin: 1rem;">Drag the picture here</div>
                        <label>
                            <input name="img" type="file" style="display:none;" accept=".jpg,.jpeg,.png" multiple>
                            <button type="button" onclick="uploadBtn(this)" class="btn btn-info" style="display: block;">Upload imgs</button>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<button type="button" onclick="goMgmt()" class="btn btn-info" style="display: block;">前往管理圖片</button>

<div id="black_background" class="black_background" style="display: none">
    <div class="wait_block">
        <img alt="" src="{{ $webPath }}assets/images/loading.gif" width="50" class="wait_img">
        <div class="wait_text">上傳中....</div>
    </div>
</div>

<style>
    .wait_block{
        width: 185px;
    }
    .drop_image{
        width: 100%;
        border: dashed 2px gray;
        text-align: center;
        display: inline-block;
        padding: 2em 0 1em;
    }
</style>

<script>
    function goMgmt(){
        var param = 'data=' + gMyJs.jwtEncode({'categoryId': $('#category_id').val()})
        redirect('photoGalleryMgmt?' + param);
    }

    function delCheckFile(checkFile){
        var data = {'checkFile': checkFile, 'ajaxType': 'delCheckFile'};
        gMyJs.doAjax('{{ $basePath }}ajaxPhotoGalleryMgmt', {'data': gMyJs.jwtEncode(data)}, 
            function(data, resData){},
            function(){
                alert('系統錯誤');
            },
        );
    }

    function showProgress(obj, checkFile){
        if(gGetUploadLog){
            var data = {'checkFile': checkFile, 'ajaxType': 'getUploadProgress'}, time = 500;

            var dot = '....'; 
            // for(var i=1; i<=gDotUploadIndex % 5; i++){ dot += '.'; } gDotUploadIndex++;

            gMyJs.doAjax('{{ $basePath }}ajaxPhotoGalleryMgmt', {'data': gMyJs.jwtEncode(data)}, 
                function(data, resData){

                    var progress = dot;
                    if('updatedCount' in resData && 'allFileCount' in resData){
                        var uC = resData.updatedCount, afC = resData.allFileCount;
                        progress = '('+ uC + '/' + afC + ')' + dot;
                        if(uC == afC){
                            setTimeout(function(){ alert('上傳完成'); uploadState(obj, 'close'); progress = dot; }, 200);
                            delCheckFile(checkFile);
                        }
                    }

                    $('#black_background .wait_text').text('上傳中' + progress);
                    if(gGetUploadLog) setTimeout(function(){ showProgress(obj, checkFile); }, time);
                },
                function(){
                    $('#black_background .wait_text').text('上傳中' + dot);
                    setTimeout(function(){ showProgress(obj, checkFile); }, time);
                }, 
            );
        }
    }

    function uploadBtn(obj){
        var categoryId = $('#category_id').val();
        if(categoryId == 0){ alert('請先選擇圖片分類'); return; }

        $(obj).parents('label').find('input[type=file]').click();
    }

    function upload(){
        doUpload($('#img'), this.files);
    }

    function dragoverHandler(obj, evt) {
        $(obj).css('border-color', 'red');
        evt.preventDefault();
    }
    
    function dragLeave(obj, event) {
        $(obj).css('border-color', 'gray');
    }

    var gGetUploadLog = false, gDotUploadIndex = 0;
    function doUpload(obj, files){
        uploadState(obj, 'open');
        
        var categoryId = $('#category_id').val(), key = 'img';

        var onceUploadLimit = 10000000, newFile = [[]], index = 0, partSize = 0, allSize = 0;
        for(var i=0; i<files.length; i++){
            partSize += files[i].size;
            allSize += files[i].size;
            if(partSize >= onceUploadLimit) {
                index++;
                newFile[index] = [];
                partSize = 0;
            }
            newFile[index].push(files[i]);
        }

        var checkFile = Date.now();
        showProgress(obj, checkFile);

        var postData = {'categoryId': categoryId, 'ajaxType': 'uploadPhoto', 'checkFile': checkFile, 'allFileCount': files.length};
        doUploadBatch(obj, newFile, checkFile, postData, key, 1);
    }

    function doUploadBatch(obj, newFile, checkFile, postData, key, index){
        var formData = new FormData();
        formData.append('data', gMyJs.jwtEncode(postData));

        var files = newFile[index - 1];
        for(var i=0; i<files.length; i++){
            formData.append('files[' + key + '][' + files[i].name + ']', files[i]);
        }

        gMyJs.doAjax('{{ $basePath }}ajaxPhotoGalleryMgmt', formData, 
            function(data, resData){
                if (resData.success) {
                    // console.log(files.length, resData.fileLen);
                    if(files.length != resData.fileLen){
                        alert('上傳相片到主機時掉檔，請重新再試，或減少上傳數量。(' + files.length + resData.fileLen + ')');
                        uploadState(obj, 'close');
                    }
                    else if(index < newFile.length) doUploadBatch(obj, newFile, checkFile, postData, key, index + 1);
                } else {
                    alert(resData.errMsg);
                }
            },
            function(){
                alert('系統錯誤');
            }, 
            true
        );
    }

    function dropHandler(obj, evt) {
        evt.preventDefault();

        var categoryId = $('#category_id').val();
        if(categoryId == 0){ alert('請先選擇圖片分類'); $(obj).css('border-color', 'gray'); return; }

        doUpload(obj, evt.dataTransfer.files);
    }

    function uploadState(obj, state){
        if(state == 'open'){
            $('#black_background').show();

            gGetUploadLog = true;
        }
        if(state == 'close'){
            $('#black_background').hide();
            $(obj).css('border-color', 'gray');
            $('input[type=file]').val('');

            gGetUploadLog = false;
            gDotUploadIndex = 0;

            $('#black_background .wait_text').text('上傳中....');
        }
    }

    $(function(){
        $('input[type=file]').change(upload);
    });
</script>

@endsection