<?php 
	include 'conf/conf.php';
	var_dump($_POST);
	if(isset($_POST['tel']) AND isset($_POST['mdp']) AND !empty($_POST['tel']) AND !empty($_POST['mdp'])){
		$tel = sanitize($_POST['tel']);
		$mdp = sanitize($_POST['mdp']);
		$test_co = connexion_joueur($tel, $mdp);
		if ($test_co){
			?> <script> var connexion = 1; </script> <?php
		}
		else{
			?> <script> var connexion = 0; </script> <?php
			echo "Problème de connexion";		
		}
	}
	else{
		?> <script> var connexion = 0; </script> <?php
		echo "champ vide";
	}
?>