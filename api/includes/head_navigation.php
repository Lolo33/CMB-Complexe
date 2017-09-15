<?php $url_site = "/api/"; ?>
<h4 class="nav-titre">Général</h4>
<ul class="nav nav-pills nav-stacked">
    <li <?php
    if ($url_site == $_SERVER["REQUEST_URI"])
        echo 'class="active"';
    else
        activeMenuIfContain("index"); ?>
    ><a href="index.php">Accueil</a></li>

    <?php if (estConnecte()) { ?>
        <li <?php activeMenuIfContain("api_gestion"); ?>><a href="api_gestion">Tableau de bord</a></li>
    <?php }else{ ?>
        <li <?php activeMenuIfContain("api_inscription"); ?>><a href="api_inscription">Obtenir une Clé d'API</a></li>
        <li <?php activeMenuIfContain("api_connexion"); ?>><a href="api_connexion">S'identifier</a></li>
    <?php } ?>

    <li><a href="api_conditions">Conditions d'utilisation</a></li>
</ul>

