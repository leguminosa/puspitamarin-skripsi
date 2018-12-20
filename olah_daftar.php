<?php   include('core/core.php'); ?>
<?php   include('olah.php'); ?>
<?php
        if(isset($_POST['ser'])) {
            $postArray = $_POST['ser'];
            $post = array();
            foreach($postArray as $content) {
                $a = $content['name'];
                $b = $content['value'];
                $post[$a] = $b;
            }
            $nama = $post['nama'];
            $jk = $post['jk'];
            $tmpt_lahir = $post['tmpt_lahir'];
            $tgl_lahir = $post['tgl_lahir'];
            $domisili = $post['domisili'];
            $usr = $post['usr'];
            $pw = $post['pw'];

            $validasi = "SELECT COUNT(*) AS 'Jumlah' FROM pengguna WHERE username ='$usr'";
            $query = mysqli_query($connection, $validasi);
            if(mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_array($query);
                if($row['Jumlah'] > 0) {
                    $data->Status = 2;
                } else {
                    $insert = "INSERT INTO pengguna VALUES (NULL, '$nama', '$jk', '$tmpt_lahir', '$tgl_lahir', '$domisili', '$usr', '$pw', 'user')";
                    mysqli_query($connection, $insert);
                }
            }
        } else {
            $data->Status = 1;
        }
        $data = json_encode($data, true);
        print_r($data);
?>
