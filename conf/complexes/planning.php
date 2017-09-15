<?php
	include '../conf.php';

	/*
	if (!isset($_SESSION["id"]) OR !isset($_SESSION['gerant_lieu_id'])){
		header("Location: ../index.php");
	}
	*/
?>

<html>
	<head>
		<?php include('../head.php'); ?>
		<title>Planning</title>
		
		<script>
			$(document).ready(function(){
				$('[data-toggle="popover"]').popover();
			});
		</script>
	</head>

	<body>
		<div id="page">
			<?php //include('volet.php'); ?>
			<div id="corps">
				<div class="has-feedback">
					<form action="planning_traitement.php" method="post">
						<div class="div_input2">
							<span>Sélectionnez une semaine</span>
							<select id="jour" name="jour" style="color: black;">
							  	<?php 
									$joursem = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
									$mois = array("janvier", "fevrier", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "decembre");

									for ($i=0; $i < 360; $i = $i + 7) { 
										$now = new DateTime;
										$delta_jour_debut_semaine = $now->format('N') - 1;
										$debut_semaine	= $now->sub(new DateInterval ('P'.$delta_jour_debut_semaine.'D'));
										$debut_semaine -> add( new DateInterval('P'.$i.'D'));
										?> 
										  	<option class="btn-select-date" style="color: black;" value=<?php echo $debut_semaine->format('Y-m-d').' '; if (isset($_POST['jour']) AND $_POST['jour'] == $debut_semaine->format('Y-m-d')){ echo "selected"; }?>>
										  		<?php 
													echo $joursem[$debut_semaine->format('w')].' '.$debut_semaine->format('d').' '.$mois[$debut_semaine->format('m')-1];
											 	?> 
											</option>
										<?php
									}
								?>
							</select>
							<input class="btn btn_success" id="submit_form" type="submit">
						</div>
					</form>
				</div>
				<div id="post_planning">
					<?php
						$format = 'Y-m-d'; 
						//$lieu_id = $_SESSION['gerant_lieu_id'];
						$lieu_id = 1;
						$heure_min = 10;
						$heure_max = 23.0;
						
						// Pour le début du planning
						if (isset($_POST['jour'])){
							$date_min = DateTime::createFromFormat('Y-m-j', $_POST['jour']);
						}
						else{
							$now1 = new DateTime;
							$delta_jour_debut_semaine = $now->format('N') - 1;
							$date_min	= $now1->sub(new DateInterval ('P'.$delta_jour_debut_semaine.'D'));
						}

						$date_max = clone($date_min);
						$date_max->add( new DateInterval('P6D'));

						// on récupère un tableau avec la liste des terrains.
						$liste_terrains = liste_terrain_lieu($lieu_id);
						$nb_terrain = count($liste_terrains);
						
						// Pour chaque terrain, on y associes ses créneaux.
						foreach ($liste_terrains as $key => $val) {

							// Récupération des créneaux pour un terrain.
							$liste_plages_horaires = liste_plages_horaires_terrain($val['id']);

							// Ajout du tableau des créneaux dans le tableau des terrains
							$liste_terrains[$key]['plages_horaires'] = $liste_plages_horaires;
						}	
					?>
					<div class="tableau"> 
							<table>
								<?php 
									entete_complexe($date_min, $date_max, $liste_terrains);
									//$nom_fonction($date_min, $date_max, $lieu_id, $res_nb_terrains);
									for ($heure = $heure_min; $heure < $heure_max; $heure= $heure + 0.5) {
										?>
											<tr>
												<?php
													$jour = clone($date_min);								
													while ($jour <= $date_max){
														if ( intval($heure) == $heure){
															$minutes = "00";
														}
														else{
															$minutes = "30";
														}
														$datetime_string = $jour->format('Y-m-d').' '.intval($heure).':'.$minutes.':00';
														$date_case = DateTime::createFromFormat('Y-m-d H:i:s', $datetime_string);
														$date_case_string = $date_case->format('Y-m-d H:i:s');

														case_complexe($date_case_string, $liste_terrains);
														
														unset($date_case);
														$jour->add( new DateInterval('P1D'));
													}
													unset($jour);
												?>
											</tr>
										<?php
									} 
								?>
							</table>
					</div>	
				</div>
			</div>
		</div>
		<?php //include('footer.php') ?>

		<div class="modal fade" id="modal_creneau" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="center">Gestion du planning</h1>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>

					<div class="modal-body center">
						<form action="planning_traitement.php" method="post">
							<input type="hidden" class="input_terrrain" name="terrain" value="1">
							<input type="hidden" class="input_jour" name="terrain" value="1">
							<div id="creneau_action" class="ligne">
								<p>Action à réaliser</p>
								<div>
									<label>
										<span>Ouvrir des créneaux à la réservation</span>
										<input id="input_action_ouvrir" class="clic-radio-1" type="radio" name="action" value="ouvrir" checked="checked">
									</label>
									<br/>
									<label>
										<span>Fermer des créneaux à la réservation</span>
										<input id="input_action_fermer" class="clic-radio-1" type="radio" name="action" value="fermer" checked="checked">
									</label>
									<br/>
									<label>
										<span>Entrer une réservation</span>
										<input id="input_action_reserver" class="clic-radio-1" type="radio" name="action" value="reserver" checked="checked">
									</label>
								</div>
							</div>
							<div id="creneau_heure" class="ligne">
								<div>
									<span>Heure de début:  </span> <br/>
									<select class="form-control" id="input_heure_debut" name="heure_debut">
										<?php
											for ($i=10.5; $i <= 24; $i = $i +0.5) {
												if (intval($i) == $i){
													if ($i < 10){
														$heure_debut = '0'.$i.':00';
													}	
													else{
														$heure_fin = $i.':00';
													}
												}
												else{
													if ($i < 10){
														$heure_debut = '0'.intval($i).':30';
													}	
													else{
														$heure_debut = intval($i).':30';
													}	
												}
												?>
													<option value="<?php echo $heure_debut.':00'; ?>"> <?php echo $heure_debut; ?> </option>
												<?php
											}
										?>
									</select>
								</div>
								<div>
									<span>Heure de fin: </span> <br/>
									<select class="form-control" id="input_heure_fin" name="heure_fin">
										<?php
											for ($i=10.5; $i <= 24; $i = $i +0.5) {
												if (intval($i) == $i){
													if ($i < 10){
														$heure_fin = '0'.$i.':00';
													}	
													else{
														$heure_fin = $i.':00';
													}
												}
												else{
													if ($i < 10){
														$heure_fin = '0'.intval($i).':30';
													}	
													else{
														$heure_fin = intval($i).':30';
													}	
												}
												?>
													<option value="<?php echo $heure_fin.':00'; ?>"> <?php echo $heure_fin; ?> </option>
												<?php
											}
										?>
									</select>
								</div>						
							</div>
							<div id="creneau_resa" class="ligne">
								<label>
									<span>Nom :</span>
									<input type="text" name="input_resa_nom" placeholder="Damien">
								</label>
								<br/>
								<label>
									<span>Téléphone :</span>
									<input type="text" name="input_resa_tel" placeholder="0638433428">
								</label>
								<br/>
								<label>
									<span>Informations :</span>
									<input type="textarea" name="input_resa_info" placeholder="téléphone d'un autre joueur">
								</label>
							</div>
							<div id="creneau_dupliquer">
								<div class="ligne">
									<p>Dupliquer cette action sur plusieurs semaines</p>
									<div>
										<label>
											<span>Non</span>
											<input id="input_dupliquer_non" class="clic-radio-1" type="radio" name="dupliquer" value="0">
										</label>
										<br/>
										<label>
											<span>Oui</span>
											<input id="input_dupliquer_oui" class="clic-radio-1" type="radio" name="dupliquer" value="1" checked="checked">
										</label>
									</div>
								</div>
								<div class="ligne">
									<p>Jusqu'à la semaine : <br/>(inclus)</p>
									<select>
										<?php
											for ($i=0; $i < 52 ; $i++) { 
												$date = new DateTime;
												//trouver le prochain lundi
												//écrire de lundi 11 mai au dimanche 17 mai
												?>
													<option value="">Semaine <?php echo $i; ?></option>
												<?php
											}
										?>
									</select>
								</div>
							</div>
						<input type="submit" class="btn btn-success center" value="Valider">
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html> 
	<?php

