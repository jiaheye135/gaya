<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <title>Test Google Login</title>
</head>
<body>
    <!--用戶一鍵Google登入或綁定Google帳戶時使用↓-->
    <button type="button" id="btnSignIn">Google登入</button>
    <!--用戶解除Google帳戶綁定時使用↓-->
    <button type="button" id="btnDisconnect">斷連Google App</button>
     

    <!-- 引用jQuery-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <!--從 Web.config檔 抓取Googl App Client ID--> 
    <script type="text/javascript">
        let GoolgeApp_Cient_Id = "278651336601-to23n01o614ltuci7ain9nq4r78sg2i0.apps.googleusercontent.com"; 
    </script>
    <!--引用Google Sign-in必須的.js，callback function(GoogleSigninInit)名稱自訂 -->
    <script src="https://apis.google.com/js/platform.js?onload=GoogleSigninInit" async defer></script>

    <script type="text/javascript">
        //jQuery處理button click event 當畫面DOM都載入時....
        $(function () {
            $("#btnSignIn").on("click", function () {
                GoogleLogin();//Google 登入
            });
            $("#btnDisconnect").on("click", function () {
                Google_disconnect();//和Google App斷連
            });
        });

        function GoogleSigninInit() {
            gapi.load('auth2', function () {
                gapi.auth2.init({
                    client_id: GoolgeApp_Cient_Id//必填，記得開發時期要開啟 Chrome開發人員工具 查看有沒有403錯誤(Javascript來源被禁止)
                });
            });//end gapi.load
        }//end GoogleSigninInit function

        function GoogleLogin() {
            let auth2 = gapi.auth2.getAuthInstance();//取得GoogleAuth物件
            auth2.signIn().then(function (GoogleUser) {
                console.log("Google登入成功"); 
                let user_id =  GoogleUser.getId();//取得user id，不過要發送至Server端的話，請使用↓id_token   
                let AuthResponse = GoogleUser.getAuthResponse(true) ;//true會回傳access token ，false則不會，自行決定。如果只需要Google登入功能應該不會使用到access token
                let id_token = AuthResponse.id_token;//取得id_token
                console.log(id_token);
                // $.ajax({
                //     url: id_token_to_userIDUrl,
                //     method: "post",
                //     data: { id_token: id_token },
                //     success: function (msg) {
                //         console.log(msg);
                //     }
                // });//end $.ajax 
               
            },
                function (error) {
                    console.log("Google登入失敗");
                    console.log(error);
                });

        }//end function GoogleLogin
    </script>
</body>
</html>
