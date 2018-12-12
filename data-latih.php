<?php   include('core/core.php'); ?>
<?php   include('includes/session.php'); ?>
<?php   if(count($sess) == 0) header('location:index.php'); ?>
<?php   include('olah.php'); ?>

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

<?php   include('includes/header.php'); ?>
    <main>
        <div class="container">
            <h1>DATA LATIH</h1>
            <div class="wrapper">
                <form class="form-horizontal" id="action" action="#" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Jenis Kelamin</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 radio-group">
                                <input type="radio" value="L" name="jk" class="def_radio" checked /> <span>Laki-laki</span>
                                <input type="radio" value="P" name="jk" /> <span>Perempuan</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Usia</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <input type="number" class="form-control tb" min="0" step="1" id="usia" name="usia" placeholder="Usia" required="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Tempat Tinggal</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <select class="form-control tb" name="domisili" required="">
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
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label"><i>Malaise</i></label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <div class="switch">
                                    <input type="checkbox" name="malaise" value="1">
                                    <span class="slider round"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Sakit Kepala</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <div class="switch">
                                    <input type="checkbox" name="sakit_kepala" value="1">
                                    <span class="slider round"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Batuk</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <div class="switch">
                                    <input type="checkbox" name="batuk" value="1">
                                    <span class="slider round"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Diare</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <div class="switch">
                                    <input type="checkbox" name="diare" value="1">
                                    <span class="slider round"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Nyeri Otot</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <div class="switch">
                                    <input type="checkbox" name="nyeri_otot" value="1">
                                    <span class="slider round"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Mual / muntah</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <div class="switch">
                                    <input type="checkbox" name="mual" value="1">
                                    <span class="slider round"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Menggigil</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <div class="switch">
                                    <input type="checkbox" name="menggigil" value="1">
                                    <span class="slider round"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Pernah berada di daerah endemik</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <div class="switch">
                                    <input type="checkbox" name="endemik" value="1">
                                    <span class="slider round"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Mengalami <i>Trias Malaria</i></label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <div class="switch">
                                    <input type="checkbox" name="demam" value="1">
                                    <span class="slider round"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Hasil Lab</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <select class="form-control def" name="hasil">
                                    <option value="0" class="def_select">Negatif</option>
                                    <option value="1">Positif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div> -->
                        <button class="btn btn-lg btn-primary" type="submit" name="submit">Simpan</button>
                    </div>
                </form>
            </div>
            <h1>DAFTAR DATA LATIH</h1>
            <div class="wrapper">
                <table class="table table-hover" id="maintable" border="0" style="display:table; width:100%;">
                    <thead>
                        <tr class="info">
                            <!-- <td>No</td> -->
                            <td>Kelamin</td>
                            <td>Usia</td>
                            <td>Domisili</td>
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
                        <tr id="row" class="looptemplate danger">
                            <!-- <td class="no"></td> -->
                            <td class="jk"></td>
                            <td class="usia"></td>
                            <td class="domisili"></td>
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
        </div>
    </main>
<?php   include('includes/footer.php'); ?>
