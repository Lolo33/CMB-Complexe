<?php
	include '../conf/conf.php';

	if (!isset($_SESSION["id"]) OR !isset($_SESSION['lieu_id'])){
		header("Location: ../index.php");
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
			<?php //include 'volet_parametre.php'; ?>
			<div id="corps" class="center">
			<div id="corps" class="text-center center">
				<h1>Gestion des paramètres</h1>
                <?php $lieu = recupLieuById($_SESSION["lieu_id"]); ?>
				<form method="post" action="parametres_traitement.php">
                    <input class="form-control" name="nom" placeholder="Nom du complexe" value="<?php echo $lieu["lieu_nom"]; ?>"/>
                    <input class="form-control" name="adresseL1" placeholder="Adresse du complexe" value="<?php echo $lieu["adresse_ligne1"]; ?>"/>
                    <input class="form-control" name="adresseL2" placeholder="Adresse du complexe (suite)" value="<?php echo $lieu["adresse_ligne2"]; ?>"/>
                    <input class="form-control" name="cp" placeholder="Code postal" value="<?php echo $lieu["code_postal"]; ?>"/>
                    <input class="form-control" name="ville" placeholder="Ville" value="<?php echo $lieu["ville"]; ?>"/>
                    <input class="form-control" name="mail" placeholder="Adresse e-mail" value="<?php echo $lieu["mail"]; ?>"/>
                    <input class="form-control" name="tel" placeholder="N° de télephone" value="<?php echo $lieu["telephone"]; ?>"/>

                    <div class="form-group">
                        <button type="reset" class="btn btn-default">Annuler</button>
                        <button type="submit" class="btn btn-success">Valider ces changements</button>
                    </div>
                </form>
			</div>
		</div>
		<?php //include('footer.php') ?>

	<!-- jQuery -->
	<script src="../js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="../js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="../js/bootstrap.min.js"></script>
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
	</script>
	</body>
</html>
