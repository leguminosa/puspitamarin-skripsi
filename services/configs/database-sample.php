<?php

    /* at the top of 'config.php' which you want to prevent direct access from*/
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
        /*
           Up to you which header to send, some prefer 404 even if
           the files does exist for security
        */
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );

        /* choose the appropriate page to redirect users */
        die( header( 'location: ../index.php' ) );

    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "malaria";

    $connection = mysqli_connect($servername, $username, $password, $dbname);
    if(!$connection){
        die("Connection Failed:" .mysqli_connect_error());
    }

?>
