@extends('backend.layouts.main')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">About Menu List</h6>
    </div>
    <div class="card-body">
        <div style="margin-bottom: 1.5em;">
            <button type="button" onclick="redirect('aboutMenuMgmtEdit?type=add')" class="btn btn-info">新增</button>
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

        gMyJs.doAjax(gBasePath + 'ajaxAboutMenuMgmt', {'data': gMyJs.jwtEncode({'id': id, 'ajaxType': 'delList'})},
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

    var gDataTable = null;

    $(function(){
        gDataTable = $('#dataTable').DataTable({
            "order": [],
            // "autoWidth": false,
            // "columnDefs": [
            //     { "targets": 4, "width": "10em" },
            // ],
            "aoColumns": [
                { "sTitle": "選項名稱", "mData": "item_title" },
                { "sTitle": "排序", "mData": "sort" },
                { "sTitle": "狀態", "mData": "state", "mRender": function(data, type, row){
                    return (data == 1) ? '啟用' : '不啟用';
                } },
                { "sTitle": "管理", "mData": "id", "mRender": function(data, type, row){
                        return '<button type="button" onclick="redirect(\'aboutMenuMgmtEdit?type=edit&id=' + data + '\')" class="btn btn-info">管理</button>';
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
                "url": gBasePath + 'ajaxAboutMenuMgmt',
                "type": "POST",
                "data": function (d) {
                    var data = {
                        'ajaxType': 'getList',
                    };
                    return $.extend({}, d, {'data': gMyJs.jwtEncode(data)});
                }
            },
        });
    });
</script>

@endsection