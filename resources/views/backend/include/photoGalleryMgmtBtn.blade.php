<div class="photo-gallery-mode">
    <div class="text">點選圖片時要</div>
    <button type="button" onclick="changeMode('zoomIn', 1)" data-mode="zoomIn" class="btn btn-light">放大</button>
    <button type="button" onclick="changeMode('select', 1)" data-mode="select" class="btn btn-light">選擇</button>
</div>
<div class="photo-gallery-mode photo-gallery-mode-second">
    <div class="text">功能列表</div>
    <button type="button" onclick="openSort()" class="btn btn-info sort-btn" style="width: 133px;"></button>
    <button type="button" onclick="chStatus(0)" class="btn btn-secondary dn">不啟用</button>
    <button type="button" onclick="chStatus(1)" class="btn btn-secondary dn">啟用</button>
    <button type="button" onclick="delList()" class="btn btn-danger dn">刪除</button>
</div>

<style>
    .dn{
        /* display: none; */
    }
    .photo-gallery-mode button{
        margin: 0.2em;
    }
    .photo-gallery-mode{
        width: max-content;
        border: 1px solid #8E8E8E;
        border-radius: 10px;
        padding: 10px;
        position: relative;
        display: inline-block;
        margin-top: 0.5em;
    }
    .photo-gallery-mode .text{
        background: white;
        padding: 0 5px;
        position: absolute;
        top: -12px;
        left: 22px;
    }
    .photo-gallery-mode-second{
        margin-left: 1em;
    }
</style>