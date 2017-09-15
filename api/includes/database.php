<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 30/08/2017
 * Time: 03:39
 */

function getConnexion(){
    $hote = "localhost";
    $db = "mate_maker_api";
    $user = "root";
    $pass = "";
    try {
        $db = new PDO('mysql:host=' . $hote . ';dbname=' . $db . ';charset=utf8', '' . $user . '', $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        return $db;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}