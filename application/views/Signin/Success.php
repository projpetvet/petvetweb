<html>
    <head>
        <title>Google Sign in</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    </head>
    <style>
        .centered
        {
            text-align: center;
            top: 50%;
            left: 50%;
            position: absolute;
            transform: translate(-50%,-50%);
            width: 100%;
        }
        
        body
        {
            font-family: 'Poppins', sans-serif;
        }
        
        span
        {
            display: block;
            margin-bottom: 10px;
        }
        
        .success
        {
            color: #0c827f;
            font-size: 40px;
            font-weight: bold;
        }
        
        .caption
        {
            color: #a09e9e;
            font-size: 14px;
        }
        
        .code
        {
            color: #0c827f;
            font-weight: bold;
            font-size: 30px;
        }
    </style>
    <body>
        <div class="centered">
            <span class="success">SUCCESS!</span>
            <span class="caption">
                Your verification code is:
            </span>
            <span class="code">
                <?php echo $web_code;?>
            </span>
        </div>
    </body>
</html>