<?php

function connexionBdd()
{
    $host_name  = "localhost";
    $database   = "mate_maker_api";
    $user_name  = "root";
    $password   = "";

    try {
        $db = new PDO('mysql:host=' . $host_name . ';dbname=' . $database . ';charset=utf8', '' . $user_name . '', $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        return $db;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

?>