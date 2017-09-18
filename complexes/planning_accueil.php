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


	</head>
	<body>
		<?php include 'volet.php'; ?>
		<div id="page_principale" class="effet1">
					<div>
						<button id="aide" data-toggle="modal" data-target="#modal_aide">
							<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
							<span>Aide</span>
						</button>
					</div>
					<div class="modal fade" id="modal_aide" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<br/>
									<h1 class="center titre_section">Guide d'utilsation de la page : Accueil</h1>
								</div>
								<div class="modal-body center">
									<p>Contenu</p>
								</div>
							</div>
						</div>
					</div>
					<br/>
			<h1 class="titre_section">Accueil</h1>
			<div id="content_accueil">
				<div class="section_accueil_1">
					<p>Vos prochaines réservations</p>
					<div class="sous-section-accueil">
						<?php
							$i = 0;
							$liste_resa = liste_resa_complexe($_SESSION['complexe_id']);
							foreach ($liste_resa as $resa_key => $resa_value) {
								$i++;
								?>
									<div class="ligne espacer1">
										<span><?php echo $resa_value['hor_heure_debut']; ?></span>
										<span><?php echo $resa_value['res_nom_client']; ?></span>
										<span><?php echo $resa_value['res_num_tel_client']; ?></span>
									</div>
								<?php
								if ($i >= 5){
									break 1;
								}
							}
							if ($i == 0){
								echo "Vous n'avez aucune réservation à venir";
							}
						?>
					</div>
				</div>
				<div class="section_accueil_1">
					<p>Vos dernières notifications</p>
					<div class="sous-section-accueil">
						<?php
							/*
							$i = 0;
							$liste_resa = liste_resa_complexe($_SESSION['complexe_id']);
							foreach ($liste_resa as $resa_key => $resa_value) {
								$i++;
								?>
									<div class="ligne espacer1">
										<span><?php echo $resa_value['hor_heure_debut']; ?></span>
										<span><?php echo $resa_value['res_nom_client']; ?></span>
										<span><?php echo $resa_value['res_num_tel_client']; ?></span>
									</div>
								<?php
								if ($i >= 5){
									break 1;
								}
							}
							if ($i == 0){
								echo "Vous n'avez aucune notifications";
							}
							*/
						?>
					</div>
				</div>
				<div class="section_accueil_1">
					<p>Les actualités CMB</p>
					<div class="sous-section-accueil">
						<?php
							/*
							$i = 0;
							$liste_resa = liste_resa_complexe($_SESSION['complexe_id']);
							foreach ($liste_resa as $resa_key => $resa_value) {
								$i++;
								?>
									<div class="ligne espacer1">
										<span><?php echo $resa_value['hor_heure_debut']; ?></span>
										<span><?php echo $resa_value['res_nom_client']; ?></span>
										<span><?php echo $resa_value['res_num_tel_client']; ?></span>
									</div>
								<?php
								if ($i >= 5){
									break 1;
								}
							}
							if ($i == 0){
								echo "Vous n'avez aucune notifications";
							}
							*/
						?>
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
	</body>
</html>