<?php
	include '../conf.php';

	/*
	if (!isset($_SESSION["id"]) OR !isset($_SESSION['gerant_lieu_id'])){
		header("Location: ../index.php");
	}
	*/
	$joursem = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
	$lieu_id = 1;
	$liste_aa = liste_aa();
	$liste_terrains = liste_terrain_lieu($lieu_id);
	foreach ($liste_terrains as $terrain_key => $terrain_value) {
		foreach ($liste_aa as $aa_key => $aa_value) {
			$liste_commissions_terrain_aa[$terrain_value[0]][$aa_value[0]]['liste_com'] = liste_commissions_terrain_aa($terrain_value[0], $aa_value[0]);
		}
	}
	//var_dump($liste_commissions_terrain_aa[1][2]);
?>

<html>
	<head>
		<?php //include('head.php'); ?>
		<title>Planning</title>
		
	</head>

	<body>
		<div id="page">
			<?php //include('volet.php'); ?>
			<div id="corps">
				<div id="post_planning">
					<?php 
						//$lieu_id = $_SESSION['gerant_lieu_id'];
						$heure_min = 10;
						$heure_max = 23.0;
						
					?>
					<div class="tableau"> 
							<table>
								<?php 
									entete_complexe_commission($liste_terrains);
									//$nom_fonction($date_min, $date_max, $lieu_id, $res_nb_terrains);
									for ($heure = $heure_min; $heure < $heure_max; $heure= $heure + 0.5) {
										?>
											<tr>
												<?php
													for ($i=1; $i < 7; $i++) { 
														if ( intval($heure) == $heure){
															$minutes = "00";
														}
														else{
															$minutes = "30";
														}
														$datetime_string = intval($heure).':'.$minutes.':00';
														$heure2 = intval($heure).":".$minutes.":00";
														case_complexe_commission($jour_semaine = $i, $heure2, $liste_terrains);
													}

													// pour le dimanche
													if ( intval($heure) == $heure){
														$minutes = "00";
													}
													else{
														$minutes = "30";
													}
													$datetime_string = intval($heure).':'.$minutes.':00';
													$heure2 = intval($heure).":".$minutes.":00";
													case_complexe_commission(0, $heure2, $liste_terrains);
												?>
											</tr>
										<?php
									} 
								?>
							</table>
					</div>	
				</div>
				<div id="formulaire_commisssions">
					<form method="post" action="planning_commissions_traitement.php">
						<h1>Gestion des apporteurs d'affaires</h1>
						<div>
							<p>Apporteurs d'affaires :</p>
							<?php
								foreach ($liste_aa as $aa_key => $aa_value) {
									?>
										<span>
											<label>
												<?php echo $aa_value['nom']; ?>
												<input type="checkbox" name="aa[]" value="<?php echo $aa_value[0]; ?>">
											</label>
										</span>
									<?php
								}
							?>
						</div>
						<div>
							<p>Terrains :</p>
							<?php
								foreach ($liste_terrains as $terrain_key => $terrain_value) {
									?>
										<span>
											<label>
												<?php echo $terrain_value['terrain_nom']; ?>
												<input type="checkbox" name="terrain[]" value="<?php echo $terrain_value[0]; ?>">
											</label>
										</span>
									<?php
								}
							?>
						</div>
						<div>
							<p>Période</p>
							<span>
								De
								<select name="heure_debut">
									<?php
										for ($i=10; $i < 23.5 ; $i=$i+0.5) { 
											if (intval($i) == $i){
												$minutes = "00";
											}
											else{
												$minutes = "30";
											}
											$datetime_string = intval($i).':'.$minutes.':00';
											$heure2 = intval($i).":".$minutes.":00";
											?>

											<option value="<?php echo $heure2; ?>"><?php echo intval($i).":".$minutes; ?></option>
											<?php
										}
									?>
								</select>
							</span>
							<span>
								De
								<select name="heure_fin">
									<?php
										for ($i=10; $i < 23.5 ; $i=$i+0.5) { 
											if (intval($i) == $i){
												$minutes = "00";
											}
											else{
												$minutes = "30";
											}
											$datetime_string = intval($i).':'.$minutes.':00';
											$heure2 = intval($i).":".$minutes.":00";
											?>

											<option value="<?php echo $heure2; ?>"><?php echo intval($i).":".$minutes; ?></option>
											<?php
										}
									?>
								</select>
							</span>
						</div>
						<div>
							<p>Sélectionnez un ou plusieurs jours</p>
							<?php 
								for ($i = 1; $i < 8; $i++){
									?>
										<span>
											<label>
												<?php 
													if ($i == 7 ){
														echo $joursem[0];
														?><input type="checkbox" name="jour[]" value="0"><?php
													}
													else{
														echo $joursem[$i];
														?><input type="checkbox" name="jour[]" value="<?php echo $i; ?>"><?php
													}
												?>
											</label>
										</span>
									<?php
								}
							?>
						</div>
						<div>
							<p>Montant de la commission</p>
							<label>
								Valeur en pourcentage
								<input type="number" name="commission" placeholder="15">
								%
							</label>
							<span> ou </span>
							<label>
								Interdire l'apport d'affaires
								<input type="checkbox" name="interdiction">
							</label>

						</div>
						<input type="submit" name="Valider">
						
					</form>
				</div>
			</div>
		</div>
		<?php //include('footer.php') ?>
	</body>
