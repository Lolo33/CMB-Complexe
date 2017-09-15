<?php
	include '../conf/conf.php';
	if (isset($_GET['id'])){
		$resa_id = sanitize($_GET['id']);
		annuler_resa_by_complexe($resa_id);
		header('Location: planning.php');
	}
	else{
		header('Location: ../index.php');
	}
	
?>