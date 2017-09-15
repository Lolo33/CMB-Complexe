<?php 
	include 'conf/conf.php';
	$erreur = NULL;
	//var_dump($_POST);
	if(isset($_POST['identifiant']) AND isset($_POST['mdp']) AND !empty($_POST['identifiant']) AND !empty($_POST['mdp'])){
		$identifiant = sanitize($_POST['identifiant']);
		$mdp = sanitize($_POST['mdp']);
		$test_co = connexion($identifiant, $mdp);
		if ($test_co){
			if ($_SESSION['profil_user'] == "complexe"){
				header('location:complexes/planning.php');
			}
			elseif ($_SESSION['profil_user'] == "aa"){
				header('location:complexes/aa/aa_board.php');
			}
			elseif ($_SESSION['profil_user'] == "mate_maker"){
				header('location:complexes/aa/aa_board.php');
			}
		}
		else{
			$erreur = "idmdp";
			//echo $erreur;
		}
	}
	else{
		$erreur = "vide";
		//echo $erreur;
	}
	if(isset($erreur) AND $erreur != NULL){
		header('Location: index.php?erreur='.$erreur);
	}
?>