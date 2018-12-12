<?php   include('core/core.php'); ?>
<?php   include('includes/session.php'); ?>
<?php   if(count($sess) == 0) header('location:index.php'); ?>

<?php
        $prov = "SELECT provinsi.id, provinsi.nama FROM provinsi";
        $select = mysqli_query($connection, $prov);
?>

<?php   include('includes/header.php'); ?>
    <main>
        <div class="container">
            <h1>PUSPITAMARIN</h1>
            <div class="wrapper">
                <form class="form-horizontal" id="action" action="#" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-5">Nama</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 content-span">
                                <input type="hidden" class="form-control" name="id" value="<?php echo $sess['id']; ?>" />
                                <span><?php echo $sess['nama']; ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-5">Jenis Kelamin</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 content-span">
                                <input type="hidden" class="form-control" name="jk" value="<?php echo $sess['jenis_kelamin']; ?>" />
<?php   $jk = $sess['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
                                <span><?php echo $jk; ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-5">Tempat, Tanggal Lahir</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 content-span">
                                <input type="hidden" class="form-control" name="daerah[]" value="<?php echo $sess['tmpt_lahir_id']; ?>" />
                                <input type="hidden" class="form-control" name="tgl_lahir" value="<?php echo $sess['tgl_lahir']; ?>" />
<?php   $tgl_lahir = $sess['tgl_lahir']; ?>
<?php   $birth = new DateTime($tgl_lahir); ?>
<?php   $today = new DateTime('today'); ?>
<?php   $usia = $birth->diff($today)->y; ?>
<?php   $dob = date('j M Y', strtotime($tgl_lahir)); ?>
                                <input type="hidden" class="form-control" name="usia" value="<?php echo $usia; ?>" />
                                <span><?php echo $sess['tmpt_lahir'].", $dob ($usia tahun)"; ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-5">Tempat Tinggal</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 content-span">
                                <input type="hidden" class="form-control" name="domisili" value="<?php echo $sess['domisili_id']; ?>" />
                                <input type="hidden" class="form-control" name="daerah[]" value="<?php echo $sess['domisili_id']; ?>" />
                                <span><?php echo $sess['domisili']; ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Histori Perjalanan</label>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                Apakah anda pernah berpergian dalam kurun 3-6 bulan terakhir ?
                            </div>

                            <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
                            <div class="col-md-12 col-sm-12 col-xs-12" style="height:44px;margin-bottom:0px">
                                <div class="row clickable">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="checkbox" class="clickable" name="Now" id="Now" />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group-travel-history hidden">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                Jika ya, kemana?
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <select class="form-control" id="perjalanan" name="daerah[]" multiple="multiple">
<?php   if(mysqli_num_rows($select) > 0) { ?>
<?php       while($row = mysqli_fetch_array($select)) { ?>
                                    <option value="<?php echo $row['id']?>"><?php echo $row['nama']; ?></option>
<?php       } ?>
<?php   } ?>
                                </select>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-5">Apakah Anda mengalami</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <ul class="form-list">
                                    <li>
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                            <span class="slider-text"><i>Malaise</i></span>
                                        </div>
                                        <div class="switch">
                                            <input type="checkbox" name="malaise" value="1">
                                            <span class="slider round"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                            <span class="slider-text">Sakit kepala</span>
                                        </div>
                                        <div class="switch">
                                            <input type="checkbox" name="sakit_kepala" value="1">
                                            <span class="slider round"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                            <span class="slider-text">Batuk</span>
                                        </div>
                                        <div class="switch">
                                            <input type="checkbox" name="batuk" value="1">
                                            <span class="slider round"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                            <span class="slider-text">Diare</span>
                                        </div>
                                        <div class="switch">
                                            <input type="checkbox" name="diare" value="1">
                                            <span class="slider round"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                            <span class="slider-text">Nyeri otot</span>
                                        </div>
                                        <div class="switch">
                                            <input type="checkbox" name="nyeri_otot" value="1">
                                            <span class="slider round"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                            <span class="slider-text">Mual / muntah</span>
                                        </div>
                                        <div class="switch">
                                            <input type="checkbox" name="mual" value="1">
                                            <span class="slider round"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                            <span class="slider-text">Menggigil</span>
                                        </div>
                                        <div class="switch">
                                            <input type="checkbox" name="menggigil" value="1">
                                            <span class="slider round"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                            <span class="slider-text"><i>Trias Malaria</i></span>
                                        </div>
                                        <div class="switch">
                                            <input type="checkbox" name="demam" value="1">
                                            <span class="slider round"></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div style="padding:25px; margin:20px; border:15px; float:right;">
                    <!-- <div class="modal-footer"> -->
                        <!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div> -->
                        <!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> -->
                            <button type="submit" class="btn btn-primary btn-lg">
                                <span class="fa fa-stethoscope"></span> Lihat Hasil
                            </button>
                        <!-- </div> -->
                    <!-- </div> -->
                    </div>
                </form>
            </div>
            <!-- <div class="wrapper" id="result">
                <div id="row" class="form-group looptemplate hidden">
                    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 kiri"></label>
                    <label class="col-lg-9 col-md-9 col-sm-9 col-xs-9 kanan"></label>
                </div>
            </div>
            <div class="wrapper" id="conclusion">
                <p id="final"></p>
            </div> -->
        </div>
    </main>
<?php   include('includes/footer.php'); ?>
