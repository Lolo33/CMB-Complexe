<?php
	include '../conf/conf.php';
	$id_histo = tracerComplexe();

	if (!isset($_SESSION["id"]) OR !isset($_SESSION['complexe_id'])){
		header("Location: ../index.php");
	}
	else{
		$_POST = sanitize_tab($_POST);
	}
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
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">

	<!-- Modernizr JS -->
	<script src="../js/modernizr-2.6.2.min.js"></script>

	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

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
									<h1 class="center titre_section">Guide d'utilsation de la page : Planning</h1>
								</div>
								<div class="modal-body center">
									<p>Contenu</p>
								</div>
							</div>
						</div>
					</div>
			<h1 class="titre_section">
                Planning
            </h1>
			<div id="content_tarif">
				<?php include 'volet_planning.php'; ?>
				<div id="corps" class="center effet1">
				<div id="post_planning" >
					<?php
						$format = 'Y-m-d'; 
						$lieu_id = $_SESSION['complexe_id'];
						$heure_min = 10;
						$heure_max = 24.0;
						$now = new DateTime;
						$vue = 6;
						
						// Pour le début du planning
						if (isset($_POST['jour']) AND isset($_POST['vue_semaine'])){
							$date_min = DateTime::createFromFormat('j-m-Y', $_POST['jour']);
							if ($_POST['vue_semaine'] == "0"){
								$vue = 0;
							}
							//$date_min->sub( new DateInterval('P1D'));
						}
						else{
							$date_min = new DateTime;
						/*

							$now1 = new DateTime;
							$delta_jour_debut_semaine = $now->format('N') - 1;
							$date_min	= $now1->sub(new DateInterval ('P'.$delta_jour_debut_semaine.'D'));
						*/
						}
						$semaine_prec = clone($date_min);
						$semaine_suiv = clone($date_min);
						$semaine_prec->sub( new DateInterval('P7D'));
						$semaine_suiv->add( new DateInterval('P7D'));

						$date_max = clone($date_min);
						$date_max->add( new DateInterval('P'.$vue.'D'));

						// on récupère un tableau avec la liste des terrains.
						$liste_terrains = liste_terrain_lieu($lieu_id);
						$nb_terrain = count($liste_terrains);
						
						// Pour chaque terrain, on y associes ses créneaux.
						foreach ($liste_terrains as $key => $val) {

							// Récupération des créneaux pour un terrain.
							$liste_plages_horaires = liste_plages_horaires_terrain($val[0]);

							// Ajout du tableau des créneaux dans le tableau des terrains
							$liste_terrains[$key]['plages_horaires'] = $liste_plages_horaires;
						}
					?>
					<div class="ligne espacer2">
						<div>
							<form action="planning.php" method="post">
								<input type="hidden" name="jour" value="<?php echo $semaine_prec->format('j-m-Y'); ?>">
								<input type="hidden" name="vue_semaine" value="1">
								<button class="btn_semaine" type="submit">Semaine précédente <?php echo $semaine_prec->format('j/m'); ?></button>
							</form>
						</div>
						<div>
							<span style="margin-bottom 0; color: white;font-size: 20px;">Semaine du <?php echo $date_min->format("d-m-Y") . ' au ' . $date_max->format("d-m-Y"); ?></span>
						</div>
						<div>
							<form action="planning.php" method="post">
								<input type="hidden" name="vue_semaine" value="1">
								<input type="hidden" name="jour" value="<?php echo $semaine_suiv->format('j-m-Y'); ?>">
								<button class="btn_semaine" type="submit">Semaine suivante <?php echo $semaine_suiv->format('j/m'); ?></button>
							</form>
						</div>
					</div>
					<div class="tableau center">
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
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h1 class="center">Gestion du planning</h1>
					</div>

					<div class="modal-body center">
						<form action="planning_traitement.php" method="post">
							<input type="hidden" id="input_terrain" name="terrain" value="">
							<input type="hidden" id="input_jour2" name="jour" value="">
							<div id="creneau_action" class="ligne">
								<p>Action à réaliser :</p>
								<div id="div_action" class="liste">
									<label>
										<div>
											<span>Ouvrir des créneaux à la réservation</span>
											<input id="input_action_ouvrir" class="clic-radio-1" type="radio" name="action" value="ouvrir" checked="checked">
										</div>
									</label>
									<br/>
									<label>
										<div>
											<span>Fermer des créneaux à la réservation</span>
											<input id="input_action_fermer" class="clic-radio-1" type="radio" name="action" value="fermer">
										</div>
									</label>
									<br/>
									<label>
										<div>
											<span>Entrer une réservation</span>
											<input id="input_action_reserver" class="clic-radio-1" type="radio" name="action" value="reserver">
										</div>
									</label>
								</div>
							</div>
							<hr/>
							<div id="creneau_heure" class="ligne espacer2">
								<p id="creneau_heure_div1" class="gauche">Horaires :</p>
								<div id="creneau_heure_div2" class="ligne espacer1 div1">
									<div>
										<label>
											<span>Heure de début:  </span> <br/>
											<select class="form-control" id="select_heure_debut" name="heure_debut">
												<?php
													for ($i=10.0; $i <= 24; $i = $i +0.5) {
														if (intval($i) == $i){
															if ($i < 10){
																$heure_debut = '0'.$i.':00';
															}	
															else{
																$heure_debut = $i.':00';
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
															<option id="option_debut_<?php echo $heure_debut.':00'; ?>" value="<?php echo $heure_debut.':00'; ?>"> <?php echo $heure_debut; ?> </option>
														<?php	
													}
												?>
											</select>
										</label>
									</div>
									<div>
										<label>
											<span>Heure de fin: </span> <br/>
											<select class="form-control" id="select_heure_fin" name="heure_fin">
												<?php
													for ($i=10.0; $i <= 24; $i = $i +0.5) {
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
															<option id="option_fin_<?php echo $heure_fin.':00'; ?>" value="<?php echo $heure_fin.':00'; ?>"> <?php echo $heure_fin; ?> </option>
														<?php
													}
												?>
											</select>
										</label>
									</div>
								</div>				
							</div>
							<hr/>
							<div id="creneau_resa" class="ligne" style="display: none;">
								<p id="creneau_resa_div1" class="gauche">Informations :</p>
								<div id="creneau_resa_div2" class="liste">
									<label>
										<span>Nom de Réservation:</span>
										<input type="text" class="form-control form-control1" name="input_resa_nom" placeholder="Damien">
									</label>
									<br/>
									<label>
										<span>Téléphone :</span>
										<input type="text" class="form-control form-control1" name="input_resa_tel" placeholder="0638433428">
									</label>
									<br/>
									<label>
										<span>Informations complémentaires:</span>
										<textarea rows="2" class="form-control form-control2" name="input_resa_info" placeholder="exemple: téléphone d'un autre joueur">
										</textarea>
									</label>
								</div>
							</div>
							<hr/>
							<div id="creneau_dupliquer">
								<div class="liste">
									<p class="ss-marge">Dupliquer cette action sur plusieurs semaines</p>
									<div class="ligne gauche">
										<div id="creneau_dupliquer_div1" class="gauche">
											<label>
												<span>Non</span>
												<input id="input_dupliquer_non" class="clic-radio-2" type="radio" name="dupliquer" value="0" checked="checked">
											</label>
											<br/>
											<label>
												<span>Oui</span>
												<input id="input_dupliquer_oui" class="clic-radio-2" type="radio" name="dupliquer" value="1">
											</label>
										</div>
										<div id="creneau_dupliquer_div2" style="display: none;">Jusqu'à la semaine : <br/>(inclus)</div>
										<div id="creneau_dupliquer_div3" style="display: none;">
											<select id="select_modal_semaine" class="form-control">
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
								</div>
							</div>
							<hr/>
							<input type="submit" class="btn btn-success center " value="Valider">
						</form>
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
<script>
		$('.clic-radio-1').click(function () {
			console.log("coucou");
		    var action;
		    action = $(this).attr('id');
		    if(action === "input_action_ouvrir" || action === "input_action_fermer") {
		    	$('#creneau_resa').css("display", "none");
		    }
		    if (action === "input_action_reserver") {
		    	$('#creneau_resa').css("display", "");
		    }
		});
		$('.clic-radio-2').click(function () {
			console.log("coucou");
		    var dupliquer;
		    dupliquer = $(this).attr('value');
		    if(dupliquer === "1") {
		    	$('#creneau_dupliquer_div2').css("display", "");
		    	$('#creneau_dupliquer_div3').css("display", "");
		    }
		    if (dupliquer === "0") {
		    	$('#creneau_dupliquer_div2').css("display", "none");
		    	$('#creneau_dupliquer_div3').css("display", "none");
		    }
		});
		$('.creneau_ouvert').click(function () {
			console.log("coucou_ouvert");
		    var th;
		    var jour;
		    var heure;
		    var terrain;
		    th = $(this);
		    jour = $('.creneau_jour', th).attr('value');
		    heure = $('.creneau_heure', th).attr('value');
		    terrain = $('.creneau_terrain_id', th).attr('value');
		    heure_fin = $('.creneau_heure_fin', th).attr('value');

		    $('#input_jour2').attr('value', jour);
		    $('#input_terrain').attr('value', terrain);
		    $('#select_heure_debut option[value="' + heure + '"]').prop('selected', true);
		    $('#select_heure_fin option[value="' + heure_fin + '"]').prop('selected', true);
			console.log(jour);
			console.log(heure);
			console.log(terrain);
			console.log(heure_fin);
		});
		$('.creneau_ferme').click(function () {
			console.log("coucou_fermé");
		    var th;
		    var jour;
		    var heure;
		    var terrain;
		    th = $(this);
		    jour = $('.creneau_jour', th).attr('value');
		    heure = $('.creneau_heure', th).attr('value');
		    terrain = $('.creneau_terrain_id', th).attr('value');
		    heure_fin = $('.creneau_heure_fin', th).attr('value');

		    $('#input_jour2').prop('value', jour);
		    $('#input_terrain').attr('value', terrain);
		    $('#select_heure_debut option[value="' + heure + '"]').prop('selected', true);
		    $('#select_heure_fin option[value="' + heure_fin + '"]').prop('selected', true);
			console.log(jour);
			console.log(heure);
			console.log(terrain);
			console.log(heure_fin);s
		});

		$('#annul_resa').click(function () {
		    $('#modal-body-resa-1').css("display", "none");
		    $('#modal-body-resa-2').css("display", "");
		});

	$(function() {$( "#datepicker" ).datepicker({
	    onSelect: function(date) {
	            $('#input_jour').attr("value", date);
	        },
	  	firstDay: 1,
	  	altField: "#datepicker",
	  	closeText: 'Fermer',
	  	prevText: 'Précédent',
	  	nextText: 'Suivant',
	  	currentText: 'Aujourd\'hui',
	  	monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
	  	monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
	  	dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
	  	dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
	  	dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
	  	weekHeader: 'Sem.',
	  	showOn: "button",
	  	dateFormat: 'dd-mm-yy'});
	});
</script>

	<?php include "tracer/script_bas_page.php"; ?>
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
						<th colspan="<?php echo $colspan; ?>">
							<div> 
								<span><?php echo $joursem[$jour->format('w')]; ?></span>
								<br/>
								<span><?php echo $jour->format('d'); ?></span>
								<br/>
								<span><?php echo $mois[$jour->format('m')-1]; ?></span>
							</div>
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
							<td class="td_terrain">
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

		$date_date_heure3 = DateTime::createFromFormat('Y-m-j H:i:s', $date_heure);
		$date_date_heure3->add(new DateInterval('PT60M'));

		$date_date_heure4 = DateTime::createFromFormat('Y-m-j H:i:s', $date_heure);
		$date_date_heure4->sub(new DateInterval('PT30M'));
		foreach ($liste_terrains as $terrain => $val) {
			$creneau_rempli = 0;
			foreach ($val['plages_horaires'] as $plage_key => $plage_value) {
				$date_debut = DateTime::createFromFormat('Y-m-j H:i:s', $plage_value['hor_heure_debut']);
				$date_fin = DateTime::createFromFormat('Y-m-j H:i:s', $plage_value['hor_heure_fin']);
				$hauteur = '23px';
				$date_fin2 = clone($date_fin);
				$date_fin2->sub( new DateInterval('PT30M') );

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

					$hauteur = 23*$nb_demi_heure.'px';
					$resa = recupResaById($plage_value['reservation_id'])[0];
					?>	
						<td class="creneau_resa" rowspan="<?php echo $nb_demi_heure; ?>" style="height: <?php echo $hauteur; ?>;" data-toggle="modal" data-target="#modal_creneau_reserve_<?php echo $plage_value['reservation_id']; ?>">
							<div style="margin: 0px; height: <?php echo $hauteur; ?>;">
								<p class="heure">                      
									<?php 
										$ex = explode(" ", $date_heure); 
										$ex2 = explode(":", $ex[1]);
										echo $ex2[0].':'.$ex2[1];
									?>
									<input type="hidden" class="creneau_id" value="<?php echo $plage_value['id']; ?>">
									<input type="hidden" class="creneau_id" value="<?php echo $plage_value['reservation_id']; ?>">
								</p>
								<p style="margin: 0px; vertical-align: center; padding-top: 5px;" class="heure"><?php echo $resa['res_nom_client']; ?></p>
							</div>
						</td>
							
						<div class="modal fade" id="modal_creneau_reserve_<?php echo $plage_value['reservation_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h1 class="center">Réservation #<?php echo $plage_value['reservation_id']; ?></h1>
									</div>
									<div id="modal-body-resa-1" class="modal-body center">
										<div>
											<p> Nom de réservation : <?php echo $resa['res_nom_client']; ?> </p>
											<p> Téléphone : <?php echo $resa['res_num_tel_client']; ?> </p>
											<p> Informations complémentaires : <br/><?php echo $resa['res_descriptif']; ?> </p>	
										</div>
										<button id="annul_resa" class="btn btn-danger center">Annuler la réservation</button>
									</div>
									<div id="modal-body-resa-2" class="modal-body center" style="display: none;">
										<div>
											<h1>Confirmez-vous l'annulation de la réservation ?</h1>
										</div>
										<div class="ligne espacer1">
											<a href="annuler_resa.php?id=<?php echo $resa['id']; ?>" class="btn btn-danger center" >Annuler la réservation</a>
											<button id="annul_annulation" class="btn btn-success center" data-dismiss="modal" >Ne pas annuler la réservation</button>
										</div>
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
				elseif ($plage_value['statut_id'] == "1" AND $date_date_heure >= $date_debut AND $date_date_heure2 <= $date_fin) {
					if($date_date_heure->format("i") == "00"){
						if ($date_date_heure3 <= $date_fin){
							$nb_demi_heure = 2;
						}
						else{
							$nb_demi_heure = 1;
						}
					}
					elseif($date_date_heure->format("i") == "30"){
						if ($date_date_heure4 >= $date_debut){
							$nb_demi_heure = 0;
						}
						else{
							$nb_demi_heure = 1;
						}
					}
					if($nb_demi_heure != 0){
						$hauteur_taille = $nb_demi_heure*23;
						$hauteur = $hauteur_taille.'px';
						?>
							<td rowspan="<?php echo $nb_demi_heure; ?>" class="creneau_ouvert" data-toggle="modal" data-target="#modal_creneau">
								<p style="height: <?php echo $hauteur; ?>;" class="heure">                 
									<?php 
										$ex = explode(" ", $date_heure); 
										$ex2 = explode(":", $ex[1]);
										echo $ex2[0].':'.$ex2[1];
										$date_date_heure5 = clone($date_date_heure);
										$date_date_heure5->add( new DateInterval('PT30M') );
										$date_date_heure6 = clone($date_date_heure);
										$date_date_heure6->add( new DateInterval('PT60M') );
									?>
									<input type="hidden" class="creneau_terrain_id" value="<?php echo $val[0]; ?>">
									<input type="hidden" class="creneau_heure" value="<?php echo $ex[1]; ?>">
									<input type="hidden" class="creneau_heure_fin" value="<?php if($nb_demi_heure == 1){ echo $date_date_heure5->format('H:i:s'); } else { echo $date_date_heure6->format('H:i:s'); } ?>">
									<input type="hidden" class="creneau_jour" value="<?php echo $ex[0]; ?>">
								</p>
							</td>
						<?php
					}
					$creneau_rempli = 1;
					unset($date_date_heure5);
					unset($date_date_heure6);
					break 1;		
				}
			}
			if ($creneau_rempli == 0){
				if($date_date_heure->format("i") == "00"){
					$nb_demi_heure = 2;
					$date_date_heure2 = clone($date_date_heure);
					$date_date_heure2->add( new DateInterval('PT30M') );
					foreach ($val['plages_horaires'] as $plage2_key => $plage2_value) {
						$date_debut = DateTime::createFromFormat('Y-m-j H:i:s', $plage2_value['hor_heure_debut']);
						$date_fin = DateTime::createFromFormat('Y-m-j H:i:s', $plage2_value['hor_heure_fin']);
						if (($plage2_value['statut_id'] == "3" OR $plage2_value['statut_id'] == "1") AND $date_date_heure2 >= $date_debut AND $date_date_heure2 < $date_fin){
							$nb_demi_heure = 1;
							break 1;
						}
					}
				}
				elseif($date_date_heure->format("i") == "30"){
					$nb_demi_heure = 0;
					$date_date_heure2 = clone($date_date_heure);
					$date_date_heure2->sub( new DateInterval('PT30M') );
					foreach ($val['plages_horaires'] as $plage2_key => $plage2_value) {
						$date_debut = DateTime::createFromFormat('Y-m-j H:i:s', $plage2_value['hor_heure_debut']);
						$date_fin = DateTime::createFromFormat('Y-m-j H:i:s', $plage2_value['hor_heure_fin']);
						if (($plage2_value['statut_id'] == "3" OR $plage2_value['statut_id'] == "1") AND $date_date_heure2 >= $date_debut AND $date_date_heure2 < $date_fin){
							$nb_demi_heure = 1;
							break 1;
						}
					}
				}
				if($nb_demi_heure != 0){
					$hauteur_taille = $nb_demi_heure*23;
					$hauteur = $hauteur_taille.'px';
					?>
						<td rowspan="<?php echo $nb_demi_heure; ?>" class="creneau_ferme" data-toggle="modal" data-target="#modal_creneau">
							<p style="height: <?php echo $hauteur; ?>;" class="heure">                    
								<?php 
									$ex = explode(" ", $date_heure); 
									$ex2 = explode(":", $ex[1]);
									echo $ex2[0].':'.$ex2[1];
										$date_date_heure5 = clone($date_date_heure);
										$date_date_heure5->add( new DateInterval('PT30M') );
										$date_date_heure6 = clone($date_date_heure);
										$date_date_heure6->add( new DateInterval('PT60M') );
								?>
									<input type="hidden" class="creneau_terrain_id" value="<?php echo $val[0]; ?>">
									<input type="hidden" class="creneau_heure" value="<?php echo $ex[1]; ?>">
									<input type="hidden" class="creneau_heure_fin" value="<?php if($nb_demi_heure == 1){ echo $date_date_heure5->format('H:i:s'); } else { echo $date_date_heure6->format('H:i:s'); } ?>">
									<input type="hidden" class="creneau_jour" value="<?php echo $ex[0]; ?>">
							</p>		
						</td>
					<?php
					unset($date_date_heure5);
					unset($date_date_heure6);
				}
			}
		}
}
?>
