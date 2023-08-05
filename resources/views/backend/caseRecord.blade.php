@extends('backend.layouts.main')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">個案紀錄</h6>
    </div>
    <div class="card-body">
        <div style="margin-bottom: 1.5em;">
            <button type="button" onclick="redirect('case-user?type=add')" class="btn btn-info">新增</button>
        </div>
        <div style="margin-top: 1em;">
            <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%; text-align: center;">
            </table>
        </div>
    </div>
</div>

<style>
    .search-div{
        display: inline;
        margin-right: 1em;
    }

    .search-select{
        width: max-content;
        display: inline;
    }

    #dataTable_wrapper > .row:nth-child(2){
        overflow: auto;
    }
</style>

<script>
    function checkIn(obj, id, name){
        if( !confirm('確定報到(' + name + ')?') ) return;

        gMyJs.doAjax(gBasePath + 'ajaxCouponMember', {'data': gMyJs.jwtEncode({'id': id, 'ajaxType': 'checkIn'})},
            function(data, resData){
                if (resData.success) {
                    $(obj).parent().html('<div style="color: green;">已報到</div>');
                    $('#checkInAt_' + id).text(resData.checkInAt);
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
        var datatable = $('#dataTable').DataTable({
            "order": [],
            "sort": false,
            // "autoWidth": false,
            // "columnDefs": [
            //     { "targets": 4, "width": "10em" },
            // ],
            "aoColumns": [
                { "sTitle": "姓名", "mData": "name" },
                { "sTitle": "生日", "mData": "birthday" },
                { "sTitle": "電話", "mData": "cellphone" },
                { "sTitle": "LINE ID", "mData": "line_id" },
                { "sTitle": "FB", "mData": "fb" },
                { "sTitle": "編輯", "mData": "user_id", "mRender": function(data, type, row){
                        return '<button type="button" onclick="redirect(\'case-user?type=edit&id=' + data + '\')" class="btn btn-info">編輯</button>';
                    },
                    "orderable": false, "width": "7em"
                },
            ],
            "ajax": {
                "headers": { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                "url": gBasePath + 'get-case-user-list',
                "type": "POST",
                "data": function (d) {
                    var data = {
                    };
                    return $.extend({}, d, {'data': gMyJs.jwtEncode(data)});
                }
            },
        });

        datatable.on('draw.dt', function () {
            // datatable.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            //     cell.innerHTML = i + 1;
            // });
        });
        
        $('.search-select').change(function(){ datatable.ajax.reload(); });
    });
</script>

@endsection