<?php   include('core/core.php'); ?>
<?php   include('includes/session.php'); ?>
<?php   if(count($sess) == 0) header('location:index.php'); ?>
<?php   include('olah.php'); ?>

<?php   include('includes/header.php'); ?>
    <main>
        <div class="container">
            <h1>PROVINSI</h1>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h3 class="title">Edit Provinsi</h3>
                    <form class="form-horizontal" id="action_edit" action="#" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" class="form-control" id="id" class="id" name="id" required="" readonly />
                            <div class="form-group">
                                <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Nama</label>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" class="form-control" id="nama" class="nama" name="nama" required="" autofocus="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Endemik</label>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="switch">
                                        <input type="checkbox" id="endemik" class="endemik" name="endemik">
                                        <span class="slider round"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-lg btn-primary" type="submit" name="submit">Simpan</button>
                        </div>
                    </form>

                    <!-- <input type="hidden" id="diagnosa_id" name="diagnosa">
                    <input type="radio" value="1" class="clickable" name="hasil" checked><span class="clickable"> Positif </span>
                    <input type="radio" value="0" class="clickable" name="hasil"><span class="clickable"> Negatif </span>
                    <div style="padding:20px 0px;margin:15px 0px;">
                        <button class="btn btn-primary">Simpan Hasil Tes</button>
                    </div> -->
                </div>
            </div>
            <div class="wrapper">
                <form class="form-horizontal" id="action" action="#" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Nama</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <input type="text" class="form-control" class="nama" name="nama" placeholder="Nama Provinsi" required="" autofocus="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Endemik</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <div class="switch">
                                    <input type="checkbox" class="endemik" name="endemik" value="0">
                                    <span class="slider round"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-lg btn-primary" type="submit" name="submit">Simpan</button>
                    </div>
                </form>
            </div>
            <h1>DAFTAR PROVINSI</h1>
            <div class="wrapper">
                <table class="table table-hover" id="maintable" border="0" style="display:table; width:100%;">
                    <thead>
                        <tr class="info">
                            <td>ID</td>
                            <td>Provinsi</td>
                            <td>Endemik</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody id="body">
                        <tr id="row" class="looptemplate danger">
                            <td class="id"></td>
                            <td class="nama"></td>
                            <td class="endemik"></td>
                            <td class="action"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
<?php   include('includes/footer.php'); ?>
