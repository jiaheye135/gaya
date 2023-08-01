<!--FIXED COUPON IMAGE-->
<div class="fixed-img" style="">
    <img src="{{ $webPath }}assets/images/pages/discount-icon@2x.png" class="discount-icon" data-toggle="modal" data-target="#coupon" style="">
</div>

<!-- Modal -->
<div class="modal fade" id="coupon" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="coupon-form">
                    <img src="{{ $webPath }}assets/images/coupon-header@2x.png" />
                    <form>
                        <div class="row">
                            @foreach ($meets as $v)
                            <div class="col-12 col-sm-6">
                                <label>
                                    <?php $checked = ($data['courseInfo']->id != $v->id) ? '' : 'checked'; ?>
                                    <input type="radio" class="largerCheckbox" name="meets" value="{{ $v->id }}" {{ $checked }}>{{ $v->name }}
                                    @if ($data['courseInfo']->id != $v->id ) <a style="background: unset; color: #5599FF; font-weight: bold;" href="{{ $v->href }}">(課程介紹)</a> @endif
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group data">
                            <div class="">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <i class="fa fa-user"></i>
                                            <input type="text" class="form-control" name="member_name" placeholder="姓名" required="required" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group mb-3">
                                            <i class="fas fa-phone-volume"></i>
                                            <input type="phone" class="form-control" name="member_tel" placeholder="聯絡電話" required="required" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group">
                                            <i class="fa fa-envelope"></i>
                                            <input type="email" class="form-control" name="member_email" placeholder="Email帳號" required="required" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-div text-center">
                            <button style="width: 100px;" type="button" class="btn btn-secondary mt-2" data-dismiss="modal">取消</button>
                            <button style="width: 100px;" type="button" class="btn btn-primary send mt-2">送出資料</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function hideCoupon() {
        $('.fixed-img').css('right', 10);
    }

    function initInput(action) {
        var couponInput = $('.coupon-form .data input');

        $('.fixed-img').css('right', 10);
        couponInput.removeClass('red-border').removeClass('animation-flash');

        if(action != 'btnAction'){ couponInput.val(''); }
    }

    function checkData(obj, val){
        if(!val){
            obj.addClass('red-border').addClass('animation-flash');
            setTimeout(function(){ obj.removeClass('animation-flash'); }, 350);
            return false;
        }
        return true;
    }

    function send(){
        if(gSending) return;

        initInput('btnAction');

        gSend = true;
        var data = {}, sendFlag = true;

        $('.coupon-form .data input').each(function(){
            var key = this.name, val = this.value.trim();
            if(!checkData($(this), val))
                sendFlag = false;
            else {
                data[key] = val;
            }
        });
        
        if(!sendFlag) return;

        setSendingStatus('start');
        gMyJs.doAjax('{{ $basePath }}ajaxJoinMeet', {'data': gMyJs.jwtEncode({'data': data, 'meetId': $('input[name=meets]:checked').val()})}, 
            function(data, resData){
                if (resData.success) {
                    if(resData.msg) alert(resData.msg);
                    $('#coupon').modal('hide');
                } 
                else if (resData.errMsg) {
                    alert(resData.errMsg);
                }
                else {
                    alert('系統錯誤(-1)');
                }
                setSendingStatus('end');
            },
            function(){
                alert('系統錯誤');
                setSendingStatus('end');
            }, 
        );
    }

    function sendIngBtn(){
        if(gSending){
            var text = '寄信中';
            for(var i=1; i<=gDot % 5; i++){ text += '.'; } gDot++;

            $('.coupon-form .btn-div .send').text(text);
            $('.coupon-form .btn-div button').prop('disabled', true);
            setTimeout(sendIngBtn, 300);
        } else {
            var text = '送出資料';
            gDot = 0;

            $('.coupon-form .btn-div .send').text(text);
            $('.coupon-form .btn-div button').prop('disabled', false);
        }
    }

    function setSendingStatus(action){
        if(action == 'start'){
            gSending = true;
        }
        if(action == 'end'){
            gSending = false;
        }
        sendIngBtn();
    }

    var gSending = false, gDot = 0;
    $('.coupon-form .send').click(send);
    $('#coupon').on('show.bs.modal', initInput);
    $('#coupon').on('hidden.bs.modal', hideCoupon);

</script>