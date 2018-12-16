<?php
        $data = new \stdClass();
        $data->Status = 0;
        $data->Errors = array();
        $data->Message = "Success";
        $data->Data = array();

        function getValue($post) {
            if(!isset($post)) return 0;
            else return (int)$post;
        }
        function getValueBoolean($post) {
            if(!isset($post)) return 0;
            else return 1;
        }
?>
