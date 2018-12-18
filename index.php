<?php   include('core/core.php'); ?>
<?php   include('includes/session.php'); ?>
<?php   // phpinfo(); ?>
<?php   //print_r(count($_SESSION)); ?>

<?php
        $pending = "SELECT d.*, p.nama, p.jenis_kelamin, v.nama AS 'domisili_nama' FROM diagnosa d JOIN pengguna p ON d.pengguna = p.id JOIN provinsi v ON d.domisili = v.id WHERE hasil IS NOT NULL AND ref IS NULL ORDER BY d.waktu DESC";
        $query = mysqli_query($connection, $pending);
        $waiting = array();
        if(mysqli_num_rows($query) > 0) {
            while($row = mysqli_fetch_array($query)) {
                $temp = array();
                $temp['id'] = $row['id'];
                $temp['pengguna_id'] = $row['pengguna'];
                $temp['pengguna'] = $row['nama'];
                $temp['usia'] = $row['usia'];
                $temp['jenis_kelamin'] = $row['jenis_kelamin'];
                $temp['waktu'] = $row['waktu'];
                $temp['domisili_id'] = $row['domisili'];
                $temp['domisili'] = $row['domisili_nama'];
                $temp['hasil_diagnosa'] = $row['hasil_diagnosa'];
                $temp['hasil'] = $row['hasil'];
                array_push($waiting, $temp);
            }
        }
        $pengunjung_q = "SELECT COUNT(DISTINCT(pengguna)) AS 'pengguna', COUNT(*) AS 'diagnosa' FROM diagnosa d JOIN pengguna p ON d.pengguna = p.id JOIN provinsi v ON d.domisili = v.id WHERE waktu > NOW() - INTERVAL 7 DAY";
        $q2 = mysqli_query($connection, $pengunjung_q);
        $pengunjung = 0; $diagnosa = 0;
        if(mysqli_num_rows($q2) > 0) {
            $row = mysqli_fetch_array($q2);
            $pengunjung = $row['pengguna'];
            $diagnosa = $row['diagnosa'];
        }
?>

<?php   include('includes/header.php'); ?>
    <main>
        <div class="container">
            <h1>PUSPITAMARIN</h1>

            <!-- Tab links -->
            <div class="tab">
                <button class="tablinks home active">Home</button>
<?php   if($sess && $sess['role'] == 'admin') { ?>
                <button class="tablinks diagnosa">Hasil Diagnosa Pengguna</button>
<?php   } else { ?>
                <button class="tablinks tab2">Other(2)</button>
<?php   } ?>
                <button class="tablinks tab3">Other(3)</button>
                <button class="tablinks tab4">Other(4)</button>
            </div>

            <!-- Tab content -->
            <div id="home" class="tabcontent" style="display:block">
<?php   if($sess && $sess['role'] == 'admin') { ?>
                <h3>Pemberitahuan</h3>
<?php       if(count($waiting) > 0) { ?>
                <p>Terdapat pembaharuan dalam histori diagnosa</p>
                <p>
                    Terdapat <?php echo count($waiting); ?> diagnosa yang telah mendapatkan hasil tes lab.
                    <a class="clickable" onclick="openCity(event, 'diagnosa', 'tablinks diagnosa')">Lihat disini</a>
                </p>
<?php       } else { ?>
                <p>Tidak ada pemberitahuan</p>
<?php       } ?>
                <h3>Pengunjung</h3>
                <p>Terdapat <?php echo $diagnosa; ?> diagnosa dari total <?php echo $pengunjung; ?> pengunjung yang terjadi dalam satu minggu terakhir.</p>
<?php   } else { ?>
                <h3>London</h3>
                <p>London is the capital city of England.</p>
<?php   } ?>
            </div>

