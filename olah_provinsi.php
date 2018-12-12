<?php   include('core/core.php'); ?>
<?php   include('olah.php'); ?>
<?php
        if(isset($_GET["read"])) {
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
        } else if(isset($_GET["write"])) {
            $content = $_POST["ser"];
            $nama = $content["nama"];
            $endemik = isset($content["endemik"]) ? '1' : '0';
            if($_GET["write"] == "new") {
                $highest_id = mysqli_query($connection, "SELECT id FROM provinsi ORDER BY id DESC LIMIT 1");
                $row = mysqli_fetch_array($highest_id);
                $new_id = $row['id'] + 1;
                $query = "INSERT INTO provinsi VALUES ('$new_id', '$nama', '$endemik')";
            } else {
                $id = $_GET["write"];
                $query = "UPDATE provinsi SET nama='$nama', endemik='$endemik' WHERE id='$id'";
            }
            mysqli_query($connection, $query);
        } else if(isset($_GET["delete"])) {
            $id = $_GET["delete"];
            $query = "DELETE FROM provinsi WHERE id='$id'";
            mysqli_query($connection, $query);
        }
        $data = json_encode($data, true);
        print_r($data);
?>
