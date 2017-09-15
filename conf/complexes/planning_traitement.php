<?php
	include '../conf.php';
//var_dump($_POST);
	/*
	if( isset($_POST['terrain']) AND isset($_POST['action']) AND isset($_POST['heure_fin']) AND isset($_POST['heure_debut']) AND isset($_POST['dupliquer']) AND isset($_POST['jour'])){
		$_POST = sanitize_tab($_POST);
		$terrain = $_POST['terrain'];
		$action = $_POST['action'];
		$heure_debut = $_POST['heure_debut'];
		$heure_fin = $_POST['heure_fin'];
		$dupliquer = $_POST['dupliquer'];
		//$jour = $_POST['jour'];
		$jour = "2017-08-25";
	}
	*/
	//reformer les dates début et fin
	//$datetime_debut = DateTime::createFromFormat('Y-m-j H:i:s', $jour.' '.$heure_debut);
	//$datetime_fin = DateTime::createFromFormat('Y-m-j H:i:s', $jour.' '.$heure_fin);
	//var_dump($datetime_debut);
	//var_dump($datetime_fin);
	// boucle si dupliquer

	$datetime_debut = DateTime::createFromFormat('Y-m-j H:i:s','2017-08-25 13:30:00');
	$datetime_fin = DateTime::createFromFormat('Y-m-j H:i:s', '2017-08-25 15:30:00');
	$terrain = 1;
	$statut_plage = 2;

	echo ouvrir_fermer_plage($datetime_debut, $datetime_fin, $terrain, $statut_plage);

	//header('location:planning_commissions.php');

?>