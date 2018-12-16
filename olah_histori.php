<?php   include('core/core.php'); ?>
<?php   include('includes/session.php'); ?>
<?php   include('olah.php'); ?>
<?php
        if(isset($_GET['read'])) {
            $select = "SELECT d.*, p.nama, v.nama AS 'domisili_nama' FROM diagnosa d JOIN pengguna p ON d.pengguna = p.id JOIN provinsi v ON d.domisili = v.id";
            if($_GET['read'] == 'user') {
                $id = $sess['id'];
                $select .= " AND d.pengguna = '$id'";
            }
            $get = mysqli_query($connection, $select);
            $result = array();
            if(mysqli_num_rows($get) > 0) {
                while($row = mysqli_fetch_array($get)) {
                    $content = array();
                    $content['id'] = $row['id'];
                    $content['waktu'] = $row['waktu'];
                    $content['nama'] = $row['nama'];
                    $content['usia'] = $row['usia'];
                    $content['domisili'] = $row['domisili_nama'];
                    $content['hasil_diagnosa'] = $row['hasil_diagnosa'];
                    $content['hasil'] = $row['hasil'];
                    array_push($result, $content);
                }
                $data->Data = $result;
            }
        } else if(isset($_POST['ser'])) {
            $ser = $_POST['ser'];
            $hasil = $ser['hasil'];
            $id = $ser['id'];
            $update = "UPDATE diagnosa SET hasil = '$hasil' WHERE id = '$id'";
            mysqli_query($connection, $update);
            $data->Data = $ser;
        }
        $data = json_encode($data, true);
        print_r($data);
?>
