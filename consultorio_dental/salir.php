<?php
	$idse=$_GET['ids'];
	session_start(); 
	unset($idse);
	session_destroy();
	$_SESSION = array();
	HEADER('Location: index.php');
?>