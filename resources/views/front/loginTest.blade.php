<html>
    <head>
        <meta charset="utf-8"/>
    </head>
    <body>
        <div>
            Facebook登入：<input type="button" value="Facebook登入" onclick="FBLogin();" />
            Facebook斷開：<input type="button" value="Facebook斷開" onclick="Del_FB_App();" />
            <div id="content"></div>
        </div>

        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/zh_TW/sdk.js"></script>

        <script>
            function GetProfile(){
                //取得用戶個資
                FB.api("/me", { fields: 'last_name,first_name,name,email' }, function (user) {
                    //user物件的欄位：https://developers.facebook.com/docs/graph-api/reference/user
                    if (user.error) {
                        console.log(response);
                    } else {
                        
                        document.getElementById('content').innerHTML = JSON.stringify(user);
                    }
                });
            }

            //使用自己客製化的按鈕來登入
            function FBLogin() {
                FB.login(function (response) {
                    console.log(response);
                    if (response.status === 'connected') {
                        //user已登入FB
                        //抓userID
                        let FB_ID = response["authResponse"]["userID"];
                        console.log("userID:" + FB_ID);
                        GetProfile();
                    } else {
                        // user FB取消授權
                        alert("Facebook帳號無法登入");
                    }
                }, { scope: 'public_profile,email' });
            }

            let FB_appID = "4339035309469293"; //應用程式編號，進入 https://developers.facebook.com/apps/ 即可看到

            window.fbAsyncInit = function () {
                FB.init({
                    appId: FB_appID,//FB appID
                    cookie: true,  // enable cookies to allow the server to access the session
                    xfbml: true,  // parse social plugins on this page
                    version: 'v11.0' // use graph api version
                });
                // FB.Event.subscribe('customerchat.dialogHide', function(){});
            };

        </script>
    </body>
</html>