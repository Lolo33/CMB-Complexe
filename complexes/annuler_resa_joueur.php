<?php
	include '../conf/conf.php';
	if (isset($_GET['id'])){
		$resa_id = sanitize($_GET['id']);
		annuler_resa_by_joueur($resa_id);
	}	
	header('Location: page_reservation.php?id='.$_GET['id_complexe']);
?>