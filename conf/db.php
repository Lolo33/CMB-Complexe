<?php

function connexionBdd(){
    $hote = "db695868253.db.1and1.com";
    $db = "db695868253";
    $user = "dbo695868253";
    $pass = "Matemaker33!";
    $hote = "localhost";
    $db = "mate_maker_api";
    $user = "root";
    $pass = "";
    try {
        $bdd = new PDO('mysql:host='.$hote.';dbname='.$db.';charset=utf8', $user, $pass);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    } catch (Exception $e) {
        die('<b>Erreur de connexion à la Bdd :</b> <br>' . $e->getMessage());
    }
}

?>