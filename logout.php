<?php
	session_start();

	// $_SESSION['usr'];
	// $_SESSION['nama'];
	// $_SESSION['tipe'];

	unset($_SESSION['malaria']);
	// unset($_SESSION['admin']);
	// unset($_SESSION['nama']);
	// unset($_SESSION['tipe']);

	session_unset();
	session_destroy();

	header('location:index.php');
?>
