<?php
	include '../conf/conf.php';
	$petit_malin = 0;
	if (!isset($_GET['id']) OR empty($_GET['id']) OR $_GET['id'] == 0){
		$petit_malin = 1;
	}
	if(isset($_GET['erreur'])){
		$erreur = sanitize($_GET['erreur']);
	}
	else{
		$erreur = NULL;
	}
	$_GET = sanitize_tab($_GET);
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Réserver</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="réservation de terrain de foot en salle en ligne pour application" />
	<meta name="keywords" content="planning, schedule, foot en salle, futsal, application, app, connect, reservation, reserver, terrain, soccer" />

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
	<link rel="stylesheet" href="css/style_complexe.css">
	<link rel="stylesheet" href="css/planning.css">
	<link rel="stylesheet" href="css/page_resa.css">
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
	<span id="ajax_connexion" style="display: none"></span>
		<?php
			if ($petit_malin == 1){
				?>
					<h1 class="center">Besoin d'explications peut-être? <br/> Allez plutôt voir notre <a href="../api/index.php"><h2> Documentation API</h2></a> <br/>Ca ira plus vite ^^</h1>
				<?php
			}
			else{
				$lieu_id = $_GET['id'];
				if (isset($_POST['jour'])){
					$jour = $_POST['jour'];
				}
				else{
					$jour = new DateTime;
					$jour = $jour->format('Y-m-j');
				}

				if (isset($_POST['duree'])){
					$duree = $_POST['duree'];
				}
				else{
					$duree = 60;
				}
				include 'header_resa.php'; 
				?>
					<div id="page">
						<?php include 'volet_resa.php'; ?>
						<div id="corps" class="center">
							<div id="recap_resa" class="contour-gris"><?php if(isset($_SESSION['joueur_id'])){ include'recap_resas_joueur.php'; } ?></div>
							<div id="resa_ajax"></div>
							<div id="post_planning" class="contour-gris">
								<h1>Créneaux disponibles</h1>
								<div class="ligne" >
									<?php include 'date_picker.php'; ?>
									<div id="part_planning">
										<form id="form_resa">
											<input id="input_terrain" type="hidden" name="terrain" value=""/>
											<input id="input_datetime_debut" type="hidden" name="datetime_debut" value=""/>
											<input id="input_datetime_fin" type="hidden" name="datetime_fin" value=""/>
											<h1><?php echo date_lettres2($jour); ?></h1>
											<div id="liste_terrains" class="ligne center">
												<?php
													$liste_terrains = liste_terrain_lieu($lieu_id);
													foreach ($liste_terrains as $terrain_key => $terrain_value) {
														?>
															<div class="liste center">
																<h1> <?php echo $terrain_value['terrain_nom']; ?></h1>
																<?php
																	$liste_creneaux_resa = liste_creneaux($terrain_value[0], $jour, $duree);
																	if ($liste_creneaux_resa != NULL){
																		foreach ($liste_creneaux_resa as $creneau_key => $creneau_value) {
																			$creneau_debut = date_create_from_format('Y-m-j H:i:s', $creneau_value['debut']);
																			$creneau_fin = date_create_from_format('Y-m-j H:i:s', $creneau_value['fin']);
																			?>
																				<input 
																					id="<?php echo $terrain_value[0].'_'.$creneau_debut->format('Y-m-j H:i:s'); ?>" 
																					type="radio" 
																					name="creneau" 
																					datetime_debut="<?php echo $creneau_debut->format('Y-m-j H:i:s'); ?>" 
																					datetime_debut_string="<?php echo $creneau_debut->format('H:i'); ?>" 
																					datetime_fin="<?php echo $creneau_fin->format('Y-m-j H:i:s'); ?>" 
																					datetime_fin_string="<?php echo $creneau_fin->format('H:i'); ?>"
																					terrain="<?php echo $terrain_value[0]; ?>" 
																					style="display: none;" 
																					class="input_creneau"
																				/>
																				<label for="<?php echo $terrain_value[0].'_'.$creneau_debut->format('Y-m-j H:i:s'); ?>" class="ligne center">
																					<div class="creneau center" >
																						<?php echo $creneau_debut->format('H:i').' - '.$creneau_fin->format('H:i'); ?>
																					</div>
																				</label>
																			<?php
																		}
																	}
																	else{
																		?>
																			<p>Aucune créneau dispo ce jour là</p>
																		<?php
																	}
																?>
															</div>
														<?php
													}
												?>
											</div>
										</form>
										<button id="btn_resa" class="btn btn-success" data-toggle="modal" data-target="<?php if(isset($_SESSION['joueur_id'])){ echo '#popup_confirm'; } else { echo '#modal-co'; } ?>">Réserver</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
			}
		
			//include('footer.php');
		?>	
		<div class="modal fade" id="modal-resa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-body">

					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal-co" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div id="modal-dialog" class="modal-dialog" role="document">
				<div class="modal-content">

					<div id="modal-body1" class="modal-body">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<?php
							if ($erreur == 'idmdp'){
								?>
									<p class="center">Erreur tel/mot de passe</p>
								<?php
							}
							elseif($erreur == 'vide'){
								?>
									<p class="center">erreur champ vide</p>
								<?php
							}
						?>
						<form id="form_co" class="center">
							<h1 class="center">Connexion</h1>
							<br/>
							<label class="center  ligne2">
								<span class="center span_mod-co">Téléphone:</span>
								<input class="input1 " type="text" name="tel" placeholder="Complexe_121"/>
							</label>
							<br/>
							<label class="center ligne2">
								<span class="center span_mod-co">Mot de passe:</span>
								<input class="input1 " type="password" name="mdp" placeholder="******">
							</label>
							<br/>
							<span id="btn_connexion" class="btn btn-success center btn-valid"> Se connecter </span>
							<a href="#" id="lien_inscription" style="text-align: right;">Inscription</a>
						</form>

						<form id="form_inscription" class="center" style="display: none;">
							<h1 class="center">Inscription</h1>

							<label class="ligne">
								<span class="flex1">Nom:</span>
								<input id="input_nom" class="input1 flex1" type="text" name="prenom" placeholder="Jean"/>
								<span class="flex1">
									<span id="glyph_nom_no" class="glyphicon glyphicon-remove"></span>
									<span id="glyph_nom_ok" class="glyphicon glyphicon-ok" style="display: none"></span>
								</span>
							</label>

							<label class="ligne">
								<span class="flex1">Prénom:</span>
								<input id="input_prenom" class="input1 flex1" type="text" name="nom" placeholder="Dupond"/>
								<span class="flex1">
									<span id="glyph_prenom_no" class="glyphicon glyphicon-remove"></span>
									<span id="glyph_prenom_ok" class="glyphicon glyphicon-ok" style="display: none"></span>
								</span>
							</label>

							<label class="ligne">
								<span class="flex1">Mot de passe:</span>
								<input id="input_mdp" class="input1 flex1" type="text" name="mdp" placeholder="******"/>
								<span class="flex1">
									<span id="glyph_mdp_no" class="glyphicon glyphicon-remove"></span>
									<span id="glyph_mdp_ok" class="glyphicon glyphicon-ok" style="display: none"></span>
									<span>6 caractères min.</span>
								</span>
							</label>

							<label class="ligne">
								<span class="flex1">Entrez votre numéro de téléphone :</span>
								<input class="input1 flex1" type="text" name="tel" placeholder="0638433428"/>
								<span class="flex1"><input type="submit" id="btn_tel" class="btn btn-success btn-valid" value="générer un code"/></span>
							</label>

							<p id="ajax_tel"></p>
						</form>
						<p id="ajax_inscription" style="display: none;"></p>
						<form id="form_code">
							<label id="div_code" class="ligne" style="display: none;">
								<span class="flex1">Entrez le code :</span>
								<input id="input_code" class="input1 flex1 " type="text" name="code" placeholder="3574"/>
								<span class="flex1">
									<span id="glyph_code_no" class="glyphicon glyphicon-remove"></span>
									<span id="glyph_code_ok" class="glyphicon glyphicon-ok" style="display: none"></span>
								</span>
							</label>
						</form>

						<button id="btn_valider" class="btn btn-success center btn-valid" disabled style="display: none;">valider l'inscritpion</button>
							<p id="ajax_code" style="display: none;"> 
					</div>
					<div id="modal-body2" class="modal-body" style="display: none;">
						<h1>Merci, votre inscription à bien été prise en compte</h1>
						<button class="btn btn-success" data-dismiss="modal">Retourner à la réservation</button>
					</div>
					<div id="modal-body3" class="modal-body" style="display: none;">
						<h1>Salut <?php echo $_SESSION['joueur_prenom']; ?>, t'es chaud pour jouer?</h1>
						<button class="btn btn-success" data-dismiss="modal">Je suis chaud!</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="popup_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h1 class="center">Réservation</h1>
					</div>
					<div id="modal-body-resa-1" class="modal-body espacer1" style="display: flex; flex-direction: column; align-items: center;">
						<p class="center">
							<span > Le </span>
							<span><?php echo date_lettres2($jour); ?></span>
							<br/>
							<span> de </span>
							<br/>
							<span id="heure_debut"></span>
							<span> à </span>
							<span id="heure_fin"></span>
						</p>
					</div>
					<div id="modal-body-resa-2" class="modal-body center" style="display: none;">
						<button id="btn_continuer" class="btn btn-success center">Continuer</button>
					</div>
					<div id="modal-footer-resa-1" class="modal-footer">
						<p class="center">Confirmez-vous la réservation?</p>
						<div class="ligne espacer1">
							<button class="btn btn-danger close" data-dismiss="modal">Annuler</button>
							<button id="confirm_resa" class="btn btn-success">Réserver</button>
						</div>	
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal-deco" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Confirmez-vous la déconnexion?
						<div class="ligne">
							<button class="btn btn-danger close" data-dismiss="modal">Non</button>
							<button id="btn_deconnexion" href="" data-dismiss="modal" class="btn btn-success">Oui</button>
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

		<script>
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
			  	dateFormat: 'yy-mm-dd'});
			});
		</script>
		<script>
		var test_nom = 0;
		var test_prenom = 0;
		var test_tel = 0;
		var test_code = 0;
		var test_mdp = 0;

			/* Connexion  */
			$(document).ready(function(){
			  $("#btn_connexion").click(function(){
			  	console.log('coucou55');
			    $.ajax({type:"POST", data: $('#form_co').serialize(), url:"../connexion_joueur_ajax.php",

			      success: function(data){
				    $("#ajax_connexion").html(data);
				    console.log('coucou');
			        if (connexion == 1){
			    		location.reload(); 
			        }
			      },
			      error: function(){
			      	console.log('pb');
			        $("#ajax_connexion").html('Une erreur est survenue.');
			      }
			    });
			  });
			});
			/* lien vers la partie inscription */
			$(document).ready(function(){
			 	$("#lien_inscription").click(function(){
			  		$('#form_inscription').css("display","");
			  		$('#btn_valider').css("display","");
			    	$('#form_co').css("display","none");
			    });
			});
			/* Déconnexion */
			$(document).ready(function(){
			 	$("#btn_deconnexion").click(function(){
			  		$.ajax({type:"POST", data: "NULL", url:"../deconnexion_ajax.php",
				      success: function(data){
			    		location.reload(); 
				      },
				      error: function(){
				      	console.log('pb');
				      }
				    });
				});
			});

			/* mise en place des heures dans la modal */
			$(document).ready(function(){
			 	$(".input_creneau").click(function(){
			 		heure_debut = $(this).attr("datetime_debut_string");
			 		heure_fin = $(this).attr("datetime_fin_string");
			  		$('#heure_debut').text(heure_debut);
			  		$('#heure_fin').text(heure_fin);
			    });
			});
			/* Réservation*/
			$(document).ready(function(){
			  $("#confirm_resa").click(function(){
			  		console.log('coucou');
			  		$.ajax({type:"POST", data: $('#form_resa').serialize(), url:"reserver_ajax.php",
				      success: function(data){
					    $("#resa_ajax").html(data);
				        if (resa == 1){
				        	$('#modal-body-resa-1').css("display", "none");
				        	$('#modal-footer-resa-1').css("display", "none");
				        	$('#modal-body-resa-2').css("display", "");
				        }
				      },
				      error: function(){
				      	console.log('pb');
				        $("#resa_ajax").html('Une erreur est survenue.');
				      }
				    });
			  });
			});
			/* générer le code de vérif tel */
			$(document).ready(function(){
			  $("#form_inscription").submit(function(e){
			  	e.preventDefault();
			    $.ajax({type:"POST", data: $(this).serialize(), url:"../generer_code-tel.php",
			      success: function(data){
			        $("#ajax_tel").html(data);
			        if (test_tel == 1){
			        	$('#div_code').css("display", "inline-block");
			        }
			      },
			      error: function(){
			        $("#ajax_tel").html('Une erreur est survenue.');
			      }
			    });
			  });
			});

			/* valider l'inscription finale */
			$(document).ready(function(){
			  $("#btn_valider").click(function(){
			    $.ajax({type:"POST", data: $('#form_inscription').serialize(), url:"../inscription_joueur_ajax.php",
			      success: function(data){
			      	console.log('no pb');
				    $("#ajax_inscription").html(data);
			        if (inscription == 1){
			        	$('#modal-body1').css("display", "none");
			        	$('#modal-body2').css("display", "block");
			        	$('#btn_resa').attr("data-target", "#modal-resa");
			        	$('#btn_con').css("display", "none");
			        	$('#btn_decon').css("display", "");
			        }
			      },
			      error: function(){
			      	console.log('pb');
			        $("#ajax_inscription").html('Une erreur est survenue.');
			      }
			    });
			  });
			});
			/* test en direct sur les input text X 3 */
			$(document).ready(function(){

				/* verif si au moins 1 caractère pour le nom */
			 	$("#input_nom").on("change paste keyup", function(){
			  		var nom = $("#input_nom").val();
			  		if (nom === ""){
			  			$("#glyph_nom_no").css("display", "inline-block");
			  			$("#glyph_nom_ok").css("display", "none");
			  			test_nom = 0;
			  		}
			  		else{
			  			$("#glyph_nom_ok").css("display", "inline-block");
			  			$("#glyph_nom_no").css("display", "none");
			  			test_nom = 1;

			  		}
				    btn_valider();
			    });

				/* verif si au moins 1 caractère pour le prenom */
			 	$("#input_prenom").on("change paste keyup", function(){
			  		var prenom = $("#input_prenom").val();
			  		if (prenom === ""){
			  			$("#glyph_prenom_no").css("display", "inline-block");
			  			$("#glyph_prenom_ok").css("display", "none");
			  			$('#btn_valider').disabled = true;
			  			test_prenom = 0;
			  		}
			  		else{
			  			$("#glyph_prenom_ok").css("display", "inline-block");
			  			$("#glyph_prenom_no").css("display", "none");
			  			$('#btn_valider').disabled = false;
			  			test_prenom = 1;
			  		}
				    btn_valider();
			    });

				/* verif si au moins 6 caractère pour le mdp */
			 	$("#input_mdp").on("change paste keyup", function(){
			  		var mdp = $("#input_mdp").val().length;
			  		console.log(mdp);
			  		if (mdp < 6){
			  			$("#glyph_mdp_no").css("display", "inline-block");
			  			$("#glyph_mdp_ok").css("display", "none");
			  			test_mdp = 0;
			  		}
			  		else{
			  			$("#glyph_mdp_ok").css("display", "inline-block");
			  			$("#glyph_mdp_no").css("display", "none");
			  			test_mdp = 1;
			  		}
				    btn_valider();
			    });
			});

			/* Ajax pour tester en direct le code tel*/
			$(document).ready(function(){
			 	$("#input_code").on("change paste keyup", function(){
				    $.ajax({type:"POST", data: $('#form_code').serialize(), url:"../verifier_code_tel.php",
				      success: function(data){
				        $("#ajax_code").html(data);
				        if (test_code != 1){
				  			$("#glyph_code_no").css("display", "inline-block");
				  			$("#glyph_code_ok").css("display", "none");
				  		}
				  		else{
				  			$("#glyph_code_ok").css("display", "inline-block");
				  			$("#glyph_code_no").css("display", "none");
				  		}
				      },
				      error: function(){
				        $("#ajax_code").html('Une erreur est survenue.');
				      }
				    });
				    btn_valider();
			    });
			});
			function btn_valider(){
				console.log(' nom' + test_nom + " prenom" + test_prenom + " tel" + test_tel +" code" + test_code + " mdp" + test_mdp);
				if (test_nom == 1 && test_prenom == 1 && test_tel == 1 && test_code == 1 && test_mdp == 1){
					$('#btn_valider').prop('disabled', false);
				}
				else{
					$('#btn_valider').prop('disabled', true);
				}
			}
			/* refresh après résa */
			$(document).ready(function(){
			  $("#btn_continuer").click(function(){
			    location.reload(); 
			  });
			});

			/*maj des inputs hidden */

			$(document).ready(function(){
				$('.input_creneau').click(function(){
					terrain = $(this).attr("terrain");
					$('#input_terrain').attr("value", terrain);
					datetime_debut = $(this).attr("datetime_debut");
					$('#input_datetime_debut').attr("value", datetime_debut);
					datetime_fin = $(this).attr("datetime_fin");
					$('#input_datetime_fin').attr("value", datetime_fin);
				});
			});
		</script>	
	</body>
</html>
