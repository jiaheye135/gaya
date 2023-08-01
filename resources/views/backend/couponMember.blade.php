@extends('backend.layouts.main')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary title">優惠券領取列表</h6>
    </div>
    <div class="card-body">

        <div class="search-div">
            課程名稱:
            <select id="courseName" class="search-select form-control bg-light">
                <option value="">全部</option>
                @foreach ($courseList as $v)
                <option value="{{ $v->course_name }}">{{ $v->course_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="search-div">
            報到狀態:
            <select id="checkIn" class="search-select form-control bg-light">
                <option value="-1">全部</option>
                <option value="0">未報到</option>
                <option value="1">已報到</option>
            </select>
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
                { "sTitle": "編號", "mData": null, "width": "32px"},
                { "sTitle": "姓名", "mData": "member_name" },
                { "sTitle": "手機", "mData": "member_tel" },
                { "sTitle": "信箱", "mData": "member_email" },
                { "sTitle": "課程", "mData": "course_name", "mRender": function(data, type, row){
                    return '<div style="color: darkviolet;">' + data + '</div>';
                } },
                { "sTitle": "領取時間", "mData": "created_at", "width": "148px" },
                { "sTitle": "優惠券序號", "mData": "coupon_code", "mRender": function(data, type, row){
                    return '<div style="color: red;">' + data + '</div>';
                } },
                { "sTitle": "報到", "mData": "check_in", "width": "110px", "mRender": function(data, type, row){
                        var h = '<div style="color: green;">已報到</div>';
                        if(data == 0){
                            h = '<button type="button" onclick="checkIn(this, ' + row.id + ', \'' + row.member_name + '\')" class="btn btn-success">我要報到</button>';
                        }
                        return h;
                    }, "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        $(nTd).css('height', 32);
                    } 
                },
                { "sTitle": "報到時間", "mData": "check_in_at", "width": "148px", "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        $(nTd).attr('id', 'checkInAt_' + oData.id);
                    } 
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
    });
</script>

@endsection