</html> 
<?php

function entete_complexe_commission($tab_terrains){
	global $liste_aa;
	$db = connexionBdd();
	$joursem = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
	$joursem2 = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi','dimanche');
	$colspan1 = count($liste_aa)*count($tab_terrains);
	$colspan2 = count($liste_aa);
	?>
		<tr class="entete_complexe_jour" style="text-align: center">
			<?php   
				for ($i=0; $i < 7; $i++) { 
					?>
						<th  colspan="<?php echo $colspan1; ?>">
							<div > <?php echo $joursem2[$i]; ?> </div>
						</th>
					<?php
				}
			?>
		</tr>
		<tr style="text-align: center">
			<?php   
				for ($i=1; $i < 8; $i++) {
					foreach ($tab_terrains as $terrain_key => $terrain_value) {
						?>
							<td colspan="<?php echo $colspan2; ?>">
								<?php echo $terrain_value['terrain_nom']; ?>
							</td>
						<?php
					}
				}
			?>
		</tr>
	<?php
}                           
function case_complexe_commission ($jour_semaine, $heure, $liste_terrains){
	$joursem = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
	$mois = array("janvier", "fevrier", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "decembre");
	$obj_heure = DateTime::createFromFormat('H:i:s', $heure);
	global $liste_aa;
	global $liste_commissions_terrain_aa;
	//var_dump($liste_commissions_terrain_aa);
	foreach ($liste_terrains as $terrain => $val) {
		foreach ($liste_aa as $aa_key => $aa_val) {
			$creneau_rempli = 0;
			//echo "<br/>val[0] => ".$val[0];
			//echo "<br/>aa_val[0] => ".$aa_val[0];
			//var_dump($liste_commissions_terrain_aa[$val[0]]);
				//echo "test";
				foreach ($liste_commissions_terrain_aa[$val[0]][$aa_val[0]]['liste_com'] as $plage_com_key => $plage_com_value) {

					$obj_heure_plage_debut = DateTime::createFromFormat('H:i:s', $plage_com_value['com_heure_debut']);
					$obj_heure_plage_fin = DateTime::createFromFormat('H:i:s', $plage_com_value['com_heure_fin']);
					$heure_debut_while = clone($obj_heure_plage_debut);
					$heure_fin_while = clone($obj_heure_plage_fin);
					if ($plage_com_value['com_heure_debut'] == $heure AND $plage_com_value['com_jour'] == $jour_semaine ) {
						$nb_demi_heure = 0;
						while ($heure_debut_while < $heure_fin_while) {
							$heure_debut_while->add(new DateInterval('PT30M'));
							$nb_demi_heure++;
						};

						$hauteur = 23*$nb_demi_heure;
						?>	
							<td rowspan="<?php echo $nb_demi_heure; ?>" style="background-color: red; height: <?php echo $hauteur; ?>;">
								<?php 
									echo $heure;
								?>
								<br/>
								<?php
									echo $plage_com_value['com_montant']; 
									//echo "<br> demi heure => ".$nb_demi_heure; 
								?>
							</td>
						<?php
						$creneau_rempli = 1;
						break 1;
					}
					elseif ($obj_heure > $obj_heure_plage_debut AND $obj_heure < $obj_heure_plage_fin AND $jour_semaine == $plage_com_value['com_jour']){
						// on ne fait rien car il s'agit d'une demi heure déjà comptée au sein d'une résa
						$creneau_rempli = 1;
						break 1;
					}
				}
			if ($creneau_rempli == 0){
				?>
					<td style="margin: 0px; padding: 0px; border: solid 1px black; ">
						Refus
							<?php //echo "heure => ".$heure; ?>
							<?php //echo "terrain => ".$val[0]; ?>
							<?php //echo "aa => ".$aa_val[0]; ?>
					<?php 
					/*
						echo "<br/> heure => ".$heure; 
						echo "<br/> jours => ".$jour_semaine; 
						echo "<br/>terrain  => ".$val[0];
						echo "<br/>aa => ".$aa_val[0];
					*/
					?>
					</td>
				<?php
			}
		}
	}
}







