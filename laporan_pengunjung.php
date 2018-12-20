<?php   include('core/core.php'); ?>
<?php   include('includes/session.php'); ?>
<?php   if(count($sess) == 0) header('location:index.php'); ?>

<?php
        $a = "SELECT p.id, p.nama AS 'Nama', d.usia AS 'Usia', v.nama AS 'Domisili', CASE WHEN p.jenis_kelamin = 'L' THEN 'Laki-laki' ELSE 'Perempuan' END AS 'JenisKelamin', COUNT(*) AS 'JumlahDiagnosa'
        FROM diagnosa AS d JOIN pengguna AS p ON d.pengguna = p.id JOIN provinsi AS v ON p.domisili = v.id
        WHERE d.waktu > NOW() - INTERVAL 7 DAY
        GROUP BY p.id, p.nama, d.usia";
        $q_a = mysqli_query($connection, $a);
        $data = array();
        if(mysqli_num_rows($q_a) > 0) {
            while($row = mysqli_fetch_array($q_a)) {
                $temp = array();
                $id = $row['id'];
                $temp['Nama'] = $row['Nama'];
                $temp['Usia'] = $row['Usia'];
                $temp['JenisKelamin'] = $row['JenisKelamin'];
                $temp['Domisili'] = $row['Domisili'];
                $temp['JumlahDiagnosa'] = $row['JumlahDiagnosa'];
                $b = "SELECT d.waktu, CASE WHEN d.endemik = 1 THEN 'Ya' ELSE 'Tidak' END AS 'Endemik', CASE WHEN d.hasil_diagnosa = 1 THEN 'Positif' ELSE 'Negatif' END AS 'Hasil',
                -- d.malaise, d.sakit_kepala, d.batuk, d.diare, d.nyeri_otot, d.mual, d.menggigil, d.demam
                (d.malaise + d.sakit_kepala + d.batuk + d.diare + d.nyeri_otot + d.mual + d.menggigil + d.demam) AS 'JumlahGejala'
                FROM diagnosa AS d WHERE d.pengguna = '$id' ORDER BY d.waktu DESC LIMIT 1";
                $q_b = mysqli_query($connection, $b);
                if(mysqli_num_rows($q_b) > 0) {
                    while($rowb = mysqli_fetch_array($q_b)) {
                        $temp['TesTerakhir'] = $rowb['waktu'];
                        $temp['Endemik'] = $rowb['Endemik'];
                        $temp['JumlahGejala'] = $rowb['JumlahGejala'];
                        $temp['Hasil'] = $rowb['Hasil'];
                    }
                }
                array_push($data, $temp);
            }
        }
        // print_r($data); die();
?>
<?php   include('includes/header.php'); ?>
    <main>
        <div class="container-fluid">
            <h1>LAPORAN PENGUNJUNG</h1>
            <div class="wrapper">
                <table class="table table-hover" id="maintable" border="0" style="display:table; width:100%;">
                    <thead>
                        <tr class="info">
                            <td rowspan="2">No</td>
                            <td rowspan="2">Nama</td>
                            <td rowspan="2">Jenis Kelamin</td>
                            <td rowspan="2">Usia</td>
                            <td rowspan="2">Domisili</td>
                            <td rowspan="2">Melakukan Diagnosa</td>
                            <td colspan="4" class="text-center">Diagnosa Terakhir</td>
                        </tr>
                        <tr class="info">
                            <td>Tanggal</td>
                            <td>Jumlah Gejala Dialami</td>
                            <td>Berada di Daerah Endemik</td>
                            <td>Hasil</td>
                        </tr>
                    </thead>
                    <tbody>
<?php   for($i = 0; $i < count($data); $i++) { ?>
<?php       $row = $data[$i]; ?>
                        <tr class="danger">
                            <td class="no"><?php echo $i+1; ?></td>
                            <td class="nama"><?php echo $row['Nama']; ?></td>
                            <td class="jk"><?php echo $row['JenisKelamin']; ?></td>
                            <td class="usia"><?php echo $row['Usia']; ?></td>
                            <td class="domisili"><?php echo $row['Domisili']; ?></td>
                            <td class="diagnosa"><?php echo $row['JumlahDiagnosa']; ?></td>
                            <td class="waktu"><?php echo $row['TesTerakhir']; ?></td>
                            <td class="gejala"><?php echo $row['JumlahGejala']; ?></td>
                            <td class="endemik"><?php echo $row['Endemik']; ?></td>
                            <td class="hasil"><?php echo $row['Hasil']; ?></td>
                        </tr>
<?php   } ?>
                    </tbody>
                </table>
            </div>
            <button type="button" class="btn btn-primary" onclick="window.print();" style="float:right;">CLICK HERE TO PRINT FORM</button>
        </div>
    </main>
<?php   include('includes/footer.php'); ?>