<?php   if($sess && $sess['role'] == 'admin') { ?>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h3 class="title">Detail Diagnosa</h3>
                    <!-- <form class="form-horizontal" id="action_detail" action="#" method="POST" enctype="multipart/form-data"> -->
                        <div class="modal-body">
                            <input type="hidden" class="form-control" id="id" class="id" name="id" required="" readonly />
                            <div class="form-group">
                                <label class="col-lg-5 col-md-5 col-sm-5 col-xs-5">Tanggal Diagnosa</label>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 content-span">
                                    <span id="timestamps"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-5 col-md-5 col-sm-5 col-xs-5">Nama</label>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 content-span">
                                    <span id="nama"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-5 col-md-5 col-sm-5 col-xs-5">Jenis Kelamin</label>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 content-span">
                                    <span id="jk"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-5 col-md-5 col-sm-5 col-xs-5">Usia</label>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 content-span">
                                    <span id="usia"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-5 col-md-5 col-sm-5 col-xs-5">Tempat Tinggal</label>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 content-span">
                                    <span id="domisili"></span>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="modal-footer">
                            <button class="btn btn-lg btn-primary" type="submit" name="submit">Simpan</button>
                        </div> -->
                    <!-- </form> -->
                    <table class="table table-hover" id="maintable_modal" border="0" style="display:table; width:100%;">
                        <thead>
                            <tr class="info">
                                <!-- <td>No</td> -->
                                <!-- <td>Kelamin</td> -->
                                <!-- <td>Usia</td> -->
                                <td><i>Malaise</i></td>
                                <td>Sakit kepala</td>
                                <td>Batuk</td>
                                <td>Diare</td>
                                <td>Nyeri otot</td>
                                <td>Mual</td>
                                <td>Menggigil</td>
                                <td>Endemik</td>
                                <td>Demam</td>
                                <td>Hasil</td>
                                <td>Hasil Tes</td>
                            </tr>
                        </thead>
                        <tbody id="body_modal">
                            <tr id="row_modal" class="looptemplate hidden danger">
                                <!-- <td class="no"></td> -->
                                <!-- <td class="jk"></td> -->
                                <!-- <td class="usia"></td> -->
                                <td class="malaise"></td>
                                <td class="sakit_kepala"></td>
                                <td class="batuk"></td>
                                <td class="diare"></td>
                                <td class="nyeri_otot"></td>
                                <td class="mual"></td>
                                <td class="menggigil"></td>
                                <td class="endemik"></td>
                                <td class="demam"></td>
                                <td class="hasil"></td>
                                <td class="hasil_tes"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="wrapper" id="result-body">
                        <div id="line-result" class="form-group looptemplate hidden">
                            <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 kiri"></label>
                            <label class="col-lg-9 col-md-9 col-sm-9 col-xs-9 kanan"></label>
                        </div>
                    </div>
                    <div class="wrapper" id="conclusion">
                        <p id="final"></p>
                    </div>
                    <!-- <div style="padding:25px; margin:20px; border:15px; float:right;"> -->
                        <button class="btn btn-lg btn-primary" id="push">
                            <span class="fa fa-history"></span> Tambahkan ke data latih
                        </button>
                    <!-- </div> -->
                </div>
            </div>
            <div id="diagnosa" class="tabcontent">
                <h3>Diagnosa</h3>
                <p>Daftar diagnosa yang telah mendapat tes lab. Dapat segera ditambahkan ke data latih.</p>
                <div class="wrapper">
                    <table class="table table-hover" id="maintable" border="0" style="display:table; width:100%;">
                        <thead>
                            <tr class="info">
                                <td>Waktu</td>
                                <td>Nama</td>
                                <td style="width:100px;">Usia</td>
                                <td>Domisili</td>
                                <td style="width:150px;">Hasil Diagnosa</td>
                                <td>Hasil Tes</td>
                                <td style="width:125px;">Action</td>
                            </tr>
                        </thead>
                        <tbody id="body">
                            <tr id="row" class="looptemplate danger">
                                <td class="waktu"></td>
                                <td class="nama"></td>
                                <td class="usia"></td>
                                <td class="domisili"></td>
                                <td class="hasil_diagnosa"></td>
                                <td class="hasil"></td>
                                <td class="action">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h3>Diagnosa yang telah ditambahkan ke data latih</h3>
                <p>Data diagnosa yang telah ditambahkan ke dalam data latih</p>
                <div class="wrapper">
                    <table class="table table-hover" id="maintable_added" border="0" style="display:table; width:100%;">
                        <thead>
                            <tr class="info">
                                <td>Waktu</td>
                                <td>Nama</td>
                                <td style="width:100px;">Usia</td>
                                <td>Domisili</td>
                                <td style="width:150px;">Hasil Diagnosa</td>
                                <td>Hasil Tes</td>
                                <!-- <td style="width:125px;">Action</td> -->
                            </tr>
                        </thead>
                        <tbody id="body_added">
                            <tr id="row_added" class="looptemplate danger">
                                <td class="waktu"></td>
                                <td class="nama"></td>
                                <td class="usia"></td>
                                <td class="domisili"></td>
                                <td class="hasil_diagnosa"></td>
                                <td class="hasil"></td>
                                <!-- <td class="action"> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
<?php  } else { ?>
            <div id="tab2" class="tabcontent">
                <h3>Paris</h3>
                <p>Paris is the capital of French.</p>
            </div>
<?php  } ?>

            <div id="tab3" class="tabcontent">
                <h3>Tokyo</h3>
                <p>Tokyo is the capital of Japan.</p>
            </div>

            <div id="tab4" class="tabcontent">
                <h3>Munich</h3>
                <p>Munich is the capital of Germany.</p>
            </div>

        </div>
    </main>
<?php   include('includes/footer.php'); ?>
