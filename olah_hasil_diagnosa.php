<?php   include('core/core.php'); ?>
<?php   include('olah.php'); ?>
<?php
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            // print_r($id);
            $header =
                "SELECT d.id AS 'id', d.waktu AS 'waktu', d.pengguna AS 'nama_id', p.nama AS 'nama', p.jenis_kelamin AS 'jk', d.usia AS 'usia', d.domisili AS 'domisili_id', t.nama AS 'domisili',
                        d.malaise, d.sakit_kepala, d.batuk, d.diare, d.nyeri_otot, d.mual, d.menggigil, d.endemik, d.demam, d.hasil_diagnosa, d.hasil
                 FROM   diagnosa d, pengguna p, provinsi t
                 WHERE  d.pengguna = p.id AND d.domisili = t.id AND d.id = '$id'";
            $detail = "SELECT t.atribut, t.value FROM diagnosa d, diagnosa_detail t WHERE d.id = t.diagnosa AND d.id = '$id'";
            // print_r($header);
            $query_header = mysqli_query($connection, $header);
            $query_detail = mysqli_query($connection, $detail);
            if(mysqli_num_rows($query_header) > 0) {
                $row = mysqli_fetch_array($query_header);
                foreach($row as $key=>$value) {
                    if(is_numeric($key)) {
                        unset($row[$key]);
                    }
                }
                $data->Header = $row;
            }
            $arr = array();
            if(mysqli_num_rows($query_detail) > 0) {
                while($row = mysqli_fetch_array($query_detail)) {
                    $cont = array();
                    // print_r($row);
                    $cont['name'] = $row['atribut'];
                    $cont['value'] = $row['value'];
                    array_push($arr, $cont);
                }
            }
            $data->Data = $arr;
        }
        $data = json_encode($data, true);
        print_r($data);
?>
