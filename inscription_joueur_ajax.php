<?php
	include ('conf/conf.php');

	if (isset($_POST['nom']) AND !empty($_POST['nom']) AND isset($_POST['prenom']) AND !empty($_POST['prenom']) AND isset($_POST['mdp']) AND !empty($_POST['mdp'])){
		$mdp = sanitize($_POST['mdp']);
		$nom = sanitize($_POST['nom']);
		$prenom = sanitize($_POST['prenom']);
		$tel = $_SESSION['tel'];
		
		inscrire_joueur($tel, $mdp, $nom, $prenom);
		?> <script> var inscription = 1; </script> <?php
	}
	else{
		?> <script> var inscription = 0; </script> <?php
	}
	echo "coucou";
?>