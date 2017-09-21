
<?php
	include '../conf/conf.php';

	if (!isset($_SESSION["id"])){
		header("Location: ../index.php");
	}
	$joursem = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
	$joursem2 = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi','dimanche');
	$mois = array("janvier", "fevrier", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "decembre");
	$lieu_id = $_SESSION['complexe_id'];
	$liste_terrains = liste_terrain_lieu($lieu_id);
	foreach ($liste_terrains as $terrain_key => $terrain_value) {
		$liste_tarifs_terrain[$terrain_value[0]] = liste_tarifs_terrain($terrain_value[0]);
	}
	$id_histo = tracerComplexe();
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Planning</title>
        <script src="../js/jquery.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Template by FREEHTML5.CO" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	<meta name="author" content="FREEHTML5.CO" />

	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,400italic,700' rel='stylesheet' type='text/css'>
	
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="css/planning.css">
        <link rel="stylesheet" href="css/colors.css">
	<link rel="stylesheet" href="css/style_complexe.css">

	</head>
		<?php //include('head.php'); ?>
		<title>Planning</title>
		
	</head>
	<body>
		
		<?php include 'volet.php'; ?>
		<div id="page_principale"  class="effet1">
					<div class="modal fade" id="modal_aide" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<br/>
									<h1 class="center titre_section">Guide d'utilsation de la page : Gestion des tarifs</h1>
								</div>
								<div class="modal-body center">
									<p>Contenu</p>
								</div>
							</div>
						</div>
					</div>
			<h1 class="text-center">Gestion des tarifs</h1>
			<div id="content_tarif" class="fond-gris">
				<?php include 'volet_tarifs.php'; ?>
				<div id="corps" class="effet1 center fond-clair">
					<div id="post_planning">
						<?php 
							//$lieu_id = $_SESSION['gerant_lieu_id'];
							$heure_min = 7;
							$heure_max = 24.0;
							
						?>
						<h3 style="color: white;">Tarifs</h3>
						<div class="tableau">
								<table>
									<?php 
										entete_complexe_commission($liste_terrains);
										//$nom_fonction($date_min, $date_max, $lieu_id, $res_nb_terrains);
										for ($heure = $heure_min; $heure < $heure_max; $heure= $heure + 0.5) {
											if ( intval($heure) == $heure){
												$minutes = "00";
											}
											else{
												$minutes = "30";
											}

											if ($heure == 24){
												$datetime_string = '00:00:00';
												$heure2 = '00:00:00';
											}
											elseif ($heure < 10){
												$datetime_string = '0'.intval($heure).':'.$minutes.':00';
												$heure2 = '0'.intval($heure).":".$minutes.":00";
											}
											else{
												$datetime_string = intval($heure).':'.$minutes.':00';
												$heure2 = intval($heure).":".$minutes.":00";
											}
											?>
												<tr>
													<td class="heure"><?php echo intval($heure).':'.$minutes;?></td>
													<?php
														for ($i=1; $i < 7; $i++) { 

															if (intval($heure) < 10){
																$datetime_string = '0'.$datetime_string;
																$heure2 = '0'.$heure2;
															}
															elseif($heure == 24){
																$datetime_string = '00:00:00';
																$heure2 = '00:00:00';

															}
															else{
																$datetime_string = $datetime_string;
																$heure2 = $heure2;
															}

															case_complexe_commission($jour_semaine = $i, $heure2, $liste_terrains);
														}

														// pour le dimanche
														case_complexe_commission(0, $heure2, $liste_terrains);
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
		</div>
	<!-- jQuery -->
	<script src="../js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="../js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="../js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

		<?php include "tracer/script_bas_page.php"; ?>
	</body>
</html> 
<?php

function entete_complexe_commission($tab_terrains){
	global $joursem;
	global $joursem2; 
	$colspan = count($tab_terrains);
	?>
		<tr class="entete_complexe_jour" style="text-align: center">
			<th rowspan="2" style="height: 46px;">Heure</th>
			<?php   
				for ($i=0; $i < 7; $i++) { 
					?>
						<th  colspan="<?php echo $colspan; ?>">
							<div> <?php echo $joursem2[$i]; ?> </div>
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
							<td>
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
	global $joursem;
	global $mois;
	global $liste_tarifs_terrain;
	$obj_heure = DateTime::createFromFormat('H:i:s', $heure);
	foreach ($liste_terrains as $terrain => $val) {
		$creneau_rempli = 0;
				foreach ($liste_tarifs_terrain[$val[0]] as $tarif_key => $tarif_value) {
					if ($tarif_value['tarif_heure_debut'] == $heure AND $tarif_value['tarif_jour'] == $jour_semaine ) {
						$obj_heure_plage_debut = DateTime::createFromFormat('H:i:s', $tarif_value['tarif_heure_debut']);
						$obj_heure_plage_fin = DateTime::createFromFormat('H:i:s', $tarif_value['tarif_heure_fin']);
						$heure_debut_while = clone($obj_heure_plage_debut);
						$heure_fin_while = clone($obj_heure_plage_fin);

						$nb_demi_heure = 0;
						if ($tarif_value['tarif_heure_fin'] == "00:00:00"){
							$nb_heure = 24 - $heure_fin_while->format('H');
							$nb_demi_heure = 2*$nb_heure;
							if ($heure_fin_while->format('i') == "30"){
								$nb_demi_heure--;
							}
						}
						else{
							while ($heure_debut_while < $heure_fin_while) {
								$heure_debut_while->add(new DateInterval('PT30M'));
								$nb_demi_heure++;
							}
						}

						$hauteur = 23*$nb_demi_heure;
						if($tarif_value['tarif_montant'] <=50 ){
							$nv_com = 1;
						}
						elseif($tarif_value['tarif_montant'] <= 60 ){
							$nv_com = 2;
						}
						elseif($tarif_value['tarif_montant'] <= 70 ){
							$nv_com = 3;
						}
						elseif($tarif_value['tarif_montant'] <= 80 ){
							$nv_com = 4;
						}
						elseif($tarif_value['tarif_montant'] <= 90 ){
							$nv_com = 5;
						}
						elseif($tarif_value['tarif_montant'] <= 100 ){
							$nv_com = 6;
						}
						else{
							$nv_com = 7;
						}
						?>	
							<td class="center <?php echo 'td_'.$nv_com; ?>" rowspan="<?php echo $nb_demi_heure; ?>" style="height: <?php echo $hauteur; ?>px;">
								<p class="heure_prix"><?php echo $obj_heure_plage_debut->format('H:i').' - '.$obj_heure_plage_fin->format('H:i') ?></p>
								<p class="prix"><?php echo $tarif_value['tarif_montant'].' €'; ?></p>
							</td>
						<?php
						$creneau_rempli = 1;
						break 1;
					}
					else{
						$obj_heure_plage_debut = DateTime::createFromFormat('H:i:s', $tarif_value['tarif_heure_debut']);
						$obj_heure_plage_fin = DateTime::createFromFormat('H:i:s', $tarif_value['tarif_heure_fin']);
						if ($obj_heure > $obj_heure_plage_debut AND ($obj_heure < $obj_heure_plage_fin OR $tarif_value['tarif_heure_fin'] == "00:00:00") AND $jour_semaine == $tarif_value['tarif_jour']){
							// on ne fait rien car il s'agit d'une demi heure déjà comptée au sein d'une résa
							$creneau_rempli = 1;
							break 1;
						}

					}
				}
				if ($creneau_rempli == 0){
					?>
						<td class="center" class="not_defined">
							---
						</td>
					<?php
				}
	}
}







