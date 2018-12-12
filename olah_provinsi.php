<?php   include('core/core.php'); ?>
<?php   include('olah.php'); ?>
<?php
        if(isset($_GET["get"])) {
            $select = "SELECT provinsi.* FROM provinsi";
            $get = mysqli_query($connection, $select);
            $result = array();
            if(mysqli_num_rows($get) > 0) {
                while($row = mysqli_fetch_array($get)) {
                    $content = array();
                    $content['id'] = $row['id'];
                    $content['nama'] = $row['nama'];
                    $content['endemik'] = $row['endemik'];
                    array_push($result, $content);
                }
                $data->Data = $result;
            }
        }
        $data = json_encode($data, true);
        print_r($data);
?>
