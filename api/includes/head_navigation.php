<?php $url_site = "/api_doc/"; ?>
<h4 class="nav-titre">Général</h4>
<ul class="nav nav-pills nav-stacked">
    <?php if (estConnecte()) { ?>
        <li><a href="index">Tableau de bord</a></li>
        <li><a href="debuter">Débuter avec CMB-API</a></li>
    <?php }else{ ?>
        <li <?php
        if ($url_site == $_SERVER["REQUEST_URI"])
            echo 'class="active"';
        else
            activeMenuIfContain("index"); ?>
        ><a href="index.php">CMB-API</a></li>
    <?php } ?>
    <li><a href="conditions">Conditions d'utilisation</a></li>
</ul>

