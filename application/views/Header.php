<!DOCTYPE html> 
<html lang = "en"> 
    <head> 
        <meta charset = "utf-8"> 
        <title>PetVet</title> 
        <link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/bootstrap.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
        
        <script src = '<?php echo base_url(); ?>js/tinymce/tinymce.min.js'></script>
        <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/jquery-1.11.3.js"></script>
        <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/bootstrap.min.js"></script>
        <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/script.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!--<button class="menu-toggle">
                      <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>-->
                    <a class="navbar-brand" href="#">PetVet</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a id="btnLogOut" href="/admin"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="left-nav col-xs-2">
            <div class="left-nav-wrapper">
                <ul class="list-group">
                    <a href="/admin/orders">
                        <li class="list-group-item">Orders </li>
                    </a>
                    <a href="/admin/appointments">
                        <li class="list-group-item">Appointments </li>
                    </a>
                    <a href="/admin/products">
                        <li class="list-group-item">Products </li>
                    </a>
                    <a href="/admin/services">
                        <li class="list-group-item">Services </li>
                    </a>
                    <a href="/admin/doctors">
                        <li class="list-group-item actives">Doctors </li>
                    </a>
                    <a href="/admin/members">
                        <li class="list-group-item">Members </li>
                    </a>
                    <a href="/admin/pets">
                        <li class="list-group-item">Pets </li>
                    </a>
                    <a href="/admin/useradmin">
                        <li class="list-group-item">User Admin </li>
                    </a>
                </ul>
            </div>
        </div>