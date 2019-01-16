<?php   include('core/core.php'); ?>
<?php   include('olah.php'); ?>
<?php
        if(isset($_GET['arg'])) {
            $arg = $_GET['arg'];
            if($arg == 1) {
                $a = "SELECT d.*, p.*, a.nama AS 'Domisili' FROM diagnosa d LEFT JOIN pengguna p ON p.id = d.pengguna LEFT JOIN provinsi a ON a.id = p.domisili WHERE d.hasil = d.hasil_diagnosa";
            } else if($arg == 2) {
                $a = "SELECT d.*, p.*, a.nama AS 'Domisili' FROM diagnosa d LEFT JOIN pengguna p ON p.id = d.pengguna LEFT JOIN provinsi a ON a.id = p.domisili";
            } else { // $arg == 0
                $a = "SELECT d.*, p.*, a.nama AS 'Domisili' FROM diagnosa d LEFT JOIN pengguna p ON p.id = d.pengguna LEFT JOIN provinsi a ON a.id = p.domisili WHERE d.hasil <> d.hasil_diagnosa";
            }
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
        }
        // print_r($data); die();
        $data = json_encode($data, true);
        print_r($data);
?>
