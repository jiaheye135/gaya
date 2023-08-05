@extends('backend.layouts.main')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">個案資料</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 mb-3 item-group">
                <h6 class="text-primary title">*姓名:</h6>
                <input id="name" name="name" type="text" class="form-control bg-light" placeholder="">
                <div class="my-error_msg"></div>
            </div>
            <div class="col-lg-6 mb-3 item-group">
                <h6 class="text-primary title">LINE ID:</h6>
                <input id="line_id" name="line_id" type="text" class="form-control bg-light" placeholder="">
                <div class="my-error_msg"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-3 item-group">
                <h6 class="text-primary title">生日:</h6>
                <input id="birthday" name="birthday" type="text" class="form-control bg-light" placeholder="2000-01-01">
                <div class="my-error_msg"></div>
            </div>
            <div class="col-lg-6 mb-3 item-group">
                <h6 class="text-primary title">FB:</h6>
                <input id="fb" name="fb" type="text" class="form-control bg-light" placeholder="">
                <div class="my-error_msg"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-3 item-group">
                <h6 class="text-primary title">手機:</h6>
                <input id="cellphone" name="cellphone" type="text" class="form-control bg-light" placeholder="">
                <div class="my-error_msg"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="text-align: center">
                <button name="save" type="submit" class="btn btn-info" style="width: 58px; height: 32.38px;">
                    <img src="{{ $publicPath }}base/image/loading.gif" width="25px" style="display: none;">
                    <span>儲存</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">歷史個案紀錄</h6>
    </div>
    <div class="card-body">
        <div style="margin-bottom: 1.5em;">
            <button type="button" onclick="redirect('case-user-record?type=add')" class="btn btn-info">新增</button>
        </div>
        <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%; text-align: center;">
        </table>
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

    // 個人資料建置
    function buildDetail(detailList, doType)
    {
        var groupClassName = 'item-group';
        var submitList = gMyJs.setValus(gPublicPath, detailList, groupClassName);

        // 個人資料儲存
        $('button[name=save][type=submit]').click(
            function(){
                gMyJs.save(this, 'case-user-edit', submitList, groupClassName, doType, 'group');
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
                { "sTitle": "服務項目", "mData": "course_name", "width": "148px"  },
                { "sTitle": "服務時間", "mData": "course_name", "width": "148px"  },
                { "sTitle": "建立時間", "mData": "created_at", "width": "148px" },
                { "sTitle": "更新時間", "mData": "created_at", "width": "148px" },
                { "sTitle": "編輯", "mData": "id", "mRender": function(data, type, row){
                        return '<button type="button" onclick="redirect(\'studentShareMgmtEdit?type=edit&id=' + data + '\')" class="btn btn-info">管理</button>';
                    },
                    "orderable": false, "width": "7em"
                },
            ],
            "ajax": {
                "headers": { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                "url": gBasePath + 'ajaxCouponMember',
                "type": "POST",
                "data": function (d) {
                    var data = {
                        'courseName': $('#courseName').val(),
                        'checkIn': $('#checkIn').val(),
                        'ajaxType': 'getList',
                    };
                    return $.extend({}, d, {'data': gMyJs.jwtEncode(data)});
                }
            },
        });

        datatable.on('draw.dt', function () {
            datatable.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        });
        
        $('.search-select').change(function(){ datatable.ajax.reload(); });

        // 個人資料建置
        buildDetail(@json($detailList), @json($doType));
    });
</script>

@endsection