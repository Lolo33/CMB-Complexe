<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 29/08/2017
 * Time: 14:46
 */

use CmbSdk\CmbApi;
use CmbSdk\ClassesMetiers\UtilisateurApi;
use CmbSdk\ClassesMetiers\Coordonnee;

include '../includes/init.php';
require "../CmbSdk/Autoloader.php";

$userApi = new UtilisateurApi();
$CmbApi = new CmbApi(CmbApi::TEST_URL,  "ZwbyKi5TGaXT5q9tflMO73iXxHyrE0XNuZJiRC61pmW49rCA3WeAfqx9NpilI2jx6iw=");

if (empty($_SESSION)) {
    if (!empty($_POST)) {

        /// On vérifie qu'on possède bien les bons champs dans la requete
        if (isset($_POST["client_id"]) && isset($_POST["pass"]) && isset($_POST["nomSociete"]) && isset($_POST["adresseL1"]) &&
            isset($_POST["ville"]) && isset($_POST["codePostal"]) && isset($_POST["telephone"]) && isset($_POST["mail"])) {

            /// Sécurisation des variables
            $clientId = htmlspecialchars(trim($_POST["client_id"]));
            $pass = htmlspecialchars(trim($_POST["pass"]));
            $nomSociete = htmlspecialchars(trim($_POST["nomSociete"]));
            $adresseL1 = htmlspecialchars(trim($_POST["adresseL1"]));
            if (isset($_POST["adresseL2"]))
                $adresseL2 = htmlspecialchars(trim($_POST["adresseL2"]));
            else
                $adresseL2 = null;
            $ville = htmlspecialchars(trim($_POST["ville"]));
            $cp = htmlspecialchars(trim($_POST["codePostal"]));
            $tel = htmlspecialchars(trim($_POST["telephone"]));
            $mail = htmlspecialchars(trim($_POST["mail"]));

            /// On vérifie que les champs obligatoires ne sont pas vides
            if (!empty($clientId) && !empty($pass) && !empty($nomSociete) && !empty($adresseL1) && !empty($ville) && !empty($cp)
                && !empty($mail) && !empty($tel)) {

                /// Vérifications de fiabilité des informations
                if (strlen($pass) >= 6) {
                    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                        if (filter_var($tel, FILTER_SANITIZE_NUMBER_INT)) {

                            try {

                                /// On donne les valeurs à notre utilisateur
                                $userApi->setUserClientId($clientId);
                                $userApi->setUserPassword($pass);
                                $userApi->setNomSociete($nomSociete);
                                $coordonnees = new Coordonnee();
                                $coordonnees->setAdresseLigne1($adresseL1);
                                $coordonnees->setAdresseLigne2($adresseL2);
                                $coordonnees->setVille($ville);
                                $coordonnees->setCodePostal($cp);
                                $coordonnees->setTelephone($tel);
                                $userApi->setCoordonnee($coordonnees);
                                /// Création de l'utilisateur (Ajout dans la base)
                                $newUser = $CmbApi->UtilisateursAction->Creer($userApi);
                                messageForm("Vous etes maintenant enregistré !", true);

                                /// Mise à jour des données de session de l'utilisateur maintenant connecté - Redirection
                                $_SESSION["id"] = $newUser->getId();
                                $_SESSION["client_id"] = $newUser->getUserClientId();
                                echo "<script>document.location.reload();</script>";

                            /// On catch les erreurs éventuelles de requête (code 500 / 401 / 403 / 404 etc...)
                            } catch (\CmbSdk\Exceptions\ReponseException $ex) {
                                messageForm($ex->getMessage());
                            }

                        } else {
                            messageForm("Votre numéro doit etre composé uniquement de chiffres.");
                        }
                    } else {
                        messageForm("Le format de votre adresse mail n'est pas correct.");
                    }
                } else {
                    messageForm("Votre mot de passe doit contenir au moins 6 caractères.");
                }

            } else {
                messageForm("Vous devez remplir tous les champs obligatoires.");
            }

        }
    }
}