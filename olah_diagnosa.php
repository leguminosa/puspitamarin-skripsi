<?php   include('core/core.php'); ?>
<?php   include('olah.php'); ?>
<?php
        if(isset($_POST['ser'])) {
            $post = $_POST['ser'];
            $id = $post['id'];
            $daerah = $post['daerah'];
            $daerah = implode($daerah, ',');
            $endemik = 0;
            $endemik_collection = "SELECT nama, endemik FROM provinsi WHERE id IN ($daerah)";
            $select = mysqli_query($connection, $endemik_collection);
            if(mysqli_num_rows($select) > 0) {
                while($row = mysqli_fetch_array($select)) {
                    $end = $row['endemik'];
                    if($end == 1) $endemik = 1;
                }
            }
            // $date2 = new DateTime('today');
            $date = date('Y-m-d H:i:s');
            $usia = getValue($post['usia']);
            $domisili = getValue($post['domisili']);
            $malaise = getValue(@$post['malaise']);
            $sakit_kepala = getValue(@$post['sakit_kepala']);
            $batuk = getValue(@$post['batuk']);
            $diare = getValue(@$post['diare']);
            $nyeri_otot = getValue(@$post['nyeri_otot']);
            $mual = getValue(@$post['mual']);
            $menggigil = getValue(@$post['menggigil']);
            $demam = getValue(@$post['demam']);

            $result = new \stdClass();
            // $result->Date2 = $date2;
            $result->Date = $date;
            $result->Usia = $usia;
            $result->Domisili = $domisili;
            $result2 = new \stdClass();
            $result2->malaise = $malaise;
            $result2->sakit_kepala = $sakit_kepala;
            $result2->batuk = $batuk;
            $result2->diare = $diare;
            $result2->nyeri_otot = $nyeri_otot;
            $result2->mual = $mual;
            $result2->menggigil = $menggigil;
            $result2->endemik = $endemik;
            $result2->demam = $demam;

            // $data->Data = $result;
            $data->Gejala = $result2;
            $insert = "INSERT INTO diagnosa VALUES (NULL, '$id', '$date', '$usia', '$domisili', '$malaise', '$sakit_kepala', '$batuk', '$diare', '$nyeri_otot', '$mual', '$menggigil', '$endemik', '$demam', NULL, NULL, NULL)";
            // print_r($insert);
            mysqli_query($connection, $insert);
            $diagnosa_id = mysqli_insert_id($connection);
            $data->ID = $diagnosa_id;
            // $data->ID = 1;

            $tes = "SELECT malaise, sakit_kepala, batuk, diare, nyeri_otot, mual, menggigil, endemik, demam, hasil FROM data_latih";
            // $tes = $tes." LIMIT 10";
            $b = array();
            $que = mysqli_query($connection, $tes);
            if(mysqli_num_rows($que) > 0) {
                while($row = mysqli_fetch_array($que)) {
                    $a = array();
                    foreach($row as $key=>$value) {
                        if(!is_numeric($key)) $a[$key] = $value;
                    }
                    array_push($b, $a);
                }
            }
            $data->Latih = $b;
        } else if(isset($_POST['optiondata'])) {
            $post = $_POST['optiondata'];
            $content = $post['data'];
            $diag = $post['result'];
            $id = $post['id'];
            $insert = "INSERT INTO diagnosa_detail VALUES";
            for($i = 0; $i < count($content); $i++) {
                $item = $content[$i];
                $name = $item['name'];
                $value = $item['value'];
                if($i > 0) $insert = $insert.",";
                $values = " (NULL, '$id', '$name', '$value')";
                $insert = $insert.$values;
            }
            mysqli_query($connection, $insert);
            $update = "UPDATE diagnosa SET hasil_diagnosa = '$diag' WHERE id='$id'";
            mysqli_query($connection, $update);

            // $data->Data = $content;
            // $data->Data = $insert;
            $data->ID = $id;
        }
        $data = json_encode($data, true);
        print_r($data);
?>
