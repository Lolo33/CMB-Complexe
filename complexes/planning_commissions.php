<?php
	include '../conf/conf.php';
	
	if (!isset($_SESSION["id"])){
		header("Location: ../index.php");
	}
	
	$joursem = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
	$lieu_id = 1;
	$liste_aa = liste_aa();
	$liste_terrains = liste_terrain_lieu($lieu_id);
	foreach ($liste_terrains as $terrain_key => $terrain_value) {
		foreach ($liste_aa as $aa_key => $aa_value) {
			$liste_commissions_terrain_aa[$terrain_value[0]][$aa_value[0]]['liste_com'] = liste_commissions_terrain_aa($terrain_value[0], $aa_value[0]);
		}
	}
    $id_histo = tracerComplexe();
	//var_dump($liste_commissions_terrain_aa[1][2]);
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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Template by FREEHTML5.CO" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	<meta name="author" content="FREEHTML5.CO" />

        <script src="../js/jquery.min.js"></script>
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
	<body>
		<?php include 'volet.php'; ?>
		<div id="page">
			<?php include 'volet_commission.php'; ?>
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
				<div id="formulaire_commisssions">
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
	$colspan1 = count($liste_aa)*count($tab_terrains);
	$colspan2 = count($liste_aa);
	?>
		<tr class="entete_complexe_jour" style="text-align: center">
			<th rowspan="2" style="height: 46px;">Heure</th>
			<?php   
				for ($i=0; $i < 7; $i++) { 
					?>
						<th  colspan="<?php echo $colspan1; ?>" style="height: 23px;">
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
							<td colspan="<?php echo $colspan2; ?>" style="height: 23px;">
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
						$hauteur = $hauteur.'px';
						if($plage_com_value['com_montant'] == 0 ){
							$nv_com = 1;
						}
						elseif($plage_com_value['com_montant'] <= 5 ){
							$nv_com = 2;
						}
						elseif($plage_com_value['com_montant'] <= 10 ){
							$nv_com = 3;
						}
						elseif($plage_com_value['com_montant'] <= 15 ){
							$nv_com = 4;
						}
						elseif($plage_com_value['com_montant'] <= 20 ){
							$nv_com = 5;
						}
						elseif($plage_com_value['com_montant'] <= 25 ){
							$nv_com = 6;
						}
						else{
							$nv_com = 7;
						}
						?>	
							<td class="center <?php echo 'td_'.$nv_com; ?>" rowspan="<?php echo $nb_demi_heure; ?>" style="height: <?php echo $hauteur; ?>px;">
								<p class="heure_prix"><?php echo $obj_heure_plage_debut->format('H:i').'<br/> - <br/>'.$obj_heure_plage_fin->format('H:i') ?></p>
								<p class="prix"><?php echo $plage_com_value['com_montant'].' %'; ?></p>
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
					<td style="margin: 0px; padding: 0px; border: solid 1px black; height: 23px;">
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







