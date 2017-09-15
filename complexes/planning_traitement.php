<?php
	include '../conf/conf.php';
	//var_dump($_POST);
	
	
	if (isset($_POST['terrain']) AND isset($_POST['action']) AND isset($_POST['heure_fin']) AND isset($_POST['heure_debut']) AND isset($_POST['dupliquer']) AND isset($_POST['jour'])){
		$_POST = sanitize_tab($_POST);
		$terrain = $_POST['terrain'];
		$action = $_POST['action'];
		$heure_debut = $_POST['heure_debut'];
		$res_nom_client = $_POST['input_resa_nom'];
		$res_num_tel_client = $_POST['input_resa_tel'];
		$res_descriptif = $_POST['input_resa_info'];
		$heure_fin = $_POST['heure_fin'];
		$dupliquer = $_POST['dupliquer'];
		$jour = $_POST['jour'];

		if(empty($_POST['jour'])){
			$datetime_debut = new DateTime;
		}
		else{
			$datetime_debut = DateTime::createFromFormat('Y-m-j H:i:s', $jour.' '.$heure_debut);
		}
		$datetime_fin = DateTime::createFromFormat('Y-m-j H:i:s',  $jour.' '.$heure_fin);
		if ($heure_fin == "00:00:00"){
			$datetime_fin->add( new DateInterval('P1D') );
		}


		// boucle si dupliquer

		if($action == "reserver"){
			$statut_plage = 3;
			reserver2($datetime_debut, $datetime_fin, $terrain, $res_nom_client, $res_num_tel_client, $res_descriptif, NULL);
		}
		elseif($action == "ouvrir"){
			$statut_plage = 1;
			ouvrir_fermer_plage($datetime_debut, $datetime_fin, $terrain, $statut_plage);
		}
		if($action == "fermer"){
			$statut_plage = 2;
			ouvrir_fermer_plage($datetime_debut, $datetime_fin, $terrain, $statut_plage);
		}
	}
	header('location:planning.php');
?>