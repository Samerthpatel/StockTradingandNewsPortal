<?php
	session_start();

	session_destroy();
	header('location:index.php');
	error_reporting(E_ALL);
	ini_set('display_errors', '0ff');
	ini_set('log_errors', 'On');
	ini_set('error_log',"/home/parallels/Desktop/it490project/website/my-errors.log");

?>