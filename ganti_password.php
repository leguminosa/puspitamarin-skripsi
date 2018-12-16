<?php   include('core/core.php'); ?>
<?php   include('includes/session.php'); ?>
<?php   if(count($sess) == 0) header('location:index.php'); ?>
<?php   //print_r($sess); ?>

<?php
        // print_r($_SESSION);
        if(isset($_SESSION['afterInsert'])) $afterInsert = $_SESSION['afterInsert'];
        else $afterInsert = false;
        if($afterInsert != false) $_SESSION['afterInsert'] = false;
        // var_dump(isset($_POST['simpan']));
        if(isset($_POST['simpan'])) {
            $simpan = $_POST;
            $id = $sess['id'];
            $old = $simpan['pw_old'];
            $pw = $simpan['pw'];
            $cek = $simpan['pw_cek'];
            // print_r($simpan);
            if($pw != $cek) {
                $_SESSION['afterInsert'] = 'cek';
                header('location:ganti_password.php');
            } else {
                $select = "SELECT COUNT(*) AS 'password_lama_benar' FROM pengguna WHERE id='$id' AND password='$old'";
                $query = mysqli_query($connection, $select);
                $benar = 0;
                if(mysqli_num_rows($query) > 0) {
                    $row = mysqli_fetch_array($query);
                    $benar = $row['password_lama_benar'];
                }
                if($benar == 0) {
                    $_SESSION['afterInsert'] = 'old';
                    header('location:ganti_password.php');
                } else {
                    $update = "UPDATE pengguna SET password='$pw' WHERE id='$id'";
                    mysqli_query($connection, $update);
                    $_SESSION['afterInsert'] = false;
                    header('location:index.php');
                }
            }
            // print_r($_POST);
            // $_POST = array();
            // print_r($_POST);
        }
        // var_dump($afterInsert);
?>

<?php   include('includes/header.php'); ?>
    <main>
        <div class="container">
            <h1>GANTI PASSWORD</h1>
<?php
        $div_cek = <<<EOD
        <div class="alert alert-warning fade in alert-dismissible alert-php">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <strong>Galat,</strong> Password anda tidak cocok.
        </div>
EOD;
        $div_old = <<<EOD
        <div class="alert alert-danger fade in alert-dismissible alert-php">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <strong>Galat,</strong> <i>Password</i> lama Anda salah.
        </div>
EOD;
?>
<?php
        if($afterInsert == 'after') {
            // echo($div_after);
        } else if($afterInsert == 'cek') {
            echo($div_cek);
        } else if($afterInsert == 'old') {
            echo($div_old);
        }
?>
<?php   //if($afterInsert == 'after') { echo($div_after); } ?>
<?php   //else if($afterInsert == 'cek') { echo($div_cek); } ?>
<?php   //else if($afterInsert == 'old') { echo($div_old); } ?>
            <div class="wrapper">
                <form class="form-horizontal" id="action" action="ganti_password.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Password Lama</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <input type="password" class="form-control" name="pw_old" placeholder="Masukkan Password lama Anda" required="" maxlength="15" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Password Baru</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <input type="password" class="form-control pass" name="pw" placeholder="Maksimal 15 karakter" required="" maxlength="15" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Pastikan Password</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <input type="password" class="form-control pass" name="pw_cek" placeholder="Pastikan sama dengan password di atas" required="" maxlength="15" />
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button class="btn btn-lg btn-primary" type="submit" name="simpan" style="float:left;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
<?php   include('includes/footer.php'); ?>
