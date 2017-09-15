<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 29/08/2017
 * Time: 12:02
 */

use CmbSdk\ClassesMetiers\UtilisateurApi;

include '../includes/init.php';
require "../CmbSdk/Autoloader.php";

$userApi = new UtilisateurApi();

if (empty($_SESSION)) {
    if (!empty($_POST)) {
        if (isset($_POST["client_id"]) && isset($_POST["pass"])) {
            $client_id = htmlspecialchars(trim($_POST["client_id"]));
            $pass = htmlspecialchars(trim($_POST["pass"]));
            if (!empty($client_id) && !empty($pass)) {
                $req = $db->prepare("SELECT * FROM utilisateur_api WHERE user_client_id = :client_id");
                $req->bindValue(":client_id", $client_id, PDO::PARAM_STR);
                $req->execute();
                $client = $req->fetch();
                $userApi->setUserClientId($client["user_client_id"]);
                $userApi->setUserPassword($client["user_password"]);
                if (!empty($client)){
                    if (password_verify($pass, $userApi->getUserPassword())){
                        messageForm("Vous êtes à présent connecté! Heureux de vous revoir, " . $userApi->getUserClientId(), true);
                        $_SESSION["id"] = $client["id"];
                        $_SESSION["client_id"] = $userApi->getUserClientId();
                        echo "<script>document.location.reload();</script>";
                    }else{
                        messageForm("Vos identifiant/mot de passe ne correspondent pas.");
                    }
                }else{
                    messageForm("Cet identifiant client n'existe pas.");
                }
            } else {
                messageForm("Vous devez remplir tous les champs.");
            }
        }
    }
}