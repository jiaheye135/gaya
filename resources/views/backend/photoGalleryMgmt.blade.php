@extends('backend.layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary title">相片分類</h6>
            </div>
            <div class="card-body">
                <div class="item-group">
                    <select id="category_id" name="category_id" class="form-control bg-light">
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

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">新增相片</h6>
    </div>
    <div class="card-body">
        <div style="">
            <button type="button" onclick="add()" class="btn btn-info">新增</button>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">相片管理</h6>
    </div>
    <div class="card-body">
        @include('backend.include.photoGalleryMgmtBtn')
        <div class="photo-gallery">
            <div id="photoData" class="row photos sortable">
                @foreach ($photoData as $v)
                <?php $showIndex = ''; $radioSelect = '';
                    if($v->show_index_web == 1){ $showIndex = 'showIndex'; $radioSelect = 'checked'; }
                ?>
                <?php $state = '';
                    if($v->state == 0){ $state = 'disabled'; }
                ?>

                <div id="item-{{ $v->id }}" class="col-sm-6 col-md-4 col-lg-3 item {{ $state }} {{ $showIndex }}" data-id="{{ $v->id }}" data-state="{{ $state }}">
                    <a data-mode="zoomIn" class="limited-photo" href="{{ $publicPath . $v->img }}" data-lightbox="photos"><img class="img-fluid" src="{{ $publicPath . $v->img }}"></a>
                    <a data-mode="select" class="limited-photo" onclick="photoSelected(this)"><img class="img-fluid" src="{{ $publicPath . $v->img }}"></a>
                    <label style="margin-top: 0.5em; color: #EA7500; cursor: pointer;"><input type="radio" name="photos" class="radio" {{ $radioSelect }} value="{{ $v->id }}"><span style="margin: 0.5em;">顯示在首頁</span></label>
                </div>
                @endforeach
            </div>
        </div>
        @include('backend.include.photoGalleryMgmtBtn')
    </div>
</div>

<style>
    .photo-gallery {
        color:#313437;
        background-color:#fff;
        margin-top: 1em;
    }
    .photo-gallery p {
        color:#7d8285;
    }
    .photo-gallery h2 {
        font-weight:bold;
        margin-bottom:40px;
        padding-top:40px;
        color:inherit;
    }
    .photo-gallery .intro {
        font-size:16px;
        max-width:500px;
        margin:0 auto 40px;
    }
    .photo-gallery .intro p {
        margin-bottom:0;
    }
    .photo-gallery .photos {
        padding-bottom:20px;
    }
    .photo-gallery .showIndex {
        border: 1px solid #EA7500;
    }
    input:focus{
        outline: none;
    }
    .photo-gallery .item {
        padding: 10px 10px 0 10px;
    }
    .photo-gallery .limited-photo {
        height: 145px;
        overflow: hidden;
        display: block;
        cursor: pointer;
    }
    .photo-gallery .img-fluid {
        max-width: 100%;
        width: 100%;
        overflow: hidden;
    }
    .photo-gallery .selected{
        background: #BBFFFF; 
    }
    .photo-gallery .disabled{
        background: #E0E0E0	; 
    }
    .sort-mode{
        border: 1px solid #E0E0E0;
        border-style: dashed;
    }
</style>

<!--Light Box-->
<link rel="stylesheet" href="{{ $publicPath }}front/assets/css/lightbox.min.css">
<script src="{{ $publicPath }}front/assets/js/lightbox.min.js"></script>

<script>
    function add(){
        var param = 'data=' + gMyJs.jwtEncode({'categoryId': $('#category_id').val()})
        redirect('photoGalleryUpload?' + param);
    }

    function chStatus(state){
        var sdIds = checkHasSelected();
        if(sdIds.length == 0){ alert('請選擇圖片'); return; }

        if( !confirm('確定更改狀態?') ) return;

        gMyJs.doAjax(gBasePath + 'ajaxPhotoGalleryMgmt', {'data': gMyJs.jwtEncode({'sdIds': sdIds, 'state': state, 'ajaxType': 'chStatus'})},
            function(data, resData){
                if (resData.success) {
                    var sd = $('.photo-gallery .selected');
                    if(state == 0){
                        sd.attr('data-state', 'disabled');
                        sd.addClass('disabled');
                    } else if (state == 1) {
                        sd.attr('data-state', '');
                        sd.removeClass('disabled');
                    }

                    sd.removeClass('selected');
                    checkHasSelected();
                } else {
                    alert(resData.errMsg);
                }
            },
            function(){
                alert('系統錯誤');
            }
        );
    }

    function delList(){
        var sdIds = checkHasSelected();
        if(sdIds.length == 0){ alert('請選擇圖片'); return; }

        if( !confirm('確定刪除?') ) return;

        gMyJs.doAjax(gBasePath + 'ajaxPhotoGalleryMgmt', {'data': gMyJs.jwtEncode({'sdIds': sdIds, 'ajaxType': 'delPhoto'})},
            function(data, resData){
                if (resData.success) {
                    $('.photo-gallery .selected').remove();
                    checkHasSelected();
                } else {
                    alert(resData.errMsg);
                }
            },
            function(){
                alert('系統錯誤');
            }
        );
    }

    function checkHasSelected(){
        var sd = $('.photo-gallery .selected'), sdIds = [];
        for(var i=0; i<sd.length; i++){
            sdIds.push($(sd[i]).data('id'));
        }
        
        // var d = $('.dn');
        // if(sdIds.length > 0){
        //     d.show();
        // } else {
        //     d.hide();
        // }

        return sdIds;
    }

    function photoSelected(obj){
        var p = $(obj).parent(), state = p.data('state');
        if(p.hasClass('selected')){
            if(state == 'disabled') p.addClass('disabled');
            p.removeClass('selected');
        } else {
            p.removeClass('disabled');
            p.addClass('selected');
        }

        checkHasSelected();
    }

    function changeMode(mode, flag){
        if(flag == 1 && gMode == mode) return;

        var noomInBtn = $('.photo-gallery-mode button[data-mode=zoomIn]');
        var selectBtn = $('.photo-gallery-mode button[data-mode=select]');
        var noomInPho = $('.photo-gallery a[data-mode=zoomIn]');
        var selectPho = $('.photo-gallery a[data-mode=select]');
        if(mode == 'zoomIn'){
            noomInBtn.removeClass('btn-light').addClass('btn-success');
            selectBtn.removeClass('btn-success').addClass('btn-light');
            noomInPho.show();
            selectPho.hide();
        }

        if(mode == 'select'){
            selectBtn.removeClass('btn-light').addClass('btn-success');
            noomInBtn.removeClass('btn-success').addClass('btn-light');
            selectPho.show();
            noomInPho.hide();
        }

        gMode = mode;
    }

    function categoryChange(){
        changeGallery(this.value, function(categoryId){ localStorage.setItem(gLSKey, categoryId); });
    }

    function changeGallery(categoryId, callback){
        gMyJs.doAjax(gBasePath + 'ajaxPhotoGalleryMgmt', {'data': gMyJs.jwtEncode({'categoryId': categoryId, 'ajaxType': 'getPhoto'})},
            function(data, resData){
                buildPhoto(resData, categoryId);
                init();
                if (typeof callback === "function") callback(categoryId);
            },
            function(){
                alert('系統錯誤');
            }
        );
    }

    function buildPhoto(data, categoryId){
        var h = '';
        for(var i=0; i<data.length; i++){
            var d = data[i];
            var showIndex = '', radioSelect = '', state = '';
            if(d.show_index_web == 1){ showIndex = 'showIndex'; radioSelect = 'checked'; }
            if(d.state == 0){ state = 'disabled'; }

            h += '<div id="item-' + d.id + '" class="col-sm-6 col-md-4 col-lg-3 item ' + state + ' ' + showIndex + '" data-id="' + d.id + '"  data-state="' + state + '">';
            h +=    '<a data-mode="zoomIn" class="limited-photo" href="{{ $publicPath }}' + d.img + '" data-lightbox="photos"><img class="img-fluid" src="{{ $publicPath }}' + d.img + '"></a>';
            h +=    '<a data-mode="select" class="limited-photo" onclick="photoSelected(this)"><img class="img-fluid" src="{{ $publicPath }}' + d.img + '"></a>';
            h +=    '<label style="margin-top: 0.5em; color: #EA7500; cursor: pointer;"><input type="radio" name="photos" class="radio" ' + radioSelect + ' value="' + d.id + '"><span style="margin: 0.5em;">顯示在首頁</span></label>';
            h += '</div>';
        }
        $('#photoData').html(h);
        $('#category_id').val(categoryId);
    }

    function init(){
        changeMode('zoomIn');
        $('input[type=radio]').change(radioChange);
        sortableInit();
    }

    function sortableInit(){
        gSortable = $(".sortable").sortable({
            // disabled: true,
            // cursor: "move",
            revert: true, 
            opacity: 0.6, //拖動時，透明度為0.6
            update: function(event, ui) {
            }
        });
        
        openSort('close');
    }

    function openSort(action){
        var sb = $('.sort-btn'), pgi = $('.photo-gallery .item');

        if(action == 'open' || (sb.hasClass('sb-close') && !action)){ // open
            sb.removeClass('btn-info').addClass('btn-danger').removeClass('sb-close').addClass('sb-open').text('完成排序');
            pgi.addClass('sort-mode');
            gSortable.sortable("enable");
        }
        else if(action == 'close' || (sb.hasClass('sb-open') && !action)){ // close
            sb.removeClass('btn-danger').addClass('btn-info').removeClass('sb-open').addClass('sb-close').text('開啟排序(拖曳)');
            pgi.removeClass('sort-mode');
            gSortable.sortable("disable");

            if(action == 'close') return; // 不是按鈕觸發

            var sortData = gSortable.sortable("toArray");
            if(sortData.length == 0) return;

            gMyJs.doAjax(gBasePath + 'ajaxPhotoGalleryMgmt', {'data': gMyJs.jwtEncode({'sortData': sortData, 'categoryId': $('#category_id').val(), 'ajaxType': 'sortable'})},
            function(data, resData){
                if (!resData.success) alert(resData.errMsg);
            },
            function(){
                alert('系統錯誤');
            }
        );
        }
    }

    function radioChange(){
        $('.photo-gallery .item').removeClass('showIndex');
        $(this).parents('.item').addClass('showIndex');

        gMyJs.doAjax(gBasePath + 'ajaxPhotoGalleryMgmt', {'data': gMyJs.jwtEncode({'id': this.value, 'categoryId': $('#category_id').val(), 'ajaxType': 'radioChange'})},
            function(data, resData){
                if (!resData.success) alert(resData.errMsg);
            },
            function(){
                alert('系統錯誤');
            }
        );
    }

    var gMode = '', gLSKey = 'categoryId', gSortable = null;
    $(function(){
        $('#category_id').change(categoryChange);

        // var categoryId = localStorage.getItem(gLSKey);
        // if(categoryId && categoryId != {{ $categoryId }}){
        //     changeGallery(categoryId);
        // } else {
            init();
        // }
    });
</script>

@endsection