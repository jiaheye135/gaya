@extends('backend.layouts.main')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">Student Share List</h6>
    </div>
    <div class="card-body">
        <div style="margin-bottom: 1.5em;">
            <button type="button" onclick="redirect('studentShareMgmtEdit?type=add')" class="btn btn-info">新增</button>
        </div>
        <div class="item-group" style="width: max-content; margin-bottom: 1.5em;">
            <span style="margin-right: 0.5em;">文章分類</span>
            <select id="category_id" name="category_id" class="form-control bg-light" style="width: max-content; display: inline-block;">
                <option value="0">全部</option>
                @foreach ($cSelect as $v)
                <option value="{{ $v->id }}">{{ $v->name }}</option>
                @endforeach
            </select>
        </div>
        <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%; text-align: center;">
        </table>
    </div>
</div>

<style>
</style>

<script>
    function delList(obj, id){
        if( !confirm('確定刪除?') ) return;

        gMyJs.doAjax(gBasePath + 'ajaxStudentShareMgmt', {'data': gMyJs.jwtEncode({'id': id, 'ajaxType': 'delList', 'delType': 'studentShare'})},
            function(data, resData){
                if (resData.success) {
                    gDataTable.row( $(obj).parents('tr') ).remove().draw();
                } else {
                    alert(resData.errMsg);
                }
            },
            function(){
                alert('系統錯誤');
            }
        );
    }

    function reSetPhoto(id, imgId, photoType){
        gMyJs.doAjax(gBasePath + 'ajaxStudentShareMgmt', {'data': gMyJs.jwtEncode({'id': id, 'photoType': photoType, 'ajaxType': 'reSetPhoto'})},
            function(data, resData){
                if (resData.success) {
                    $('#' + imgId).attr('src', gPublicPath + resData.photo);
                    alert('配圖成功');
                } else {
                    alert(resData.errMsg);
                }
            },
            function(){
                alert('系統錯誤');
            }
        );
    }

    var gDataTable = null;
    $(function(){
        var curCid = localStorage.getItem('cid');
        if(curCid > 0){
            $('#category_id').val(curCid);
            localStorage.removeItem('cid');
        }
        
        $('#category_id').change(function(){ 
            localStorage.setItem('cid', $('#category_id').val());
            gDataTable.ajax.reload(); 
        });

        gDataTable = $('#dataTable').DataTable({
            "order": [],
            // "autoWidth": false,
            // "columnDefs": [
            //     { "targets": 4, "width": "10em" },
            // ],
            "aoColumns": [
                { "sTitle": "文章分類", "mData": "cName" },
                { "sTitle": "文章標題", "mData": "title" },
                { "sTitle": "狀態", "mData": "state", "mRender": function(data, type, row){
                        return (data == 1) ? '啟用' : '不啟用';
                    },
                    "orderable": false, "width": "4em"
                },

                { "sTitle": "文章圖", "mData": "content_photo", "mRender": function(data, type, row){
                        var photoType = 'sPhoto', id = row.id + '_' + row.cId + '_' + photoType;
                        return '<img id="' + id + '" src="' + gPublicPath + data + '" width="100%">'; 
                    },
                    "orderable": false, "width": "3em"
                },
                { "sTitle": "重新配文章圖", "mData": "id", "mRender": function(data, type, row){
                        var photoType = 'sPhoto', id = row.id + '_' + row.cId + '_' + photoType;
                        return '<button type="button" onclick="reSetPhoto(' + data + ', \'' + id + '\', \'' + photoType + '\')" class="btn btn-success">重新配文章圖</button>';
                    },
                    "orderable": false, "width": "10em"
                },

                { "sTitle": "分類圖", "mData": "photo", "mRender": function(data, type, row){
                        var photoType = 'cPhoto', id = row.id + '_' + row.cId + '_' + photoType;
                        return '<img id="' + id + '" src="' + gPublicPath + data + '" width="100%">'; 
                    },
                    "orderable": false, "width": "12em"
                },
                { "sTitle": "重新配分類圖", "mData": "id", "mRender": function(data, type, row){
                        var photoType = 'cPhoto', id = row.id + '_' + row.cId + '_' + photoType;
                        return '<button type="button" onclick="reSetPhoto(' + data + ', \'' + id + '\', \'' + photoType + '\')" class="btn btn-success">重新配分類圖</button>';
                    },
                    "orderable": false, "width": "10em"
                },
                { "sTitle": "建立時間", "mData": "created_at", "orderable": false },
                { "sTitle": "管理", "mData": "id", "mRender": function(data, type, row){
                        return '<button type="button" onclick="redirect(\'studentShareMgmtEdit?type=edit&id=' + data + '\')" class="btn btn-info">管理</button>';
                    },
                    "orderable": false, "width": "7em"
                },
                { "sTitle": "刪除", "mData": "id", "mRender": function(data, type, row){
                        return '<a href="#" onclick="delList(this, ' + data + ')" class="btn btn-danger"><i class="fas fa-trash"></i></a>';
                    },
                    "orderable": false, "width": "7em" 
                },
            ],
            "ajax": {
                "headers": { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                "url": gBasePath + 'ajaxStudentShareMgmt',
                "type": "POST",
                "data": function (d) {
                    var data = {
                        'ajaxType': 'getStudentShareList',
                        'cid': $('#category_id').val(),
                    };
                    return $.extend({}, d, {'data': gMyJs.jwtEncode(data)});
                }
            },
        });
    });
</script>

@endsection