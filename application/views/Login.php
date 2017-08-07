<!DOCTYPE html> 
<html lang = "en"> 
    <head> 
        <meta charset = "utf-8"> 
        <title>PetVet</title> 
        <link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/bootstrap.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
        <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/jquery-1.11.3.js"></script>
        <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/bootstrap.min.js"></script>
        <script src = '<?php echo base_url(); ?>js/tinymce/tinymce.min.js'></script>
        <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/script.js"></script>
    </head>
    <body>
        <div id="logInContainer">
            <img src="/images/logo.png" class="login-logo">
            <div id="logInStatus" class="col-xs-12">
                <!-- Error message -->
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="userName" placeholder="Username..." />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="password" placeholder="Password..." />
            </div>
            <div class="form-group">
                <button class="btn btn-submit pull-right" id="btnLogIn">Log In</button>
            </div>
        </div>
    </body>
</html>