<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 28/08/2017
 * Time: 19:08
 */
include "includes/init.php";
?>

<html>
<head>
    <?php include "includes/head.php"; ?>
    <title>ConnectMyBooking API (<?php echo $nomSite ?>) - Récupère les horaires de nombreux complexes sportifs en France</title>
</head>

<body>

<?php
use CMB\Requetes;
use CMB\ClassesMetiers\UtilisateurApi;

require "CmbSdk/Autoloader.php";
?>

<!-- NAVBAR -->
<nav class="navbar navbar-default" style="margin: 0 0 0 300px;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?php echo $nomSite; ?></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="#">Débuter</a></li>
                <li><a href="complexes">Documentation </a></li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Saisir un mot clé...">
                </div>
                <button type="submit" class="btn btn-default">Rechercher</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <?php if (estConnecte()){ ?>
                    <li><a href="deconnexion">Déconnexion</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-3 nav-tool">
            <h2 class="titre-menu">Navigation</h2>
            <?php include 'includes/head_navigation.php'; ?>
            <h4 class="nav-titre">Documentation</h4>
            <ul class="nav nav-pills nav-stacked">
                <li><a href="complexes">Complexes</a></li>
                <li><a href="coordonnees">Coordonnees</a></li>
                <li><a href="plages-horaires">PlagesHoraires</a></li>
                <li><a href="plages-horaires-statut">PlagesHorairesStatuts</a></li>
                <li><a href="planning-tarifs">PlanningTarifs</a></li>
                <li><a href="planning-comissions">PlanningComissions</a></li>
                <li><a href="reservations">Reservations</a></li>
                <li><a href="terrains">Terrains</a></li>
                <li><a href="terrains-type">TerrainTypes</a></li>
            </ul>
        </div>

        <!-- Contenu de la page -->
        <div class="col-lg-9 cont-tool">
            <div id="contenu-doc">

                <?php if (!estConnecte()){ ?>
                <section id="inscription">
                    <div class="col-lg-6" style="padding-left: 5px;">
                        <div class="form-conteneur">
                            <form class="form-horizontal" id="form-inscription">
                                <fieldset>
                                    <legend>Créer un compte Professionnel</legend>
                                    <div id="erreur-inscription"></div>
                                    <input type="text" class="form-control" id="client_id" name="client_id" placeholder="Identifiant Client">
                                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Mot de passe">
                                    <input type="text" class="form-control" id="nomSociete" name="nomSociete" placeholder="Nom de la société">
                                    <input type="text" class="form-control" id="adresseL1" name="adresseL1" placeholder="Adresse (ligne 1)">
                                    <input type="text" class="form-control" id="adresseL2" name="adresseL2" placeholder="Adresse (ligne 2)">
                                    <input type="text" class="form-control" id="codePostal" name="codePostal" placeholder="Code postal">
                                    <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville">
                                    <input type="email" class="form-control" id="mail" name="mail" placeholder="Adresse e-mail">
                                    <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Numéro de téléphone">

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> En m'inscrivant je confirme avoir pris connaissance des
                                            <a href="conditions">conditions générales d'utilisation</a> et y adhérer sans réserve.
                                        </label>
                                    </div>

                                    <div class="btn-zone">
                                        <button type="reset" class="btn btn-default">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Obtenir une clé d'API</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-conteneur">
                            <form class="form-horizontal" id="form-connexion">
                                <fieldset>
                                    <legend>S'identifier sur ConnectMyBooking</legend>
                                    <div id="erreur-connexion"></div>
                                    <input type="text" class="form-control" id="inputClientIdCo" placeholder="Identifiant Client">
                                    <input type="password" class="form-control" id="inputPasswordCo" placeholder="Mot de passe">
                                    <div class="btn-zone"><a href="newpass">Mot de passe oublié ?</a></div>
                                    <div class="btn-zone">
                                        <button type="reset" class="btn btn-default">Annuler</button>
                                        <button type="submit" class="btn btn-primary">S'identifier</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </section>

                <?php }else{ ?>

                    <section id="gestion-api">
                        <div class="conteneur-light">
                            ClientID: <strong><?php echo $_SESSION["client_id"]; ?></strong>
                        </div>
                    </section>

                <?php } ?>

            </div>
        </div>


    </div>
</div>

<script>
    $("#form-connexion").submit(function (e) {
        e.preventDefault();
        var client_id = $("#inputClientIdCo").val();
        var pass = $("#inputPasswordCo").val();
        $.post("ajax/connexion_traitement.php", {client_id:client_id, pass:pass}, function (data) {
            $("#erreur-connexion").html(data).slideDown();
        });
    });

    $("#form-inscription").submit(function (e) {
        e.preventDefault();
        var client_id = $("#client_id").val();
        var pass = $("#pass").val();
        var nomSociete = $("#nomSociete").val();
        var adresseL1 = $("#adresseL1").val();
        var adresseL2 = $("#adresseL2").val();
        var codePostal = $("#codePostal").val();
        var ville = $("#ville").val();
        var mail = $("#mail").val();
        var telephone = $("#telephone").val();
        $.post("ajax/inscription_traitement.php", {nomSociete:nomSociete, client_id:client_id, pass:pass, adresseL1:adresseL1, adresseL2:adresseL2, codePostal:codePostal, ville:ville, mail:mail, telephone:telephone}, function(data){
            $("#erreur-inscription").html(data).slideDown();
        });
    })
</script>

</body>
</html>
