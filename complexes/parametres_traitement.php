<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 14/09/2017
 * Time: 19:46
 */

include "../conf/conf.php";
$db = connexionBdd();


if (!empty($_POST)){
    $nom = htmlspecialchars(trim($_POST["nom"]));
    $adresseL1 = htmlspecialchars(trim($_POST["adresseL1"]));
    $adresseL2 = htmlspecialchars(trim($_POST["adresseL2"]));
    $cp = htmlspecialchars(trim($_POST["cp"]));
    $ville = htmlspecialchars(trim($_POST["ville"]));
    $mail = htmlspecialchars(trim($_POST["mail"]));
    $tel = htmlspecialchars(trim($_POST["tel"]));
    $id = htmlspecialchars(trim($_SESSION["lieu_id"]));

    if (!empty($nom) && !empty($adresseL1) && !empty($cp) && !empty($ville) && !empty($mail) && !empty($tel)){
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)){

            $lieu = recupLieuById($id);
            $id_coord = $lieu["id"];
            $req = $db->prepare("UPDATE complexe SET lieu_nom = :nom WHERE id = :id");
            $req->bindValue(":id",$id, PDO::PARAM_INT);
            $req->bindValue(":nom", $nom, PDO::PARAM_STR);
            if ($req->execute()) {
                $req_ajout_coord = $db->prepare("UPDATE coordonnee SET 
                id = :id_coord, 
                adresse_ligne1 = :adresseL1, 
                adresse_ligne2 = :adresseL2, 
                ville = :ville, 
                code_postal = :cp,
                mail = :mail, 
                telephone = :tel 
                WHERE id = :id_coord");
                $req_ajout_coord->bindValue(":id_coord", $id_coord, PDO::PARAM_INT);
                $req_ajout_coord->bindValue(":adresseL1", $adresseL1, PDO::PARAM_STR);
                $req_ajout_coord->bindValue(":adresseL2", $adresseL2, PDO::PARAM_STR);
                $req_ajout_coord->bindValue(":ville", $ville, PDO::PARAM_STR);
                $req_ajout_coord->bindValue(":cp", $cp, PDO::PARAM_STR);
                $req_ajout_coord->bindValue(":mail", $mail, PDO::PARAM_STR);
                $req_ajout_coord->bindValue(":tel", $tel, PDO::PARAM_STR);
                if ($req_ajout_coord->execute())
                    header("Location: parametres.php");
                else
                    echo "Une erreur innatendue s'est produite";
            } else
                echo "Une erreur innatendue s'est produite";

        }else{
            echo "L'adresse mail saisie n'est pas valide";
        }
    }else{
        echo "Vous devez remplir les champs obligatoires marqués d'un *";
    }
}