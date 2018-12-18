<?php   include('core/core.php'); ?>

<?php
        $query = "SELECT * FROM provinsi";
        $query = mysqli_query($connection, $query);
        if(mysqli_num_rows($query) > 0) {
            $result = array();
            while($row = mysqli_fetch_array($query)) {
                $content = array();
                $content['id'] = $row['id'];
                $content['nama'] = $row['nama'];
                array_push($result, $content);
            }
        }
?>

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
    <link href="assets/plugins/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="assets/fonts/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="assets/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>
    <!-- Other Libraries -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/plugins/daterangepicker/daterangepicker.css">
    <!-- Theme Styles -->
    <link href="assets/css/terra.css" rel="stylesheet" type="text/css">

    <link href="assets/images/dvb.ico" rel="shortcut icon">
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <form class="form-horizontal" id="action" action="#" method="POST" enctype="multipart/form-data">
                <h2 class="form-signin-heading judul">PUSPITA MARIN - DAFTAR</h2>
                <!-- <h5 class="judul">Silahkan masuk</h5><br> -->
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Nama</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required="" autofocus="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Jenis Kelamin</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 radio-group">
                            <input type="radio" value="L" name="jk" checked /> <span>Laki-laki</span>
                            <input type="radio" value="P" name="jk" /> <span>Perempuan</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Tempat Lahir</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <select class="form-control" name="tmpt_lahir" required="">
<?php   if(count($result) > 0) { ?>
                                <option value="" hidden selected disabled>Silahkan pilih</option>
<?php       for($i = 0; $i < count($result); $i++) { ?>
<?php           $item = $result[$i]; ?>
                                <option value="<?php echo $item['id']?>"><?php echo $item['nama']?></option>
<?php       } ?>
<?php   } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Tanggal Lahir</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="text" class="form-control date" name="tgl_lahir" placeholder="YYYY-MM-DD" required="" readonly="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Tempat Tinggal</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <select class="form-control" name="domisili" required="">
<?php   if(count($result) > 0) { ?>
                                <option value="" hidden selected disabled>Silahkan pilih</option>
<?php       for($i = 0; $i < count($result); $i++) { ?>
<?php           $item = $result[$i]; ?>
                                <option value="<?php echo $item['id']?>"><?php echo $item['nama']?></option>
<?php       } ?>
<?php   } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Username</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="text" class="form-control" name="usr" placeholder="Maksimal 15 karakter" required="" maxlength="15" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Password</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="password" class="form-control pass" name="pw" placeholder="Maksimal 15 karakter" required="" maxlength="15" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Pastikan Password</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="password" class="form-control pass" placeholder="Pastikan sama dengan password di atas" required="" maxlength="15" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <button class="btn btn-lg btn-primary" type="submit" name="submit_daftar" value="Daftar" style="float:left;">Daftar</button>
                        <a href="login.php" class="btn btn-lg btn-info" role="button" style="float:left;">Kembali</a>
                    </div>
                </div>
                <br>
                <!-- <a href="daftar.php" role="button"><h5 class="judul">Belum punya akun? Daftar disini</h5></a> -->
            </form>
        </div>
    </div>

<!-- Loading Javascripts... -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/plugins/jquery/3.3.1/js/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/plugins/select2/select2.min.js"></script>
    <script src="assets/plugins/daterangepicker/moment.min.js"></script>
	<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="assets/plugins/waves/waves.min.js"></script>
    <script src="assets/js/terra.js"></script>

    <!-- Loading Core... -->
<?php   $uri = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']); ?>
<?php   $uri = $uri == 'malaria' ? 'index' : basename($uri, '.php'); ?>
    <script type="text/javascript" src="<?php echo $uri; ?>.js"></script>
</body>
</html>
