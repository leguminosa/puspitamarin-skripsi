<?php   include('core/core.php'); ?>
<?php   include('olah.php'); ?>
<?php
        if(isset($_POST['ser'])) {
            $post = $_POST['ser'];
            // print_r($post);
            $jk = $post['jk'];
            $usia = getValue($post['usia']);
            $domisili = getValue($post['domisili']);
            $malaise = getValue(@$post['malaise']);
            $sakit_kepala = getValue(@$post['sakit_kepala']);
            $batuk = getValue(@$post['batuk']);
            $diare = getValue(@$post['diare']);
            $nyeri_otot = getValue(@$post['nyeri_otot']);
            $mual = getValue(@$post['mual']);
            $menggigil = getValue(@$post['menggigil']);
            $endemik = getValue(@$post['endemik']);
            $demam = getValue(@$post['demam']);
            $hasil = getValue($post['hasil']);
            $result = new \stdClass();
            $result->JenisKelamin = $jk;
            $result->Usia = $usia;
            $result->Domisili = $domisili;
            $result->Malaise = $malaise;
            $result->SakitKepala = $sakit_kepala;
            $result->Batuk = $batuk;
            $result->Diare = $diare;
            $result->NyeriOtot = $nyeri_otot;
            $result->Mual = $mual;
            $result->Menggigil = $menggigil;
            $result->Endemik = $endemik;
            $result->TriasMalaria = $demam;
            $result->Hasil = $hasil;

            $data->Data = $result;

            $insert = "INSERT INTO data_latih VALUES (NULL, '$jk', '$usia', '$domisili', '$malaise', '$sakit_kepala', '$batuk', '$diare', '$nyeri_otot', '$mual', '$menggigil', '$endemik', '$demam', '$hasil')";
            mysqli_query($connection, $insert);
            // header("location:data-latih.php");
        }
        if(isset($_GET["get"])) {
            $select = "SELECT data_latih.*, provinsi.nama FROM data_latih, provinsi WHERE data_latih.domisili = provinsi.id";
            $get = mysqli_query($connection, $select);
            $result = array();
            if(mysqli_num_rows($get) > 0) {
                while($row = mysqli_fetch_array($get)) {
                    $content = array();
                    $content['id'] = $row['id'];
                    $content['jenis_kelamin'] = $row['jenis_kelamin'];
                    $content['usia'] = $row['usia'];
                    $content['domisili_id'] = $row['domisili'];
                    $content['domisili'] = $row['nama'];
                    $content['malaise'] = $row['malaise'];
                    $content['sakit_kepala'] = $row['sakit_kepala'];
                    $content['batuk'] = $row['batuk'];
                    $content['diare'] = $row['diare'];
                    $content['nyeri_otot'] = $row['nyeri_otot'];
                    $content['mual'] = $row['mual'];
                    $content['menggigil'] = $row['menggigil'];
                    $content['endemik'] = $row['endemik'];
                    $content['demam'] = $row['demam'];
                    $content['hasil'] = $row['hasil'];
                    array_push($result, $content);
                };
                $data->Data = $result;
            }
        }
        $data = json_encode($data, true);
        print_r($data);
?>
