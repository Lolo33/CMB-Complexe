<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 11/09/2017
 * Time: 05:56
 */

function connexionBdd(){
    $hote = "db695868253.db.1and1.com";
    $db = "db695868253";
    $user = "dbo695868253";
    $pass = "Matemaker33!";
    try {
        $bdd = new PDO('mysql:host='.$hote.';dbname='.$db.';charset=utf8', $user, $pass);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    } catch (Exception $e) {
        die('<b>Erreur de connexion à la Bdd :</b> <br>' . $e->getMessage());
    }
}