<?php   include('core/core.php'); ?>
<?php   include('olah.php'); ?>
<?php
        if(isset($_GET['read'])) {
            if(($_GET['read']) == 'waiting') {
                $query = "SELECT d.*, p.nama, p.jenis_kelamin, v.nama AS 'domisili_nama' FROM diagnosa d JOIN pengguna p ON d.pengguna = p.id JOIN provinsi v ON d.domisili = v.id WHERE hasil IS NOT NULL AND ref IS NULL ORDER BY d.waktu DESC";
            } else if(($_GET['read']) == 'added') {
                $query = "SELECT d.*, p.nama, p.jenis_kelamin, v.nama AS 'domisili_nama' FROM diagnosa d JOIN pengguna p ON d.pengguna = p.id JOIN provinsi v ON d.domisili = v.id WHERE hasil IS NOT NULL AND ref IS NOT NULL ORDER BY d.waktu DESC";
            }
            $query = mysqli_query($connection, $query);
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
            $data->List = $waiting;
        } else if(isset($_GET['push'])) {
           $id = $_GET['push'];
           $header =
               "SELECT d.id AS 'id', d.waktu AS 'waktu', d.pengguna AS 'nama_id', p.nama AS 'nama', p.jenis_kelamin AS 'jk', d.usia AS 'usia', d.domisili AS 'domisili_id', t.nama AS 'domisili',
                       d.malaise, d.sakit_kepala, d.batuk, d.diare, d.nyeri_otot, d.mual, d.menggigil, d.endemik, d.demam, d.hasil_diagnosa, d.hasil
                FROM   diagnosa d, pengguna p, provinsi t
                WHERE  d.pengguna = p.id AND d.domisili = t.id AND d.id = '$id'";
           $query_header = mysqli_query($connection, $header);
           if(mysqli_num_rows($query_header) > 0) {
               $row = mysqli_fetch_array($query_header);
               $jk = $row['jk'];
               $usia = $row['usia'];
               $domisili = $row['domisili_id'];
               $malaise = $row['malaise'];
               $sakit_kepala = $row['sakit_kepala'];
               $batuk = $row['batuk'];
               $diare = $row['diare'];
               $nyeri_otot = $row['nyeri_otot'];
               $mual = $row['mual'];
               $menggigil = $row['menggigil'];
               $endemik = $row['endemik'];
               $demam = $row['demam'];
               $hasil = $row['hasil'];
               $query = "INSERT INTO data_latih VALUES (NULL, '$jk', '$usia', '$domisili', '$malaise', '$sakit_kepala', '$batuk', '$diare', '$nyeri_otot', '$mual', '$menggigil', '$endemik', '$demam', '$hasil')";
               mysqli_query($connection, $query);

               $datalatih_id = mysqli_insert_id($connection);
               $update_ref = "UPDATE diagnosa SET ref='$datalatih_id' WHERE id='$id'";
               mysqli_query($connection, $update_ref);
           } else {
               $data->Status = 1;
           }
       }
       $data = json_encode($data, true);
       print_r($data);
?>
