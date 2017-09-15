<div id="header_page_resa" class="ligne espacer2" style="height: 100px;">
<?php 
	$complexeID = sanitize($_GET['id']);
	$complexe = recupComplexeByID($complexeID);

?>
	<div style="flex:1">
		<img src="../images/imageedit_3_3588628750.png" alt="ConnectMyBooking" style="height: 70px;">
	</div>
	<div style="flex:1" class="center">
		<h1><?php if (!empty($complexe)){ echo $complexe['lieu_nom']; } ?></h1>
	</div>
	<div id="header_co" style="flex:1">
		<a href="#" id="btn_con" data-toggle="modal" data-target="#modal-co" class="btn btn-success"<?php if (isset($_SESSION['joueur_id'])){ echo 'style="display: none;"' ; } ?>>Connexion / Inscription</a>
		<a href="#" id="btn_decon" data-toggle="modal" data-target="#modal-deco" class="btn btn-success" <?php if (!isset($_SESSION['joueur_id'])){ echo 'style="display: none;"' ; } ?>>Déconnexion</a>
	</div>
	
</div>