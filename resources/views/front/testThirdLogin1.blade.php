<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://hilife-hishopping.azureedge.net/address/city.js"></script>

    <script>
        var mydata = JSON.stringify('https://hilife-hishopping.azureedge.net/address/city.js');
        // var users = require('https://hilife-hishopping.azureedge.net/address/city.js');

        // var option = {
        //     url: 'https://hilife-hishopping.azureedge.net/address/city.js',
        //     type: 'get',
        //     // dataType: 'json',
        //     // data: data,
        //     success: function (resData) {
                console.log(mydata);
        //         // if(typeof callback === 'function') callback(data, resData, param);
        //     },
        //     error: function (xhr, ajaxOptions, thrownError) {
        //         console.log(xhr, ajaxOptions, thrownError);
        //         // if(typeof errorCallback === 'function') errorCallback(data, param);
        //     },
        // }

        // $.ajax(option);

        function readTextFile(file, callback) {
            var rawFile = new XMLHttpRequest();
            rawFile.overrideMimeType("application/json");
            rawFile.open("GET", file, true);
            rawFile.onreadystatechange = function() {
                if (rawFile.readyState === 4 && rawFile.status == "200") {
                    callback(rawFile.responseText);
                }
            }
            rawFile.send(null);
        }

        //usage:
        readTextFile('https://hilife-hishopping.azureedge.net/address/city.js', function(text){
            var data = JSON.parse(text);
            console.log(data);
        });
    </script>
</head>
<style>
    input{
        margin: 1em;
    }

    /* this is for the circle position */
    .fb_dialog .fb_dialog_advanced {
        left: 18pt;
    }

    /* The following are for the chat box, on display and on hide */
    iframe .fb_customer_chat_bounce_in_v2 {
        left: 9pt;
    }
    iframe .fb_customer_chat_bounce_out_v2 {
        left: 9pt;
    }

    .fb-customerchat.fb_iframe_widget iframe {
        left:  auto;
        transform:  none;
    }
    .back-top {
        bottom:  100px;
    }
    @media only screen and (max-width: 480px) {
        .fb-customerchat.fb_iframe_widget
        iframe {
            max-width: 360px !important;
        }
        .fb-customerchat.fb_iframe_widget+.fb_dialog {
            right: 15px !important;
        }
    }
    @media only screen and (max-width: 320px) {
        .fb-customerchat.fb_iframe_widget
        iframe {
            right: 0 !important;
            max-width: 100% !important;
        }
    }
    .mys iframe{
        top: 0;
    }
</style>
<body>

 
    <div>
        Facebook登入：<input type="button" value="Facebook登入" onclick="FBLogin();" />
        Facebook斷開：<input type="button" value="Facebook斷開" onclick="Del_FB_App();" />
        <div id="content"></div>
    </div>
    <div>
        Google登入：<input type="button" value="Google登入" onclick="GoogleLogin();" />
        Google斷開：<input type="button" value="Google斷開" onclick="Google_disconnect();" />
    </div>

    <div class="fb-customerchat mys"
        page_id="104065591529201"
        {{-- ref="" --}}
        {{-- minimized="true" --}}
        attribution=setup_tool 
        theme_color="#0b9bb8" 
        greeting_dialog_display="fade" 
        greeting_dialog_delay="60" 
        ref="home" 
        logged_in_greeting="歡迎有任何想法，都可以跟我們聯絡喔～" 
        logged_out_greeting="Fale conosco"
        >
    </div>

    <script src="{{ $webPath }}assets/js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript">
        $(function(){
            setTimeout(function(){
                console.log($('.mys iframe').length, $('.fb_dialog iframe').length);
                $('.fb_dialog iframe').css({
                    bottom: 0,
                });
                console.log($('.mys iframe').css('width'));
            }, 1000);
        });
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/zh_TW/sdk/xfbml.customerchat.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <script type="text/javascript">
        //應用程式編號，進入 https://developers.facebook.com/apps/ 即可看到
        let FB_appID = "255355465951042";

        // Load the Facebook Javascript SDK asynchronously
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/zh_TW/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        window.fbAsyncInit = function () {
            FB.init({
                appId: FB_appID,//FB appID
                cookie: true,  // enable cookies to allow the server to access the session
                xfbml: true,  // parse social plugins on this page
                version: 'v9.0' // use graph api version
            });
            // FB.Event.subscribe('customerchat.dialogHide', function(){});
        };

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
    </script>

    <!--Google登入-->
    <script async defer src="https://apis.google.com/js/api.js" onload="this.onload=function(){};HandleGoogleApiLibrary()"
            onreadystatechange="if (this.readyState === 'complete') this.onload()"></script>
    <script type="text/javascript">
        //進入 https://console.developers.google.com/，找「憑證」頁籤(記得先選對專案)，即可找到用戶端ID
        let Google_appId = "278651336601-to23n01o614ltuci7ain9nq4r78sg2i0.apps.googleusercontent.com";

        //參考文章：http://usefulangle.com/post/55/google-login-javascript-api 

        // Called when Google Javascript API Javascript is loaded
        function HandleGoogleApiLibrary() {
            // Load "client" & "auth2" libraries
            gapi.load('client:auth2', {
                callback: function () {
                    // Initialize client & auth libraries
                    gapi.client.init({
                        clientId: Google_appId,
                        scope: 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me'
                    }).then(
                        function (success) {
                            // Google Libraries are initialized successfully
                            // You can now make API calls 
                            console.log("Google Libraries are initialized successfully");
                        },
                        function (error) {
                            // Error occurred
                            console.log(error);// to find the reason 
                        }
                    );
                },
                onerror: function () {
                    // Failed to load libraries
                    console.log("Failed to load libraries");
                }
            });
        }

        function GoogleLogin() {
            // API call for Google login  
            gapi.auth2.getAuthInstance().signIn().then(
                function (success) {
                    // Login API call is successful 
                    console.log(success);
                    let Google_ID = success["El"];
                },
                function (error) {
                    // Error occurred
                    // console.log(error) to find the reason
                    console.log(error);
                }
            );
        }
    </script>

    <script type="text/javascript">
        //刪除使用者已授權你的FB App，好讓使用者下次重新授權你的FB App
        //參考：https://stackoverflow.com/questions/6634212/remove-the-application-from-a-user-using-graph-api/7741978#7741978
        function Del_FB_App() { 
            FB.getLoginStatus(function (response) {//取得目前user是否登入FB網站
                //debug用
                console.log(response);
                if (response.status === 'connected') {
                    // Logged into Facebook.
                    //抓userID
                    FB.api("/me/permissions", "DELETE", function (response) {
                        console.log("刪除結果");
                        console.log(response); //gives true on app delete success 
                    });
                } else {
                    // FB取消授權
                    console.log("無法刪除FB App");
                }
            });
        }
    </script>

    <!--類似上面Delete FB App的效果，呼叫此function後，下次使用者想再Google登入你的網站就必須重新選擇帳號-->
    <script type="text/javascript">
   
        //參考：https://developers.google.com/identity/sign-in/web/disconnect
   
        function Google_disconnect() {
            var auth2 = gapi.auth2.getAuthInstance();
            auth2.disconnect().then(function () {
                console.log('User disconnect.'); 
            });
        }
   
   
       </script>
   
   </body>
</html>