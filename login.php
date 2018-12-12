<?php   include('core/core.php'); ?>
<?php   include('olah.php'); ?>
<?php
        ob_start();
        session_start();
    	if(isset($_SESSION['malaria'])) header('location:index.php');

        $failed = false;
        if(isset($_POST['submit_login'])) {
            $usr = $_POST['usr'];
            $pw = $_POST['pw'];

            $select = "SELECT pengguna.*, lahir.nama AS 'tmpt_lahir_nama', tinggal.nama AS 'domisili_nama' FROM pengguna, provinsi lahir, provinsi tinggal WHERE pengguna.tmpt_lahir = lahir.id AND pengguna.domisili = tinggal.id AND username = '$usr' AND password = '$pw'";
            $query = mysqli_query($connection, $select);
            if(mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_array($query);
                // $row = json_encode($row, true);
                // print_r($row);
                $userdata = array();
                $userdata['id'] = $row['id'];
                $userdata['nama'] = $row['nama'];
                $userdata['jenis_kelamin'] = $row['jenis_kelamin'];
                $userdata['tmpt_lahir_id'] = $row['tmpt_lahir'];
                $userdata['tmpt_lahir'] = $row['tmpt_lahir_nama'];
                $userdata['tgl_lahir'] = $row['tgl_lahir'];
                $userdata['domisili_id'] = $row['domisili'];
                $userdata['domisili'] = $row['domisili_nama'];
                $userdata['username'] = $row['username'];
                $userdata['role'] = $row['hak_akses'];
                $_SESSION['malaria'] = $userdata;
                header("location:index.php");
                $failed = false;
            } else $failed = true;
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
    <!-- Theme Styles -->
    <link href="assets/css/terra.css" rel="stylesheet" type="text/css">
    <link href="assets/css/loginstyle.css" rel="stylesheet" type="text/css"/>
    <!-- <link href="assets/css/login-modal.css" rel="stylesheet" type="text/css"/> -->
    <!-- <link href="css/menuvertical.css" rel="stylesheet" type="text/css"/> -->

    <link href="assets/images/dvb.ico" rel="shortcut icon">
</head>
<body>
    <div class="container">
<?php
        $div = <<<EOD
        <div class="alert alert-danger fade in alert-dismissible alert-php">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <strong>Login gagal,</strong> <i>Username</i> atau <i>password</i> anda salah.
        </div>
EOD;
?>
<?php   if($failed) echo($div); ?>
        <div class="wrapper">
            <form class="form-signin" action="login.php" method="POST" enctype="multipart/form-data">
                <h2 class="form-signin-heading judul">PUSPITA MARIN</h2>
                <h5 class="judul">Silahkan masuk</h5><br>
                <input type="text" class="form-control" name="usr" placeholder="Username" required="" autofocus="" />
                <input type="password" class="form-control" name="pw" placeholder="Password" required=""/>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit_login" value="Login">Login</button>
                <br>
                <h5 class="judul">Belum punya akun? <a href="daftar.php" role="button">Daftar disini</a></h5>
                <h5 class="judul">Kembali ke <a href="index.php">Halaman utama</a></h5>
            </form>
        </div>
    </div>

<!-- Loading Javascripts... -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/plugins/jquery/3.3.1/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/plugins/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="assets/plugins/waves/waves.min.js"></script>
    <!-- <script src="assets/js/terra.js"></script> -->

    <!-- Loading Core... -->
<?php   $uri = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']); ?>
<?php   $uri = $uri == 'malaria' ? 'index' : basename($uri, '.php'); ?>
    <!-- <script type="text/javascript" src="<?php echo $uri; ?>.js"></script> -->
</body>
</html>
