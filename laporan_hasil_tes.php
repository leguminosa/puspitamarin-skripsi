<?php   include('core/core.php'); ?>
<?php   include('includes/session.php'); ?>
<?php   if(count($sess) == 0) header('location:index.php'); ?>

<?php
        $a = "SELECT d.*, p.*, a.nama AS 'Domisili' FROM diagnosa d LEFT JOIN pengguna p ON p.id = d.pengguna LEFT JOIN provinsi a ON a.id = p.domisili WHERE d.hasil <> d.hasil_diagnosa";
        $q_a = mysqli_query($connection, $a);
        $data = array();
        if(mysqli_num_rows($q_a) > 0) {
            while($row = mysqli_fetch_array($q_a)) {
                $temp = array();
                // print_r(json_encode($row, true)); die();
                $id = $row['id'];
                $temp['Nama'] = $row['nama'];
                $temp['Usia'] = $row['usia'];
                $temp['JenisKelamin'] = $row['jenis_kelamin'] == 'P' ? 'Perempuan' : 'Laki-laki';
                $temp['Domisili'] = $row['Domisili'];
                // $temp['JumlahDiagnosa'] = $row['JumlahDiagnosa'];
                $temp['Hasil'] = $row['hasil'] == 0 ? 'Negatif' : 'Positif';
                $temp['HasilDiagnosa'] = $row['hasil_diagnosa'] == 0 ? 'Negatif' : 'Positif';
                array_push($data, $temp);
            }
        }
        // print_r($data); die();
?>
<?php   include('includes/header.php'); ?>
    <main>
        <div class="container-fluid">
            <select id="argument">
                <option value="2">Hasil tes (seluruh data)</option>
                <option value="1">Hasil tes yang sesuai</option>
                <option value="0">Hasil tes yang tidak sesuai</option>
            </select>
            <h1 id="title">LAPORAN HASIL TES </h1>
            <div class="wrapper">
                <table class="table table-hover" id="maintable" border="0" style="display:table; width:100%;">
                    <thead>
                        <tr class="info">
                            <td>No</td>
                            <td>Nama</td>
                            <td>Jenis Kelamin</td>
                            <td>Usia</td>
                            <td>Domisili</td>
                            <td>Hasil Uji Program</td>
                            <td>Hasil Tes Lab</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="row" class="danger hidden looptemplate">
                            <td class="no"></td>
                            <td class="nama"></td>
                            <td class="jk"></td>
                            <td class="usia"></td>
                            <td class="domisili"></td>
                            <td class="hasil"></td>
                            <td class="hasil_diagnosa"></td>
                        </tr>
<?php   for($i = 0; $i < 0; $i++) { ?>
<?php       $row = $data[$i]; ?>
                        <tr class="danger">
                            <td class="no"><?php echo $i+1; ?></td>
                            <td class="nama"><?php echo $row['Nama']; ?></td>
                            <td class="jk"><?php echo $row['JenisKelamin']; ?></td>
                            <td class="usia"><?php echo $row['Usia']; ?></td>
                            <td class="domisili"><?php echo $row['Domisili']; ?></td>
                            <td class="hasil"><?php echo $row['Hasil']; ?></td>
                            <td class="hasil_diagnosa"><?php echo $row['HasilDiagnosa']; ?></td>
                        </tr>
<?php   } ?>
                    </tbody>
                </table>
            </div>
            <button type="button" class="btn btn-primary" onclick="window.print();" style="float:right;">CLICK HERE TO PRINT FORM</button>
        </div>
    </main>
<?php   include('includes/footer.php'); ?>
