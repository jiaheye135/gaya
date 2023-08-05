@extends('backend.layouts.main')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">服務項目</h6>
    </div>
    <div class="card-body">
        <div class="row" style="margin-top: 1em;">
            <div class="col-lg-6">
                <input id="name" name="name" type="text" class="form-control bg-light" placeholder="">
                <button id="addRow" name="save" type="submit" class="btn btn-info" style="width: 58px;">
                    <img src="{{ $publicPath }}base/image/loading.gif" width="24px" style="display: none;">
                    <span>新增</span>
                </button>
            </div>
        </div>
        <div class="row" style="margin-top: 1em;">
            <div class="col-lg-6">
                <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%; text-align: center;">
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    #name{
        display: inline;
        width: 12em;
        margin-right: 0.5em;
    }

    #addRow{
        height: 38px;
        margin-bottom: 2px;
    }
</style>

<script>
    var gDataTable = null;

    function addNewRow(btnObj){
        var name = $('#name').val().trim();
        if(!name) return;

        gMyJs.setLoadingBtn(btnObj, 'open');

        gMyJs.doAjax(gBasePath + 'edit-service-item', {name: name, type: 'add'}, 
            function(data, resData){

                if (resData.success) {
                    gDataTable.row
                        .add({
                            "id": "",
                            "name": name,
                            "service_items_id": resData.service_items_id
                        })
                        .draw(false);
                    $('#name').val('');
                    alert('新增成功');
                } else {
                    alert(resData.errMsg);
                }
                gMyJs.setLoadingBtn(btnObj, 'close');
            },
            function(){
                alert('系統錯誤');
                gMyJs.setLoadingBtn(btnObj, 'close');
            }
        );
    }

    function delRow(obj, id){
        if( !confirm('確定刪除?') ) return;

        gMyJs.doAjax(gBasePath + 'edit-service-item', {id: id, type: 'del'},
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

    $(function(){
        gDataTable = $('#dataTable').DataTable({
            "order": [],
            "sort": false,
            paging: false,
            searching: false,
            info: false,
            // "autoWidth": false,
            // "columnDefs": [
            //     { "targets": 4, "width": "10em" },
            // ],
            "aoColumns": [
                { "sTitle": "#", "mData": "id" },
                { "sTitle": "服務項目", "mData": "name" },
                { "sTitle": "編輯", "mData": "service_items_id", "mRender": function(data, type, row){
                        return '<button type="button" onclick="delRow(this, \'' + data + '\')" class="btn btn-danger">刪除</button>';
                    },
                    "orderable": false, "width": "7em"
                },
            ],
            "ajax": {
                "headers": { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                "url": gBasePath + 'get-service-items',
                "type": "POST",
                "data": function (d) {
                    var data = {
                    };
                    return $.extend({}, d, {'data': gMyJs.jwtEncode(data)});
                }
            },
        });

        gDataTable.on('draw.dt', function () {
            gDataTable.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        });
        
        $('#addRow').click(function(){ addNewRow(this); });
        $('.search-select').change(function(){ gDataTable.ajax.reload(); });
    });
</script>

@endsection