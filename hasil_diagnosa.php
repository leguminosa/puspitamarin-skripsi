<?php   include('core/core.php'); ?>
<?php   include('includes/session.php'); ?>
<?php   if(count($sess) == 0) header('location:index.php'); ?>

<?php   include('includes/header.php'); ?>
    <main>
        <div class="container">
            <h1>HASIL DIAGNOSA</h1>
            <div class="wrapper">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-lg-5 col-md-5 col-sm-5 col-xs-5">Tanggal Diagnosa</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 content-span">
                            <span id="timestamps"></span>
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
            </div>
            <div class="wrapper">
                <table class="table table-hover" id="maintable" border="0" style="display:table; width:100%;">
                    <thead>
                        <tr class="info">
                            <!-- <td>No</td> -->
                            <!-- <td>Kelamin</td> -->
                            <!-- <td>Usia</td> -->
                            <!-- <td>Domisili</td> -->
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
                        </tr>
                    </thead>
                    <tbody id="body">
                        <tr id="row" class="looptemplate hidden danger">
                            <!-- <td class="no"></td> -->
                            <!-- <td class="jk"></td> -->
                            <!-- <td class="usia"></td> -->
                            <!-- <td class="domisili"></td> -->
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
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="wrapper" id="result-body">
                <div id="line-result" class="form-group looptemplate hidden">
                    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 kiri"></label>
                    <label class="col-lg-9 col-md-9 col-sm-9 col-xs-9 kanan"></label>
                </div>
            </div>
            <div class="wrapper" id="conclusion">
                <p id="final"></p>
            </div>
            <div style="padding:25px; margin:20px; border:15px; float:right;">
                <!-- <button class="btn btn-lg btn-primary btn-rounded btn-addon btn-google m-b-sm">
                    <i class="fa fa-plus"></i> Lihat Histori
                </button> -->
                <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
                    <a href="histori.php" role="button" class="btn btn-lg btn-primary">
                        <span class="fa fa-history"></span> Lihat Histori
                    </a>
                <!-- </div> -->
            </div>
        </div>
    </main>
<?php   include('includes/footer.php'); ?>
