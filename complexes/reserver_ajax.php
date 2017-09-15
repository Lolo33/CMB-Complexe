<?php
	include '../conf/conf.php';
	$_POST = sanitize_tab($_POST);
	if (isset($_POST['datetime_debut']) AND !empty($_POST['datetime_debut']) AND isset($_POST['datetime_fin']) AND !empty($_POST['datetime_fin']) AND isset($_POST['terrain']) AND !empty($_POST['terrain']) ){
	
		$datetime_debut = DateTime::createFromFormat('Y-m-j H:i:s', $_POST['datetime_debut']);
		$datetime_fin = DateTime::createFromFormat('Y-m-j H:i:s', $_POST['datetime_fin']);

		// Test si présence d'un descriptif
		if (isset($_POST['descriptif']) AND !empty($_POST['descriptif'])){
			$res_descriptif = $_POST['descriptif'];	
		}
		else{
			$res_descriptif = "";	
		}

		// Test si résa via apport d'affaire
		if (isset($_SESSION['utilisateur_api_id'])){
			$utilisateur_api_id = $_SESSION['utilisateur_api_id'];
		}
		else{
			$utilisateur_api_id = NULL;
		}
		
		// Test si présence du nom et du tel sinon msg erreur
		if(isset($_SESSION['joueur_tel']) AND isset($_SESSION['joueur_nom'])){
			$res_nom_client = $_SESSION['joueur_nom'].' '.$_SESSION['joueur_prenom'];
			$res_num_tel_client = $_SESSION['joueur_tel'];
			reserver2($datetime_debut, $datetime_fin, $_POST['terrain'], $res_nom_client, $res_num_tel_client, $res_descriptif, $utilisateur_api_id);
			?><script> var resa = 1; </script><?php
		}
		elseif (isset($_POST['nom']) AND !empty($_POST['nom']) AND isset($_POST['tel']) AND !empty($_POST['tel'])){
			$res_nom_client = $_POST['nom'];
			$res_num_tel_client = $_POST['tel'];
			reserver2($datetime_debut, $datetime_fin, $_POST['terrain'], $res_nom_client, $res_num_tel_client, $res_descriptif, $utilisateur_api_id);
			?><script> var resa = 1; </script><?php
			include 'recap_resas_joueur.php';
		}
		else{
			include 'recap_resas_joueur.php';
			?><script> var resa = 0; </script><?php
		}
	}
	else{
		include 'recap_resas_joueur.php';
		?><script> var resa = 0; </script><?php
	}
?>
