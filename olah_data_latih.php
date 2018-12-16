<?php   include('core/core.php'); ?>
<?php   include('olah.php'); ?>
<?php
        if(isset($_GET["read"])) {
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
        } else if(isset($_GET["write"])) {
            $content = $_POST['ser'];
            // print_r($content); die();
            $jk = $content['jk'];
            $usia = getValue($content['usia']);
            $domisili = getValue($content['domisili']);
            $malaise = getValueBoolean(@$content['malaise']);
            $sakit_kepala = getValueBoolean(@$content['sakit_kepala']);
            $batuk = getValueBoolean(@$content['batuk']);
            $diare = getValueBoolean(@$content['diare']);
            $nyeri_otot = getValueBoolean(@$content['nyeri_otot']);
            $mual = getValueBoolean(@$content['mual']);
            $menggigil = getValueBoolean(@$content['menggigil']);
            $endemik = getValueBoolean(@$content['endemik']);
            $demam = getValueBoolean(@$content['demam']);
            $hasil = getValue($content['hasil']);
            // $result = new \stdClass();
            // $result->JenisKelamin = $jk;
            // $result->Usia = $usia;
            // $result->Domisili = $domisili;
            // $result->Malaise = $malaise;
            // $result->SakitKepala = $sakit_kepala;
            // $result->Batuk = $batuk;
            // $result->Diare = $diare;
            // $result->NyeriOtot = $nyeri_otot;
            // $result->Mual = $mual;
            // $result->Menggigil = $menggigil;
            // $result->Endemik = $endemik;
            // $result->TriasMalaria = $demam;
            // $result->Hasil = $hasil;
            // $data->Data = $result;

            if($_GET["write"] == "new") {
                $query = "INSERT INTO data_latih VALUES (NULL, '$jk', '$usia', '$domisili', '$malaise', '$sakit_kepala', '$batuk', '$diare', '$nyeri_otot', '$mual', '$menggigil', '$endemik', '$demam', '$hasil')";
            } else {
                $id = $_GET["write"];
                $query = "UPDATE data_latih SET jenis_kelamin='$jk', usia='$usia', domisili='$domisili', malaise='$malaise', sakit_kepala='$sakit_kepala', batuk='$batuk', diare='$diare', nyeri_otot='$nyeri_otot', mual='$mual', menggigil='$menggigil', endemik='$endemik', demam='$demam', hasil='$hasil' WHERE id='$id'";
            }
            // print_r($query); die();
            mysqli_query($connection, $query);
        } else if(isset($_GET["delete"])) {
            $id = $_GET["delete"];
            $query = "DELETE FROM data_latih WHERE id='$id'";
            mysqli_query($connection, $query);
        }
        $data = json_encode($data, true);
        print_r($data);
?>
