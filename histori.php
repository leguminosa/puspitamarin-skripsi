<?php   include('core/core.php'); ?>
<?php   include('includes/session.php'); ?>
<?php   if(count($sess) == 0) header('location:index.php'); ?>

<?php   include('includes/header.php'); ?>
    <main>
        <div class="container">
            <h1>HISTORI DIAGNOSA</h1>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <p class="identity">Welcome, <?php echo $sess["nama"]; ?></p>
                    <p>Jadi..apa hasil tes anda?</p>
                    <input type="hidden" id="diagnosa_id" name="diagnosa">
                    <input type="radio" value="1" class="clickable" name="hasil" checked><span class="clickable"> Positif </span>
                    <input type="radio" value="0" class="clickable" name="hasil"><span class="clickable"> Negatif </span>
                    <div style="padding:20px 0px;margin:15px 0px;">
                        <button class="btn btn-primary">Simpan Hasil Tes</button>
                    </div>
                </div>
            </div>
            <div class="wrapper">
                <table class="table table-hover" id="maintable" border="0" style="display:table; width:100%;">
                    <thead>
                        <tr class="info">
                            <td>Waktu</td>
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
                            <td class="usia"></td>
                            <td class="domisili"></td>
                            <td class="hasil_diagnosa"></td>
                            <td class="hasil"></td>
                            <td class="action">
                                <!-- <a class="clickable">
                                    <span class="fa fa-edit edit"> Detail</span>
                                </a> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
<?php   include('includes/footer.php'); ?>
