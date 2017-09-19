<?php
	include '../conf/conf.php';
	if(isset($_POST['heure_fin']) AND isset($_POST['heure_debut']) AND isset($_POST['jour']) AND isset($_POST['statut'])){
		$heure_debut = htmlspecialchars(trim($_POST['heure_debut']));
		$heure_fin = htmlspecialchars(trim($_POST['heure_fin']));
		$jours = sanitize_tab($_POST['jour']);
		$statut = htmlspecialchars(trim($_POST['statut']));
	}

	maj_horaires($heure_debut, $heure_fin, $jours, $statut);

	header('location:planning_horaires.php');
?>