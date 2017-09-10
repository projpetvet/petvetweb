<html>
    <head>
        <title>Facebook Sign in</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            function redirectVerified(name,fbid)
            {
                window.location.href = 'http://projpetvet.000webhostapp.com/webservice/registerWebUser?name='+name+"&web_key="+fbid;
                //window.location.href = 'http://petvet.dev.ph/webservice/registerWebUser?name='+name+"&web_key="+fbid;
            }
            
            function statusChangeCallback(response)
            {
                console.log('statusChangeCallback');
                console.log(response);
                // The response object is returned with a status field that lets the
                // app know the current login status of the person.
                // Full docs on the response object can be found in the documentation
                // for FB.getLoginStatus().
                if (response.status === 'connected') {
                    // Logged into your app and Facebook.
                    testAPI();
                } else {
                    // The person is not logged into your app or we are unable to tell.
                    document.getElementById('status').innerHTML = 'Please log ' +
                            'into this app.';
                }
            }

            function checkLoginState() {
                FB.getLoginStatus(function (response) {
                    statusChangeCallback(response);
                });
            }

            function testAPI()
            {
                console.log('Welcome!  Fetching your information.... ');
                FB.api('/me', function (response) {
                    console.log(response);
                    redirectVerified(response.name,response.id);
                    console.log('Successful login for: ' + response.name);
                });
            }
            
            var is_dev = false;
            if(is_dev)
            {
                var app_id = '1506101012771043';
            }
            else
            {
                var app_id = '1815515045128611';
            }
            
            window.fbAsyncInit = function () {
                FB.init({
                    appId: app_id,
                    cookie: true,
                    xfbml: true,
                    version: 'v2.10'
                });
                FB.AppEvents.logPageView();
                FB.getLoginStatus(function (response) {
                    if (response.status === 'connected') {
                        console.log('Logged in.');
                        statusChangeCallback(response);
                    } else {
                        //FB.login();
                    }
                });
            };

            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));

        </script>
    </head>
    <body>
        <fb:login-button scope="public_profile,email" onlogin="checkLoginState();" style="    position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);">
        </fb:login-button>

        <div id="status">
        </div>
    </body>
</html>