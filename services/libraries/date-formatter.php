<?php

function date_toIndonesian($date_string, $format) {
    $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $mon_M = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    $month2 = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $mon_F = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $months_F = array();
    $months_M = array();
    for($i = 0; $i < count($month); $i++) {
        $months_F[$month2[$i]] = $mon_F[$i];
        $months_M[$month[$i]] = $mon_M[$i];
    }
    $months = array(
        'F' => $months_F,
        'M' => $months_M
    );
    $mon = date('M', strtotime($date_string));
    $M = strpos($format, 'M');
    $F = strpos($format, 'F');
    $m = array();
    $mon = array();
    // if($M !== false || $F !== false) {
        if($M !== false) {
            array_push($m, "M");
            array_push($mon, date('M', strtotime($date_string)));
        }
        if($F !== false) {
            array_push($m, "F");
            array_push($mon, date('F', strtotime($date_string)));
        }
    // }
    $pattern = '/M|F/';
    // $replacement = 'M';
    // $form = preg_replace($pattern, $replacement, $format);
    // $date = date($format, strtotime($date_string));
    $date = date($format, strtotime($date_string));
    for($i = 0; $i < count($m); $i++) {
        // $date = str_replace($mon,$months[$m[$i]][$mon],$date);
        $date = preg_replace("/\b$mon[$i]\b/",$months[$m[$i]][$mon[$i]],$date);
    }
    // $months = json_encode($months, true);
    // print_r($months);
    return $date;
}

?>
