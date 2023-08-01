<!DOCTYPE html>
<html lang="en">
@include('backend.layouts.head')

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">登入系統</h1>
                                    </div>
                                    <form id="loginForm" class="user">
                                        <div class="form-group">
                                            <input name="account" type="" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Account...">
                                        </div>
                                        <div class="form-group">
                                            <input name="pwd" type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <div class="form-group" style="height: 1.5rem;">
                                            <div class="my-error_msg" style="text-align: center; font-size: 90%;"></div>
                                            <!-- <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">記住我</label>
                                                </div> -->
                                        </div>
                                        <a href="javascript:validateForm();" class="btn btn-info btn-user btn-block">
                                            登入
                                        </a>
                                        <!-- <hr>
                                            <a href="index.html" class="btn btn-google btn-user btn-block">
                                                <i class="fab fa-google fa-fw"></i> Login with Google
                                            </a>
                                            <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                                <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                            </a> -->
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <!-- <a class="small" href="forgot-password.html">忘記密碼?</a> -->
                                    </div>
                                    <div class="text-center">
                                        <!-- <a class="small" href="register.html">創建帳號</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</body>

<!-- Bootstrap core JavaScript-->
<script src="{{ $webPath }}assets/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="{{ $webPath }}assets/js/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="{{ $webPath }}assets/js/sb-admin-2.min.js"></script>

<!-- my -->
<script src="{{ $publicPath }}base/js/my.js"></script>

<script>
    function validateForm(){
        gMyJs.chearErrorMsg();

        var err = false, data = {};
        var formGroup = $('#loginForm');
        $('#loginForm .form-group input').each(function(){
            var key = this.name;
            if(!key) return;

            var res = gMyJs.checkEmpty(this.value.trim(), formGroup, '帳號或密碼輸入錯誤');
            if('error' in res){ err = true; }
            if('value' in res){
                data[key] = res.value;
            }
        });
        
        if(err){ return; }

        gMyJs.doAjax('{{$basePath}}ajaxLogin', {'data': gMyJs.jwtEncode(data)}, 
            function(data, resData){
                if (resData.success) {
                    if(resData.url) location.href = resData.url;
                } else {
                    gMyJs.showErrorMsg($('#loginForm'), resData.errMsg);
                }
            }
        );
    }

    function addkeyboardEvent(e){
        var x = e.which || e.keyCode;
        if(x != 13) return;

        validateForm();
    }

    $(function(){
        $('#loginForm .form-group input').keypress(addkeyboardEvent);
        $('button[name=submit]').click(validateForm);
    });
</script>

</html>