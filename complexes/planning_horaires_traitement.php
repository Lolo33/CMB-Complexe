<?php
	include '../conf/conf.php';
	if(isset($_POST['heure_fin']) AND isset($_POST['heure_debut']) AND isset($_POST['jour']) AND isset($_POST['statut'])){
		$heure_debut = htmlspecialchars(trim($_POST['heure_debut']));
		$heure_fin = htmlspecialchars(trim($_POST['heure_fin']));
		$jours = sanitize_tab($_POST['jour']);
		$statut = htmlspecialchars(trim($_POST['statut']));
	}

	maj_horaires($heure_debut, $heure_fin, $jours, $statut, $_SESSION['complexe_id']);
	
	$now = new DateTime;
	if  ($statut == 0){
		$statut = 2;
	}
	$liste_terrain_lieu =liste_terrain_lieu($_SESSION['complexe_id']);
	
		foreach ($jours as $jour_key => $jour_value) {
			$dif = $now->format('N') - $jour_value;
			$date = clone($now);
			$date->sub(new DateInterval('P'.$dif.'D'));
			for ($i = 0; $i <= 370; $i = $i+7) {
				$date1 = clone($date);
				$date1->add(new DateInterval('P'.$i.'D'));
				$datetime_debut = DateTime::createFromFormat('Y-m-j H:i:s', $date1->format('Y-m-j').' '.$heure_debut);
				$datetime_fin = DateTime::createFromFormat('Y-m-j H:i:s', $date1->format('Y-m-j').' '.$heure_fin);
					
				foreach ($liste_terrain_lieu as $terrain_key => $terrain_value) {
				ouvrir_fermer_plage($datetime_debut, $datetime_fin, $terrain_value[0], $statut);
				}
			}
		}

	header('location:planning_horaires.php');
?>