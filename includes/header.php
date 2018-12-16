<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>PUSPITAMARIN</title>

<!-- Loading CSS... -->
    <!-- Bootstrap -->
    <link href="<?php echo BASE_URI; ?>assets/plugins/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons & Fonts -->
    <link href="<?php echo BASE_URI; ?>assets/fonts/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URI; ?>assets/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>
    <!-- Other -->
    <link href="<?php echo BASE_URI; ?>assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URI; ?>assets/plugins/datatables/css/jquery.datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo BASE_URI; ?>assets/plugins/datatables/css/jquery.datatables_themeroller.css" rel="stylesheet" type="text/css"/>
    <!-- Theme Styles -->
    <link href="<?php echo BASE_URI; ?>assets/css/modal.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URI; ?>assets/css/terra.css" rel="stylesheet" type="text/css">
    <!-- <link href="<?php echo BASE_URI; ?>css/menuvertical.css" rel="stylesheet" type="text/css"/> -->

    <link href="<?php echo BASE_URI; ?>assets/images/dvb.ico" rel="shortcut icon">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>
<!-- <body background="assets/images/02.jpg"> -->
<body>
    <div class="navbar">
        <nav class="navbar navbar-inverse navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php" style="padding: 0px 15px;">
                        <img class="img-responsive" src="<?php echo BASE_URI; ?>assets/images/dvb.png" alt="PUSPITAMARIN">
                    </a>
                    <span style="color:#fff;font-size:35px;">PUSPITAMARIN</span>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                    <!-- <ul class="nav navbar-nav navbar-left"> -->
<?php   if(count($sess) > 0) { ?>
                        <li><a href="index.php">Halaman Utama</a></li>
<?php       if($sess['role'] == 'user') { ?>
                        <li><a href="diagnosa.php">Diagnosa</a></li>
                        <li><a href="histori.php">Histori</a></li>
<?php       } else if($sess['role'] == 'admin') { ?>
                        <li><a href="provinsi.php">Provinsi</a></li>
                        <li><a href="data_latih.php">Data Latih</a></li>
<?php       } ?>
<?php   } ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <!-- <li><a href="#">Link</a></li> -->
                        <li class="dropdown">
<?php if(count($sess) > 0) { ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome, <?php echo $sess["nama"]; ?><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo BASE_URI; ?>profil.php">
                                    <span class="fa fa-user m-r-xs"></span> Profil
                                </a></li>
                                <li><a href="<?php echo BASE_URI; ?>ganti_password.php">
                                    <span class="fa fa-lock m-r-xs"></span> Ganti <i>password</i>
                                </a></li>
                                <li><a href="<?php echo BASE_URI; ?>logout.php">
                                    <span class="fa fa-sign-out m-r-xs"></span> Keluar
                                </a></li>
                                <!-- <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Separated link</a></li> -->
                            </ul>
<?php } else { ?>
                            <a href="login.php" class="dropdown" role="button">Masuk</a>
<?php } ?>
                        </li>
                    </ul>
                </div><!-- navbar-collapse -->
            </div>
        </nav>
    </div>
