<?php
	include '../conf.php';
var_dump($_POST);
	if( isset($_POST['aa']) AND isset($_POST['terrain']) AND isset($_POST['heure_fin']) AND isset($_POST['heure_debut']) AND isset($_POST['jour']) AND isset($_POST['commission'])){
		if (isset($_POST['interdiction'])){
			$interdiction = htmlspecialchars(trim($_POST['interdiction']));
		}
		else{
			$interdiction = 0;
		}
		$aa = sanitize_tab($_POST['aa']);
		$terrains = sanitize_tab($_POST['terrain']);
		$heure_debut = htmlspecialchars(trim($_POST['heure_debut']));
		$heure_fin = htmlspecialchars(trim($_POST['heure_fin']));
		$jours = sanitize_tab($_POST['jour']);
		$commission = htmlspecialchars(trim($_POST['commission']));
	}

	maj_commissions($heure_debut, $heure_fin, $terrains, $aa, $jours, $commission, $interdiction);

	//header('location:planning_commissions.php');




?>