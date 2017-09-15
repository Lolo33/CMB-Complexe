<?php
	include '../conf.php';
var_dump($_POST);
	if( isset($_POST['terrain']) AND isset($_POST['heure_fin']) AND isset($_POST['heure_debut']) AND isset($_POST['jour']) AND isset($_POST['tarif'])){
		$terrains = sanitize_tab($_POST['terrain']);
		$heure_debut = htmlspecialchars(trim($_POST['heure_debut']));
		$heure_fin = htmlspecialchars(trim($_POST['heure_fin']));
		$jours = sanitize_tab($_POST['jour']);
		$tarif = htmlspecialchars(trim($_POST['tarif']));
	}

	maj_tarifs($heure_debut, $heure_fin, $terrains, $jours, $tarif);

	//header('location:planning_commissions.php');




?>