
<?php
	include '../conf/conf.php';

	if (!isset($_SESSION["id"])){
		header("Location: ../index.php");
	}
	$joursem = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
	$joursem2 = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi','Dimanche');
	$mois = array("Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre");
	$lieu_id = $_SESSION['complexe_id'];
	$horaires = liste_horaires_complexe($_SESSION['complexe_id']);
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
	<link rel="stylesheet" href="css/style_complexe.css">
        <link rel="stylesheet" href="css/colors.css">

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
									<h1 class="center titre_section">Guide d'utilsation de la page : Gestion des horaires</h1>
								</div>
								<div class="modal-body center">
									<p>Contenu</p>
								</div>
							</div>
						</div>
					</div>
			<h1 class="text-center">Gestion des horaires</h1>
			<div id="content_tarif">
				<?php include 'volet_horaires.php'; ?>
				<div id="corps" class="center effet1 box fond-blanc contour-bleu">
					<div id="post_planning">
						<?php 
							//$lieu_id = $_SESSION['gerant_lieu_id'];
							$heure_min = 0;
							$heure_max = 24.0;
							
						?>
						<div class="tableau">
								<table>
									<?php 
										entete_complexe_horaire();
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
													<td class="heure bold fond-pale"><?php echo intval($heure).':'.$minutes;?></td>
													<?php
														for ($i=1; $i < 7; $i++) {
															case_complexe_horaire($jour_semaine = $i, $heure2);
														}

														// pour le dimanche
														case_complexe_horaire(0, $heure2);
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

function entete_complexe_horaire(){
	global $joursem;
	global $joursem2;
	?>
		<tr class="entete_complexe_jour" style="text-align: center">
			<th class="fond-opaque" style="height: 23px;">Heure</th>
			<?php   
				for ($i=0; $i < 7; $i++) { 
					?>
						<th class="fond-fonce">
							<div> <?php echo $joursem2[$i]; ?> </div>
						</th>
					<?php
				}
			?>
		</tr>
	<?php
}                           
function case_complexe_horaire ($jour_semaine, $heure){
	global $joursem;
	global $mois;
	global $horaires;
	$creneau_rempli = 0;
	$obj_heure = DateTime::createFromFormat('H:i:s', $heure);
	foreach ($horaires as $horaire_key => $horaire_val) {
		if ($horaire_val['heure_debut'] == $heure AND $horaire_val['jour_de_la_semaine'] == $jour_semaine ) {
						$obj_heure_plage_debut = DateTime::createFromFormat('H:i:s', $horaire_val['heure_debut']);
						$obj_heure_plage_fin = DateTime::createFromFormat('H:i:s', $horaire_val['heure_fin']);
						$heure_debut_while = clone($obj_heure_plage_debut);
						$heure_fin_while = clone($obj_heure_plage_fin);

						$nb_demi_heure = 0;
						if($horaire_val['heure_fin'] == "00:00:00"){
							$heure = 24 - $obj_heure_plage_debut->format('H');
							$nb_demi_heure = $heure*2;
							if( $obj_heure_plage_debut->format('H') == "30"){
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
						?>	
							<td class="center" rowspan="<?php echo $nb_demi_heure; ?>" style="height: <?php echo $hauteur; ?>px;">
								<p class="heure_prix"><?php echo $obj_heure_plage_debut->format('H:i').' - '.$obj_heure_plage_fin->format('H:i') ?></p>
								<p class="prix">Ouvert</p>
								<?php //echo $jour_semaine ?>
							</td>
						<?php
						$creneau_rempli = 1;
						break 1;
		}
		else{
			$obj_heure_plage_debut = DateTime::createFromFormat('H:i:s', $horaire_val['heure_debut']);
			$obj_heure_plage_fin = DateTime::createFromFormat('H:i:s', $horaire_val['heure_fin']);
			if ($obj_heure > $obj_heure_plage_debut AND $obj_heure < $obj_heure_plage_fin AND $jour_semaine == $horaire_val['jour_de_la_semaine']){
				// on ne fait rien car il s'agit d'une demi heure déjà comptée au sein d'une résa
				$creneau_rempli = 1;
				break 1;
			}
		}
	}
	if ($creneau_rempli == 0){
		?>
			<td class="center" class="not_defined">
				fermé
								<?php //echo $jour_semaine ?>
			</td>
		<?php
	}
}







