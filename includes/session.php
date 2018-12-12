<?php
	ob_start();
	session_start();
	// print_r($_SESSION);
	// if(!isset($_SESSION['user'])) header("location:".BASE_URI."login.php");

	$sess = array();
	if(isset($_SESSION["malaria"])) {
		$sess = $_SESSION["malaria"];
	}
?>
