<?php   include('core/core.php'); ?>
<?php   include('includes/session.php'); ?>
<?php   if(count($sess) == 0) header('location:index.php'); ?>
<?php   //print_r($sess); ?>

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
<?php
        // print_r($_SESSION);
        if(isset($_SESSION['afterInsert'])) $afterInsert = $_SESSION['afterInsert'];
        else $afterInsert = false;
        if($afterInsert) $_SESSION['afterInsert'] = false;
        // var_dump(isset($_POST['simpan']));
        if(isset($_POST['simpan'])) {
            $simpan = $_POST;
            $id = $simpan['id'];
            $nama = $simpan['nama'];
            $domisili = $simpan['domisili'];
            $username = $simpan['username'];
            $update = "UPDATE pengguna SET nama='$nama', domisili='$domisili', username='$username' WHERE id='$id'";
            mysqli_query($connection, $update);

            // $inserted_id = mysqli_insert_id($connection);
            // print_r($inserted_id);
            $select = "SELECT pengguna.*, lahir.nama AS 'tmpt_lahir_nama', tinggal.nama AS 'domisili_nama' FROM pengguna, provinsi lahir, provinsi tinggal WHERE pengguna.tmpt_lahir = lahir.id AND pengguna.domisili = tinggal.id AND pengguna.id = '$id'";
            $query = mysqli_query($connection, $select);
            if(mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_array($query);
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
                $_SESSION['afterInsert'] = true;
                header('location:profil.php');
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
            <h1>SUNTING DATA DIRI</h1>
<?php
        $div = <<<EOD
        <div class="alert alert-success fade in alert-dismissible alert-php">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <strong><i>Update</i> sukses,</strong> Perubahan telah tersimpan.
        </div>
EOD;
?>
<?php   if($afterInsert) echo($div); ?>
            <div class="wrapper">
                <form class="form-horizontal" id="action" action="profil.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="id" value="<?php echo $sess['id']; ?>" />
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Nama</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <input type="text" class="form-control" name="nama" value="<?php echo $sess['nama']; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Jenis Kelamin<span style="color:red;">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <input type="hidden" class="form-control" name="jk" value="<?php echo $sess['jenis_kelamin']; ?>" />
<?php $jk = $sess['jenis_kelamin']; ?>
<?php $jk = $jk == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
                                <input type="text" class="form-control" value="<?php echo $jk; ?>" readonly="" />
                                <!-- <span><?php //echo $jk; ?></span> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Tempat, Tanggal Lahir<span style="color:red;">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <input type="hidden" class="form-control" name="tmpt_lahir" value="<?php echo $sess['tmpt_lahir_id']; ?>"/>
                                <input type="hidden" class="form-control" name="tgl_lahir" value="<?php echo $sess['tgl_lahir']; ?>"/>
<?php $tmpt_lahir = $sess['tmpt_lahir']; ?>
<?php $tgl_lahir = $sess['tgl_lahir']; ?>
<?php $format = 'j F Y'; ?>
<?php $tgl_lahir = date_toIndonesian($tgl_lahir, $format); ?>
<?php $dob = "$tmpt_lahir, $tgl_lahir"; ?>
                                <input type="text" class="form-control" value="<?php echo $dob; ?>" readonly="" />
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
<?php           $id = $item['id']; ?>
                                    <option value="<?php echo $id; ?>" <?php if($id == $sess['domisili_id']) { ?> selected <?php } ?>><?php echo $item['nama']?></option>
<?php       } ?>
<?php   } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Username<span style="color:red;">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <input type="text" class="form-control" name="username" placeholder="Maksimal 15 karakter" value="<?php echo $sess['username']; ?>" required="" maxlength="15" readonly=""/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span style="color:red;">*</span>Tidak bisa diubah lagi
                        <button class="btn btn-lg btn-primary" type="submit" name="simpan" style="float:left;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
<?php   include('includes/footer.php'); ?>