function planning_popover(){
	?>
		<div>
			<span> De XX:HH à <input type="time" name="hehor_heure_fin"></span>
		</div>
	<?php
}
function entete_complexe($jourmin, $jourmax, $tab_terrains){
	$db = connexionBdd();
	$joursem = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
	$mois = array("janvier", "fevrier", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "decembre");
	$colspan = count($tab_terrains);
	?>
		<tr class="entete_complexe_jour">
			<?php   
				$jour = clone ($jourmin);
				while ($jour <= $jourmax){
					?>
						<th  colspan="<?php echo $colspan; ?>">
							<div > <?php echo $joursem[$jour->format('w')].' '.$jour->format('d').' '.$mois[$jour->format('m')-1]; ?> </div>
						</th>
					<?php
					$jour->add( new DateInterval('P1D'));
				}
				unset($jour);
			?>
		</tr>
		<tr>
			<?php   
				$jour = clone ($jourmin);
				while ($jour <= $jourmax){
					foreach ($tab_terrains as $terrain) {
						?>
							<td class="">
								<?php echo $terrain['terrain_nom']; ?>
							</td>
						<?php
					}
					$jour->add( new DateInterval('P1D'));
				}
				unset($jour);
			?>
		</tr>
	<?php
}                           
function case_complexe ($date_heure, $liste_terrains){
		$joursem = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
		$mois = array("janvier", "fevrier", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "decembre");
		$demi_heure = DateTime::createFromFormat('i', 30);
		$date_date_heure = DateTime::createFromFormat('Y-m-j H:i:s', $date_heure);

		$date_date_heure2 = DateTime::createFromFormat('Y-m-j H:i:s', $date_heure);
		$date_date_heure2->add(new DateInterval('PT30M'));

		foreach ($liste_terrains as $terrain => $val) {
			$creneau_rempli = 0;
			foreach ($val['plages_horaires'] as $plage_key => $plage_value) {
				$date_debut = DateTime::createFromFormat('Y-m-j H:i:s', $plage_value['hor_heure_debut']);
				$date_fin = DateTime::createFromFormat('Y-m-j H:i:s', $plage_value['hor_heure_fin']);

				if ($date_date_heure == $date_debut AND $plage_value['statut_id'] == "3") {

					$date_debut2 = DateTime::createFromFormat('Y-m-j H:i:s', $plage_value['hor_heure_debut']);
					$date_fin2 = DateTime::createFromFormat('Y-m-j H:i:s', $plage_value['hor_heure_fin']);
					$nb_demi_heure = 0;
					while ($date_debut2 < $date_fin2){
						$nb_demi_heure = $nb_demi_heure + 1;
						$date_debut2->add(new DateInterval('PT30M'));
					}
					unset ($date_debut2);
					unset ($date_fin2);

					$hauteur = 23*$nb_demi_heure;
					$resa = recupResaById($plage_value['reservation_id']);
					?>	
						<td rowspan="<?php echo $nb_demi_heure; ?>" style="height: <?php echo $hauteur; ?>;">
							<button  class="clic-js3 creneau_reserve" data-toggle="modal" data-target="#modal_creneau_reserve_<?php echo $plage_value['reservation_id']; ?>">                       
								<?php 
									$ex = explode(" ", $date_heure); 
									$ex2 = explode(":", $ex[1]);
									echo $ex2[0].':'.$ex2[1];
								?>
								<input type="hidden" class="creneau_id" value="<?php echo $plage_value['id']; ?>">
								<input type="hidden" class="creneau_id" value="<?php echo $plage_value['reservation_id']; ?>">
							</button>
						</td>
							
						<div class="modal fade" id="modal_creneau_reserve_<?php echo $plage_value['reservation_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h1 class="center">Créneau réservé id: <?php echo $plage_value['reservation_id']; ?> par <?php echo "à cabler"//echo $resa['utilisateur_api_id']; ?></h1>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									</div>
									<div class="modal-body center">
										<div>
											<?php
												echo "capitaine et tel";
												//echo $resa['resa_capitaine'].' -> '.$resa['resa_capitaine_tel'].'<br/>';
											?>
										</div>
										<button class="btn btn-danger center">Annuler la réservation</button>
									</div>
								</div>
							</div>
						</div>
					<?php
					$creneau_rempli = 1;
					break 1;
				}
				elseif ($plage_value['statut_id'] == "3" AND $date_date_heure > $date_debut AND $date_date_heure < $date_fin){
					// on ne fait rien car il s'agit d'une demi heure déjà comptée au sein d'une résa
					$creneau_rempli = 1;
					break 1;
				}
				elseif ($plage_value['statut_id'] == "1" AND $date_date_heure >= $date_debut AND $date_date_heure2 < $date_fin) {
					?>
						<td>
							<button type="button" class="clic-js creneau_libre" data-toggle="modal" data-target="#modal_creneau">                       
								<?php 
									$ex = explode(" ", $date_heure); 
									$ex2 = explode(":", $ex[1]);
									echo $ex2[0].':'.$ex2[1];
								?>
								<input type="hidden" class="creneau_terrain_id" value="<?php echo $val['id']; ?>">
								<input type="hidden" class="creneau_heure" value="<?php echo $date_heure; ?>">
							</button>			
						</td>
					<?php	
					$creneau_rempli = 1;
					break 1;		
				}
			}
			if ($creneau_rempli == 0){
				?>
						<td>
							<button type="button" data-toggle="modal" data-target="#modal_creneau">                       
								<?php 
									$ex = explode(" ", $date_heure); 
									$ex2 = explode(":", $ex[1]);
									echo $ex2[0].':'.$ex2[1];
								?>
								<input type="hidden" class="creneau_terrain_id" value="<?php echo $val['id']; ?>">
								<input type="hidden" class="creneau_heure" value="<?php echo $date_heure; ?>">
							</button>			
						</td>
				<?php
			}
		}
}
									