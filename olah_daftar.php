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

            $insert = "INSERT INTO pengguna VALUES (NULL, '$nama', '$jk', '$tmpt_lahir', '$tgl_lahir', '$domisili', '$usr', '$pw', 'user')";
            mysqli_query($connection, $insert);
        }
        $data = json_encode($data, true);
        print_r($data);
?>
