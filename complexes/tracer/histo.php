<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 13/09/2017
 * Time: 16:25
 */

include "../../conf/conf.php";
$db = connexionBdd();

if (isset($_POST["id"])){
    $id = htmlspecialchars(trim($_POST["id"]));
    $req_upd_histo = $db->prepare("UPDATE historique_navigation_complexe SET fin_visite = NOW() WHERE id = :id");
    $req_upd_histo->bindValue(":id", $id, PDO::PARAM_INT);
    $req_upd_histo->execute();
}