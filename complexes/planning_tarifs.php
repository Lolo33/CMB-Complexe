
<?php
	include '../conf/conf.php';

	if (!isset($_SESSION["id"])){
		header("Location: ../index.php");
	}
	$joursem = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
	$lieu_id = 1;
	$liste_aa = liste_aa();
	$liste_terrains = liste_terrain_lieu($lieu_id);
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


	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,400italic,700' rel='stylesheet' type='text/css'>
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="../css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="../css/icomoon.css">
	<!-- Simple Line Icons -->
	<link rel="stylesheet" href="../css/simple-line-icons.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="css/planning.css">
	<link rel="stylesheet" href="css/style_complexe.css">

	<!-- Modernizr JS -->
	<script src="../js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
		<?php //include('head.php'); ?>
		<title>Planning</title>
		
	</head>
	<body>
			<?php include 'volet.php'; ?>
		<div id="page">
			<?php include 'volet_tarifs.php'; ?>
			<div id="corps" class="center">
				<div id="post_planning">
					<?php 
						//$lieu_id = $_SESSION['gerant_lieu_id'];
						$heure_min = 10;
						$heure_max = 24.0;
						
					?>
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
										?>
											<tr>
												<td class="heure"><?php echo intval($heure).':'.$minutes;?></td>
												<?php
													for ($i=1; $i < 7; $i++) { 
														$datetime_string = intval($heure).':'.$minutes.':00';
														$heure2 = intval($heure).":".$minutes.":00";
														case_complexe_commission($jour_semaine = $i, $heure2, $liste_terrains);
													}

													// pour le dimanche
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
			</div>
		</div>

		<?php include "tracer/script_bas_page.php"; ?>
	</body>
</html> 
<?php

function entete_complexe_commission($tab_terrains){
	global $liste_aa;
	$db = connexionBdd();
	$joursem = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
	$joursem2 = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi','dimanche');
	$colspan = count($tab_terrains);
	?>
		<tr class="entete_complexe_jour" style="text-align: center">
			<th rowspan="2" style="height: 46px;">Heure</th>
			<?php   
				for ($i=0; $i < 7; $i++) { 
					?>
						<th  colspan="<?php echo $colspan; ?>">
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
	$joursem = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
	$mois = array("janvier", "fevrier", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "decembre");
	$obj_heure = DateTime::createFromFormat('H:i:s', $heure);
	foreach ($liste_terrains as $terrain => $val) {
		$liste_tarifs_terrain = liste_tarifs_terrain($val[0]);
			$creneau_rempli = 0;
				foreach ($liste_tarifs_terrain as $tarif_key => $tarif_value) {

					$obj_heure_plage_debut = DateTime::createFromFormat('H:i:s', $tarif_value['tarif_heure_debut']);
					$obj_heure_plage_fin = DateTime::createFromFormat('H:i:s', $tarif_value['tarif_heure_fin']);
					$heure_debut_while = clone($obj_heure_plage_debut);
					$heure_fin_while = clone($obj_heure_plage_fin);
					if ($tarif_value['tarif_heure_debut'] == $heure AND $tarif_value['tarif_jour'] == $jour_semaine ) {
						$nb_demi_heure = 0;
						while ($heure_debut_while < $heure_fin_while) {
							$heure_debut_while->add(new DateInterval('PT30M'));
							$nb_demi_heure++;
						};

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
					elseif ($obj_heure > $obj_heure_plage_debut AND $obj_heure < $obj_heure_plage_fin AND $jour_semaine == $tarif_value['tarif_jour']){
						// on ne fait rien car il s'agit d'une demi heure déjà comptée au sein d'une résa
						$creneau_rempli = 1;
						break 1;
					}
				}
			if ($creneau_rempli == 0){
				?>
					<td class="center" style="margin: 0px; padding: 0px; border: solid 1px black; height: 23px">
						Non défini
					</td>
				<?php
			}
	}
}







