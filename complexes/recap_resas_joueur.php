<div id="liste_resa" >
	<h1>Vos réservation</h1>
	<hr/>
	<?php
		$liste_resa = liste_resa_joueur($_SESSION['joueur_tel']);
		foreach ($liste_resa as $resa_key => $resa_value) {
			$explode_resa_debut = explode(' ', $resa_value['hor_heure_debut']);
			$explode_resa_fin = explode(' ', $resa_value['hor_heure_fin']);

			$jour2 = date_lettres2($explode_resa_debut[0]);

			$explode_heure_debut = explode(':', $explode_resa_debut[1]);
			$explode_heure_fin = explode(':', $explode_resa_fin[1]);
			?>
				<div class="ligne">
					<span> Le <?php echo $jour2; ?> </span>
					<span> De </span>
					<span><?php echo $explode_heure_debut[0].':'.$explode_heure_debut[1]; ?> </span>
					<span> À </span>
					<span><?php echo $explode_heure_fin[0].':'.$explode_heure_fin[1]; ?> </span>
					<a href="annuler_resa_joueur.php?id=<?php echo $resa_value[0]; ?>&id_complexe=<?php echo $_GET['id']; ?>" class="btn btn-danger">Annuler</a>
				</div>
			<?php
		}
		if (empty($liste_resa)){
			echo "Vous n'avez aucune réservation pour l'instant";
		}
	?>
</div>