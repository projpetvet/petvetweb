<html>
  <head>
    <title>Google Sign in</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include the API client and Google+ client. -->
    <script src = "https://plus.google.com/js/client:platform.js" async defer></script>
    <script src = "/js/jquery-1.11.3.js"></script>
  </head>
  <style>
    .main-container
    {
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .gmail-logo
    {
        text-align: center;
        margin: 30px 0;
    }
    
    .gmail-logo img
    {
        width: 150px;
        margin-bottom: 10px;
    }
    
    .gmail-account
    {
        width: 250px;
        height: 50px;
        padding: 10px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
        display: none;
    }
    
    .gmail-account img
    {
        border-radius: 50%;
        display: inline;
        float: left;
        margin-right: 10px;
    }
    
    .gmail-account .g-detail
    {
        display: inline;
    }
    
    .g-detail span
    {
        display: block;
        font: 13.3333px Arial;
    }
    
    #g-name
    {
        font-weight: bold;
        font-size: 16px;
        padding-top: 8px;
        color: #222;
    }
    
    #g-email
    {
        font-size: 14px;
        color: #404040;
    }
    
  </style>
  <body>
    <!-- Container with the Sign-In button. -->
    <div class="main-container">
        <div class="gmail-logo">
            <img src="/images/google.png">
        </div>
        <div class="gmail-account">
            <img id="g-image" src="">
            <div class="g-detail">
                <span id="g-name"></span>
                <span id="g-email"></span>
                <input type="hidden" id="g-id">
            </div>
        </div>
        <div id="gConnect" class="button" style="text-align: center;">
          <button class="g-signin"
              data-scope="email"
              data-clientid="782228621996-5r79bsgdcrne1lpcs6ceah8fm6jtqg6j.apps.googleusercontent.com"
              data-callback="onSignInCallback"
              data-theme="dark"
              data-cookiepolicy="single_host_origin">
          </button>
          <!-- Textarea for outputting data -->
    <!--      <div id="response" class="hide">
            <textarea id="responseContainer" style="width:100%; height:150px"></textarea>
          </div>-->
        </div>
    </div>
 </body>

  <script>
  function signOut() {
    gapi.auth.signOut();
  }
  /**
   * Handler for the signin callback triggered after the user selects an account.
   */
  function onSignInCallback(resp) {
    gapi.client.load('plus', 'v1', apiClientLoaded);
  }

  /**
   * Sets up an API call after the Google API client loads.
   */
  function apiClientLoaded() {
    gapi.client.plus.people.get({userId: 'me'}).execute(handleEmailResponse);
  }

  /**
   * Response callback for when the API client receives a response.
   *
   * @param resp The API response object with the user email and profile information.
   */
  function handleEmailResponse(resp) {
//    var primaryEmail;
//    for (var i=0; i < resp.emails.length; i++) {
//      if (resp.emails[i].type === 'account') primaryEmail = resp.emails[i].value;
//    }
    console.log(resp);
    $("#g-name").html(resp.displayName);
    $("#g-email").html(resp.emails[0].value);
    $("#g-id").val(resp.id);
    $("#g-image").attr("src",resp.image.url);
    $(".gmail-account").show();
    $("#gConnect").hide();
//    document.getElementById('responseContainer').value = 'Primary email: ' +
//        primaryEmail + '\n\nFull Response:\n' + JSON.stringify(resp);
  }
  
    $(document).ready(function(){
        $(".gmail-account").click(function(){
           var name = $("#g-name").html();
           var web_key = $("#g-email").html();
           window.location.href = 'http://petvet.dev.ph/webservice/registerWebUser?name='+name+"&web_key="+web_key;
        });
    });

  </script>

</html>
