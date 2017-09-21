<?php

session_start();
include 'db.php';

global $db;
global $param;

function tracerComplexe(){
   $db = connexionBdd();
   $req = $db->query("SELECT * FROM historique_navigation_complexe;");
   $req->execute();
   $id_histo = $req->rowCount() + 1;
   $req_ajout = $db->prepare("INSERT INTO historique_navigation_complexe (id, complexe_id, url, debut_visite, ip) VALUES (:id, :idcomplexe, :url, NOW(), :ip)");
   $req_ajout->bindValue(":id", $id_histo, PDO::PARAM_INT);
   $req_ajout->bindValue(":idcomplexe", $_SESSION["complexe_id"], PDO::PARAM_INT);
   $req_ajout->bindValue(":url", $_SERVER["REQUEST_URI"], PDO::PARAM_STR);
   $req_ajout->bindValue(":ip", $_SERVER["REMOTE_ADDR"], PDO::PARAM_STR);
   $req_ajout->execute();
   return $id_histo;
}

function activeMenuIfContain($chaine){
    $url = $_SERVER["REQUEST_URI"];
    if (stripos($url, $chaine))
        echo 'class="active"';
    else
        echo "";
}
/* ----------------------------------------------------						Fonctions générales					 ------------------------------------- */

function sanitize($input) {
    return htmlspecialchars(trim($input));
}
function sanitize_tab($input) {
    return array_map('sanitize', $input);
}
function date_lettres($date){
    $date_tab = explode("-", $date);
    $jour = $date_tab[0];
    $mois = $date_tab[2];

	$liste_jours[0] = "Dimanche";
	$liste_jours[1] = "Lundi";
	$liste_jours[2] = "Mardi";
	$liste_jours[3] = "Mercredi";
	$liste_jours[4] = "Jeudi";
	$liste_jours[5] = "Vendredi";
	$liste_jours[6] = "Samedi";
	
	$liste_mois[1] = "Janvier";
	$liste_mois[2] = "Février";
	$liste_mois[3] = "Mars";
	$liste_mois[4] = "Avril";
	$liste_mois[5] = "Mai";
	$liste_mois[6] = "Juin";
	$liste_mois[7] = "Juillet";
	$liste_mois[8] = "Août";
	$liste_mois[9] = "Septembre";
	$liste_mois[10] = "Octobre";
	$liste_mois[11] = "Novembre";
	$liste_mois[12] = "Décembre";

	foreach ($liste_jours as $k => $unJour){
	    if ($k == $jour){
	        $jour = $unJour;
        }
    }
    foreach ($liste_mois as $k => $unMois){
        if ($k == $mois){
            $mois = $unMois;
        }
    }

    $date = $jour . " " . $date_tab[1] . " " . $mois;
	return $date;
}
function date_lettres2($date){
    $date_tab = explode("-", $date);
    $jour = $date_tab[2];
    $mois = $date_tab[1];

    $liste_jours[0] = "Dimanche";
    $liste_jours[1] = "Lundi";
    $liste_jours[2] = "Mardi";
    $liste_jours[3] = "Mercredi";
    $liste_jours[4] = "Jeudi";
    $liste_jours[5] = "Vendredi";
    $liste_jours[6] = "Samedi";
    
    $liste_mois[1] = "Janvier";
    $liste_mois[2] = "Février";
    $liste_mois[3] = "Mars";
    $liste_mois[4] = "Avril";
    $liste_mois[5] = "Mai";
    $liste_mois[6] = "Juin";
    $liste_mois[7] = "Juillet";
    $liste_mois[8] = "Août";
    $liste_mois[9] = "Septembre";
    $liste_mois[10] = "Octobre";
    $liste_mois[11] = "Novembre";
    $liste_mois[12] = "Décembre";

    foreach ($liste_jours as $k => $unJour){
        if ($k == $jour){
            $jour = $unJour;
        }
    }
    foreach ($liste_mois as $k => $unMois){
        if ($k == $mois){
            $mois = $unMois;
        }
    }

    $date = $jour . " " . $mois . " " . $date_tab[0];
    return $date;
}
/* ----------------------------------------------------						Fonctions relatives aux joueurs					 ------------------------------------- */
function connexion($id, $mdp){
	$id = sanitize($id);
	$mdp = sanitize($mdp);

	$db = connexionBdd();
	$req = $db->prepare('SELECT * FROM complexe_gerant WHERE gerant_username = :id AND gerant_password = :mdp');
	$req->bindValue(":id", $id, PDO::PARAM_INT);
	$req->bindValue(":mdp", $mdp, PDO::PARAM_STR);
	$req->execute();
	$res = $req->fetch();
	$co = false;
	if (empty($res)){
		$req1 = $db->prepare('SELECT * FROM utilisateur_api WHERE user_client_id = :id AND user_password = :mdp');
		$req1->bindValue(":id", $id, PDO::PARAM_INT);
		$req1->bindValue(":mdp", $mdp, PDO::PARAM_STR);
		$req1->execute();
		$res1 = $req1->fetch();

		if (empty($res1)){
			//test membre mate-maker
		}
		else{
			//variables de session pour un aa
			$_SESSION['profil_user'] ="aa";
			$_SESSION['id'] = $res1['id'];
			$_SESSION['coordonnees_id'] = $res1['coordonnee_id'];
			$_SESSION['user_client_id'] = $res1['user_client_id'];
			$_SESSION['nom'] = $res1['nom'];
			$co = true;
		}
	}
	else{
		//variables de session pour un complexe
			$_SESSION['profil_user'] ="complexe";
			$_SESSION['id'] = $res['id'];
			$_SESSION['complexe_id'] = $res['complexe_id'];
			$_SESSION['user_nom'] = $res['gerant_username'];
		$co = true;
	}

	return $co;
}

function test_format_tel($tel){
    $erreur = 0;
    $longueur = strlen($tel);
    if ($longueur == 10){
            for ($i=0; $i < $longueur; $i++){
                $chiffre = $tel[$i];
                if ($i == 0){
                    if ($chiffre != 0){
                        $erreur= 1;
                    }
                }
                elseif ($i == 1) {
                    if ($chiffre != 6 AND $chiffre != 7){
                        $erreur= 1;
                    }
                }
                else{
                    if ($chiffre != 0 AND $chiffre != 1 AND $chiffre != 2 AND $chiffre != 3 AND $chiffre != 4 AND $chiffre != 5 AND $chiffre != 6 AND $chiffre != 7 AND $chiffre != 8 AND $chiffre != 9){
                        $erreur = 1;
                    }
                }
            }
    }
    else{
        $erreur = 1;
    }
    if ($erreur == 1) {
        return false;
    }
    else{
        return true;
    }
}
function test_format_mdp($mdp){
	return true;
}
function pseudo_libre($pseudo){
	$db = connexionBdd();
	$req = $db->prepare('SELECT * FROM joueurs WHERE pseudo = :pseudo');
	$req->bindValue(":pseudo", $pseudo, PDO::PARAM_STR);
	$req->execute();
	$res = $req->fetch();
	if (empty($res)){
		return true;
	}
	else{
		return false;
	}
}
function inscrire_joueur($tel, $mdp, $nom, $prenom){
	$db = connexionBdd();
	$req = $db->prepare('INSERT INTO joueur(numero_tel, password, nom, prenom) VALUES(:tel, :mdp, :nom, :prenom)');
	$req->bindValue(':tel', $tel, PDO::PARAM_STR);
	$req->bindValue(':mdp', $mdp, PDO::PARAM_STR); 
	$req->bindValue(':nom', $nom, PDO::PARAM_STR);
	$req->bindValue(':prenom', $prenom, PDO::PARAM_STR);
	$req->execute();

	$req1 = $db->prepare('SELECT * FROM joueur WHERE numero_tel = :tel AND password = :mdp');
	$req1->bindValue(':tel', $tel, PDO::PARAM_STR);
	$req1->bindValue(':mdp', $mdp, PDO::PARAM_STR);
	$req1->execute();
	$res1 = $req1->fetch();
	if (!empty($res1)){
		$_SESSION['joueur_id'] = $res1['id'];
		$_SESSION['joueur_nom'] = $res1['nom'];
		$_SESSION['joueur_prenom'] = $res1['prenom'];
		$_SESSION['joueur_tel'] = $res1['numero_tel'];
	}
}
function connexion_joueur($tel, $mdp){
	$db = connexionBdd();
	$req1 = $db -> prepare('SELECT * FROM joueur WHERE password = :mdp AND numero_tel = :tel');
	$req1 -> bindValue(':mdp', $mdp, PDO::PARAM_STR);
	$req1 -> bindValue(':tel', $tel, PDO::PARAM_STR);
	$req1 -> execute();
	$res1 = $req1->fetch();
	$_SESSION['joueur_id'] = $res1['id'];
	$_SESSION['joueur_nom'] = $res1['nom'];
	$_SESSION['joueur_prenom'] = $res1['prenom'];
	$_SESSION['joueur_tel'] = $res1['numero_tel'];
	return $res1;
}
function liste_resa_joueur($tel){
	$db = connexionBdd();
	$req = $db->prepare('SELECT * FROM reservation INNER JOIN plage_horaire ON reservation.id = plage_horaire.reservation_id WHERE res_num_tel_client = :tel');
	$req->bindValue(':tel', $tel, PDO::PARAM_STR);
	$req->execute();
	return $req->fetchAll();
}
/* ----------------------------------------------------					Fonctions relatives aux AA		 		 ------------------------------------- */

function liste_aa(){
	$db = connexionBdd();
	$req = $db->prepare('SELECT * FROM utilisateur_api');
	$req->execute();
	return $req->fetchAll();
}

/* ----------------------------------------------------					Fonctions relatives aux complexes		 		 ------------------------------------- */

function liste_terrain_lieu($complexe_id){
	$db = connexionBdd();
	$req = $db->prepare('SELECT * FROM  terrain INNER JOIN complexe ON terrain.complexe_id = complexe.id WHERE complexe.id = :complexe_id');
	$req->bindValue(":complexe_id", $complexe_id, PDO::PARAM_INT);
	$req->execute();
	return $req->fetchAll();
}
function recupComplexeByID($complexe_id){
	$db = connexionBdd();
	$req = $db->prepare('SELECT * FROM complexe WHERE id = :complexe_id');
	$req->bindValue(":complexe_id", $complexe_id, PDO::PARAM_INT);
	$req->execute();
	return $req->fetch();
}
function liste_horaires_complexe($complexe_id){
	$db = connexionBdd();
	$req1 = $db->prepare('SELECT * FROM complexe_horaire WHERE complexe_id = :complexe_id');
	$req1 ->bindValue(':complexe_id', $complexe_id, PDO::PARAM_INT);
	$req1 -> execute();
	return $req1->fetchAll();
}
function maj_horaires($heure_debut, $heure_fin, $jours, $statut, $complexe_id){
	// $heure_debut et $ heure_fin sont au format H:i:s
	// statut : 1 = ouvert, 2 = fermé
	// return false / true
	$db = connexionBdd();
	$obj_heure_plage_debut = DateTime::createFromFormat('H:i:s', $heure_debut);
	$obj_heure_plage_fin = DateTime::createFromFormat('H:i:s', $heure_fin);
	if ($obj_heure_plage_debut < $obj_heure_plage_fin AND $statut == "2") {
		foreach ($jours as $jour_key => $jour_value) {
			$plages_horaires = liste_horaires_complexe($complexe_id);
			foreach ($plages_horaires as $horaire_key => $horaire_value) {
				//echo "dernier foreach <br/>";
				if ($horaire_value['jour_de_la_semaine'] == $jour_value){
						//echo "test du jour ok <br/>";
						$obj_heure_plage_debut2 = DateTime::createFromFormat('H:i:s', $horaire_value['heure_debut']);
						$obj_heure_plage_fin2 = DateTime::createFromFormat('H:i:s', $horaire_value['heure_fin']);
							
						//Si la plage fermée déclarée inclue une plage ouverte, on supp la page ouverte
						if (
							$obj_heure_plage_debut <= $obj_heure_plage_debut2
							AND (
								($obj_heure_plage_fin >= $obj_heure_plage_fin2 AND $horaire_value['heure_fin'] != "00:00:00")
								OR 
								$heure_fin =="00:00:00"
							)){
							
							$req = $db->prepare('DELETE FROM complexe_horaire WHERE id = :id');
							$req->bindValue(":id", $horaire_value['id'], PDO::PARAM_INT);
							$req->execute();
							unset($req);
						}
						//Si la plage fermée déclarée est inclu dans une plage ouverte plus grande => on scinde en plusieurs plages [1-9] + [2-5] => [1-2]+[5-9]
						elseif (
							$obj_heure_plage_debut >= $obj_heure_plage_debut2 
							AND (
								($obj_heure_plage_fin <= $obj_heure_plage_fin2  AND $heure_fin != "00:00:00")
								OR 
								$horaire_value['heure_fin'] != "00:00:00"
							)){
							if ($obj_heure_plage_debut == $obj_heure_plage_debut2){
								//commun par le début
								// maj le début l'acienne plage par réduction de la période
								$req = $db->prepare('
									UPDATE complexe_horaire
									SET heure_debut = :heure_debut
									WHERE id = :id
								');
								$req->bindValue(":heure_debut", $heure_fin, PDO::PARAM_STR);
								$req->bindValue(":id", $horaire_value['id'], PDO::PARAM_INT);
								$req->execute();
								unset($req);
							}
							elseif ($obj_heure_plage_fin == $obj_heure_plage_fin2){
								//(commun par la fin)
								// maj le début l'acienne plage par réduction de la période
								$req = $db->prepare('
									UPDATE complexe_horaire
									SET heure_fin = :heure_fin
									WHERE id = :id
								');
								$req->bindValue(":heure_fin", $heure_debut, PDO::PARAM_STR);
								$req->bindValue(":id", $horaire_value['id'], PDO::PARAM_INT);
								$req->execute();
								unset($req);
							}
							else{
								//echo "strictement inclu <br/>";
								//[1-9] + [3-5] => [1-3] + [3-5] + [5-9]
								//on supprimme l'ancienne
								//on crée une plage avec le mêmes propriétés que l'ancienne avec début identique à l'ancien et fin = début de la nouvelle plage
								//on crée une nouvelle plage avec le mêmes propriétés que l'ancienne. Début = fin de la nouvelle plage et fin = ancienne fin
									
								$req = $db->prepare('DELETE FROM complexe_horaire WHERE id = :id');
								$req->bindValue(":id", $horaire_value['id'], PDO::PARAM_INT);
								$req->execute();
								unset($req);
									
								$req2 = $db->prepare('
									INSERT INTO complexe_horaire(heure_debut, heure_fin, jour_de_la_semaine, complexe_id)
									VALUES (:heure_debut, :heure_fin, :jour_de_la_semaine, :complexe_id)
								');
								$req2->bindValue(":heure_debut", $horaire_value['heure_debut'], PDO::PARAM_STR);
								$req2->bindValue(":heure_fin", $heure_debut, PDO::PARAM_STR);
								$req2->bindValue(":jour_de_la_semaine", $jour_value, PDO::PARAM_INT);
								$req2->bindValue(":complexe_id", $complexe_id, PDO::PARAM_INT);
								$req2->execute();

								$req2 = $db->prepare('
									INSERT INTO complexe_horaire(heure_debut, heure_fin, jour_de_la_semaine, complexe_id)
									VALUES (:heure_debut, :heure_fin, :jour_de_la_semaine, :complexe_id)
								');
								$req2->bindValue(":heure_debut", $heure_fin, PDO::PARAM_STR);
								$req2->bindValue(":heure_fin", $horaire_value['heure_fin'] , PDO::PARAM_STR);
								$req2->bindValue(":jour_de_la_semaine", $jour_value, PDO::PARAM_INT);
								$req2->bindValue(":complexe_id", $complexe_id, PDO::PARAM_INT);
								$req2->execute();

								unset($req2);
							}
						}
						//Si chevauchement des plages cas 1 : 
						elseif (
							$obj_heure_plage_debut < $obj_heure_plage_debut2 
							AND (
								(
									$obj_heure_plage_fin < $obj_heure_plage_fin2 
									AND 
									$heure_fin != "00:00:00"
								)
								OR
								$horaire_value['heure_fin'] == "00:00:00"
							)
							AND (
								$obj_heure_plage_fin > $obj_heure_plage_debut2
								OR
								$heure_fin == "00:00:00"
							)){
									//echo "chevauchement 1 <br/>";
									// maj le début l'acienne plage par réduction de la période
									//insert la nouvelle
									$req = $db->prepare('
										UPDATE complexe_horaire
										SET heure_debut = :heure_debut
										WHERE id = :id
									');
									$req->bindValue(":heure_debut", $heure_fin, PDO::PARAM_STR);
									$req->bindValue(":id", $horaire_value['id'], PDO::PARAM_INT);
									$req->execute();

									unset($req);
						}
						//Si chevauchement des plages cas 1 : [3-7] + [5-9] => [3-5] + [5-9]
						elseif (
							$obj_heure_plage_debut > $obj_heure_plage_debut2 
							AND (
								$obj_heure_plage_debut < $obj_heure_plage_fin2
								OR 
								$horaire_value['heure_fin'] == "00:00:00"
							)
							AND (
								$obj_heure_plage_fin > $obj_heure_plage_fin2
								OR 
									(
										$heure_fin == "00:00:00" 
										AND 
										$horaire_value['heure_fin'] != "00:00:00"
									)
							)){
									//echo "chevauchement 2 <br/>";
									// maj le début l'acienne plage par réduction de la période
									//insert la nouvelle
									$req = $db->prepare('
										UPDATE complexe_horaire
										SET heure_fin = :heure_fin
										WHERE id = :id
									');
									$req->bindValue(":heure_fin", $heure_debut, PDO::PARAM_STR);
									$req->bindValue(":id", $horaire_value['id'], PDO::PARAM_INT);
									$req->execute();

									unset($req);
						}
				}
			}
		}
	}
	elseif ($obj_heure_plage_debut < $obj_heure_plage_fin AND $statut == "1") {
		foreach ($jours as $jour_key => $jour_value) {
			$plages_horaires = liste_horaires_complexe($complexe_id);
			$test = 0;
			foreach ($plages_horaires as $horaire_key => $horaire_value) {
				if ($horaire_value['jour_de_la_semaine'] == $jour_value){
					$obj_heure_plage_debut2 = DateTime::createFromFormat('H:i:s', $horaire_value['heure_debut']);
					$obj_heure_plage_fin2 = DateTime::createFromFormat('H:i:s', $horaire_value['heure_fin']);
							
					//Si la plage déclarée inclue la plage testée, => DELETE (au profit de la nouvelle plage) [6-8] + [2-9] => [2-9]
					if (
						$obj_heure_plage_debut <= $obj_heure_plage_debut2 
						AND 
						(
							(
								$obj_heure_plage_fin >= $obj_heure_plage_fin2
								AND
								$horaire_value['heure_fin'] != "00:00:00"
							)
							OR
							$heure_fin == "00:00:00"
						)
					){
						$req = $db->prepare('DELETE FROM complexe_horaire WHERE id = :id');
						$req->bindValue(":id", $horaire_value['id'], PDO::PARAM_INT);
						$req->execute();
						unset($req);

						$req2 = $db->prepare('
							INSERT INTO complexe_horaire(heure_debut, heure_fin, jour_de_la_semaine, complexe_id)
							VALUES (:heure_debut, :heure_fin, :jour_de_la_semaine, :complexe_id)
						');
						$req2->bindValue(":heure_debut", $heure_fin, PDO::PARAM_STR);
						$req2->bindValue(":heure_fin", $heure_fin , PDO::PARAM_STR);
						$req2->bindValue(":jour_de_la_semaine", $jour_value, PDO::PARAM_INT);
						$req2->bindValue(":complexe_id", $complexe_id, PDO::PARAM_INT);
						$req2->execute();

						unset($req2);
						$test = 1;
					}
					//Si la nouvelle plage est inclu dans une plage plus grande => on ne fait rien
					elseif (
						$obj_heure_plage_debut >= $obj_heure_plage_debut2 
						AND
						(
							(
								$obj_heure_plage_fin <= $obj_heure_plage_fin2
								AND 
								$heure_fin != "00:00:00"
							)
							OR
							$horaire_value['heure_fin'] == "00:00:00"
						)
						){
						$test = 1;						
					}
					//Si chevauchement des plages cas 1 : [3-7] + [1-5] => [1-5] + [5-7]
					elseif (
						$obj_heure_plage_debut < $obj_heure_plage_debut2 
						AND 
						(	(
								$obj_heure_plage_fin < $obj_heure_plage_fin2
								OR  
								$horaire_value['heure_fin'] == "00:00:00"
							)
							AND
							$heure_fin != "00:00:00"
						)
						AND 
						(
							$obj_heure_plage_fin > $obj_heure_plage_debut2
							OR
							$heure == "00:00:00"
						)
					){
						// maj le début l'acienne plage par réduction de la période
						//insert la nouvelle
						$req = $db->prepare('
							UPDATE complexe_horaire
							SET heure_debut = :heure_debut
							WHERE id = :id
						');
						$req->bindValue(":heure_debut", $heure_debut, PDO::PARAM_STR);
						$req->bindValue(":id", $horaire_value['id'], PDO::PARAM_INT);
						$req->execute();

						unset($req);
					}
					//Si chevauchement des plages cas 2 : [3-7] + [5-9] => [3-5] + [5-9]
					elseif (
						$obj_heure_plage_debut > $obj_heure_plage_debut2 
						AND 
						(
							$obj_heure_plage_debut < $obj_heure_plage_fin2
							OR
							$horaire_value['heure_fin'] == "00:00:00"
						)
						AND 
						(
							(
								$obj_heure_plage_fin > $obj_heure_plage_fin2
								OR
								$heure == "00:00:00"
							)
							AND 
								$horaire_value['heure_fin'] != "00:00:00"
						)
					){
							// maj le début l'acienne plage par réduction de la période
							//insert la nouvelle
							$req = $db->prepare('
								UPDATE complexe_horaire
								SET heure_fin = :heure_fin
								WHERE id = :id
							');
							$req->bindValue(":heure_fin", $heure_fin, PDO::PARAM_STR);
							$req->bindValue(":id", $horaire_value['id'], PDO::PARAM_INT);
							$req->execute();

							unset($req);
							$test = 1;
					}
				}
			}
			if( $test == 0){
				$req2 = $db->prepare('
					INSERT INTO complexe_horaire(heure_debut, heure_fin, jour_de_la_semaine, complexe_id)
					VALUES (:heure_debut, :heure_fin, :jour_de_la_semaine, :complexe_id)
				');
				$req2->bindValue(":heure_debut", $heure_debut, PDO::PARAM_STR);
				$req2->bindValue(":heure_fin", $heure_fin , PDO::PARAM_STR);
				$req2->bindValue(":jour_de_la_semaine", $jour_value, PDO::PARAM_INT);
				$req2->bindValue(":complexe_id", $complexe_id, PDO::PARAM_INT);
				$req2->execute();

				unset($req2);
			}
		}
	}
	else {
		return false;
	}
}
function liste_resa_complexe($complexe_id){
	$db = connexionBdd();
	$req = $db->prepare('SELECT * FROM reservation INNER JOIN plage_horaire ON reservation.id = plage_horaire.reservation_id INNER JOIN terrain ON plage_horaire.terrain_id = terrain.id WHERE terrain.complexe_id = :complexe_id ORDER BY hor_heure_debut DESC');
	$req->bindValue(":complexe_id", $complexe_id, PDO::PARAM_INT);
	$req->execute();
	return $req->fetchAll();
}
/* ----------------------------------------------------				Fonctions relatives aux réservations 	 ------------------------------------- */
function recupResaById($resa_id){
	$db = connexionBdd();
	$req = $db->prepare('SELECT * FROM reservation WHERE id = :resa_id');
	$req->bindValue("resa_id", $resa_id, PDO::PARAM_INT);
	$req->execute();
	return $req->fetchAll();
}
function reserver($datetime_debut, $datetime_fin, $terrain){
	$db = connexionBdd();
	$obj_heure_plage_debut = clone($datetime_debut);
	$obj_heure_plage_fin = clone($datetime_fin);
	if ($obj_heure_plage_debut < $obj_heure_plage_fin) {
		$plages = liste_plages_horaires_terrain($terrain);
		$resa_possible = 0;
		foreach ($plages as $plage_key => $plage_value) {
			$obj_heure_plage_debut2 = DateTime::createFromFormat('Y-m-j H:i:s', $plage_value['hor_heure_debut']);
			$obj_heure_plage_fin2 = DateTime::createFromFormat('Y-m-j H:i:s', $plage_value['hor_heure_fin']);
			if($plage_value['statut_id'] == 1 AND $obj_heure_plage_debut >= $obj_heure_plage_debut2 AND $obj_heure_plage_fin <= $obj_heure_plage_fin2){
				if($obj_heure_plage_debut == $obj_heure_plage_debut2 AND $obj_heure_plage_fin == $obj_heure_plage_fin2){
					delete_plage($plage_value['id']);
					$resa_possible = 1;
					break 1;
				}
				elseif($plage_value['statut_id'] == 1 AND $obj_heure_plage_debut == $obj_heure_plage_debut2 AND $obj_heure_plage_fin < $obj_heure_plage_fin2){
					//echo "maj par décalage du début de la plage dispo";
					maj_plage_sans_verif($plage_value['id'], $plage_value['statut_id'], $plage_value['reservation_id'], $datetime_fin, $obj_heure_plage_fin2, $plage_value['terrain_id']);
					$resa_possible = 1;
					break 1;
				}
				elseif($plage_value['statut_id'] == 1 AND $obj_heure_plage_debut > $obj_heure_plage_debut2 AND $obj_heure_plage_fin == $obj_heure_plage_fin2){
				//	echo "maj par réduction de la fin de la plage";
					maj_plage_sans_verif($plage_value['id'], $plage_value['statut_id'], $plage_value['reservation_id'], $obj_heure_plage_debut2, $datetime_debut, $plage_value['terrain_id']);
					$resa_possible = 1;
					break 1;
				}
				elseif($plage_value['statut_id'] == 1 AND $obj_heure_plage_debut > $obj_heure_plage_debut2 AND $obj_heure_plage_fin < $obj_heure_plage_fin2){
					//On scinde la plage dispo en deux plages, une avant la résa et une aprés la résa
					delete_plage($plage_value['id']);
					insert_plage_sans_verif($plage_value['statut_id'], $plage_value['reservation_id'], $obj_heure_plage_debut2, $datetime_debut, $plage_value['terrain_id']);
					insert_plage_sans_verif($plage_value['statut_id'], $plage_value['reservation_id'], $datetime_fin, $obj_heure_plage_fin2, $plage_value['terrain_id']);
					$resa_possible = 1;
					break 1;
				}
			}
		}
		if ($resa_possible == 1){
			$res_reference = 1;
			$res_est_confirmee = 0;
			$req = $db->prepare('
				INSERT INTO reservation(res_reference, res_est_confirmee)
				VALUES (:res_reference, :res_est_confirmee)
			');
			$req->bindValue(":res_reference", $res_reference, PDO::PARAM_INT);
			$req->bindValue(":res_est_confirmee", $res_est_confirmee, PDO::PARAM_INT);
			$req->execute();

			$req2 = $db->prepare('SELECT * FROM reservation WHERE res_reference = :res_reference AND res_est_confirmee =:res_est_confirmee ORDER BY id DESC');
			$req2->bindValue(":res_reference", $res_reference, PDO::PARAM_INT);
			$req2->bindValue(":res_est_confirmee", $res_est_confirmee, PDO::PARAM_INT);
			$req2->execute();
			$res2 = $req2->fetch();

			insert_plage_sans_verif(3, $res2['id'], $datetime_debut, $datetime_fin, $terrain);
			return "pas de pb, reste à verif la résa";
		}
		else{
			return "resa impossible";
		}
	}
}
function reserver2($datetime_debut, $datetime_fin, $terrain, $res_nom_client, $res_num_tel_client, $res_descriptif, $utilisateur_api_id){
	$db = connexionBdd();
	$obj_heure_plage_debut = clone($datetime_debut);
	$obj_heure_plage_fin = clone($datetime_fin);
	if ($obj_heure_plage_debut < $obj_heure_plage_fin) {
		$plages = liste_plages_horaires_terrain($terrain);
		$resa_possible = 0;
		foreach ($plages as $plage_key => $plage_value) {
			$obj_heure_plage_debut2 = DateTime::createFromFormat('Y-m-j H:i:s', $plage_value['hor_heure_debut']);
			$obj_heure_plage_fin2 = DateTime::createFromFormat('Y-m-j H:i:s', $plage_value['hor_heure_fin']);
			if($plage_value['statut_id'] == 1 AND $obj_heure_plage_debut >= $obj_heure_plage_debut2 AND $obj_heure_plage_fin <= $obj_heure_plage_fin2){
				if($obj_heure_plage_debut == $obj_heure_plage_debut2 AND $obj_heure_plage_fin == $obj_heure_plage_fin2){
					delete_plage($plage_value['id']);
					$resa_possible = 1;
					break 1;
				}
				elseif($plage_value['statut_id'] == 1 AND $obj_heure_plage_debut == $obj_heure_plage_debut2 AND $obj_heure_plage_fin < $obj_heure_plage_fin2){
					//echo "maj par décalage du début de la plage dispo";
					maj_plage_sans_verif($plage_value['id'], $plage_value['statut_id'], $plage_value['reservation_id'], $datetime_fin, $obj_heure_plage_fin2, $plage_value['terrain_id']);
					$resa_possible = 1;
					break 1;
				}
				elseif($plage_value['statut_id'] == 1 AND $obj_heure_plage_debut > $obj_heure_plage_debut2 AND $obj_heure_plage_fin == $obj_heure_plage_fin2){
				//	echo "maj par réduction de la fin de la plage";
					maj_plage_sans_verif($plage_value['id'], $plage_value['statut_id'], $plage_value['reservation_id'], $obj_heure_plage_debut2, $datetime_debut, $plage_value['terrain_id']);
					$resa_possible = 1;
					break 1;
				}
				elseif($plage_value['statut_id'] == 1 AND $obj_heure_plage_debut > $obj_heure_plage_debut2 AND $obj_heure_plage_fin < $obj_heure_plage_fin2){
					//On scinde la plage dispo en deux plages, une avant la résa et une aprés la résa
					delete_plage($plage_value['id']);
					insert_plage_sans_verif($plage_value['statut_id'], $plage_value['reservation_id'], $obj_heure_plage_debut2, $datetime_debut, $plage_value['terrain_id']);
					insert_plage_sans_verif($plage_value['statut_id'], $plage_value['reservation_id'], $datetime_fin, $obj_heure_plage_fin2, $plage_value['terrain_id']);
					$resa_possible = 1;
					break 1;
				}
			}
		}
		if ($resa_possible == 1){
			$res_reference = 1;
			$res_est_confirmee = 0;
			$req = $db->prepare('
				INSERT INTO reservation(res_reference, res_est_confirmee, res_nom_client, res_num_tel_client, res_descriptif, utilisateur_api_id)
				VALUES (:res_reference, :res_est_confirmee, :res_nom_client, :res_num_tel_client, :res_descriptif, :utilisateur_api_id)
			');
			$req->bindValue(":res_reference", $res_reference, PDO::PARAM_INT);
			$req->bindValue(":res_est_confirmee", $res_est_confirmee, PDO::PARAM_INT);
			$req->bindValue(":res_nom_client", $res_nom_client, PDO::PARAM_STR);
			$req->bindValue(":res_num_tel_client", $res_num_tel_client, PDO::PARAM_STR);
			$req->bindValue(":res_descriptif", $res_descriptif, PDO::PARAM_STR);
			$req->bindValue(":utilisateur_api_id", $utilisateur_api_id, PDO::PARAM_INT);
			$req->execute();

			$req2 = $db->prepare('SELECT MAX(id) FROM reservation WHERE res_reference = :res_reference AND res_est_confirmee =:res_est_confirmee');
			$req2->bindValue(":res_reference", $res_reference, PDO::PARAM_INT);
			$req2->bindValue(":res_est_confirmee", $res_est_confirmee, PDO::PARAM_INT);
			$req2->execute();
			$res2 = $req2->fetchColumn();

			insert_plage_sans_verif(3, $res2, $datetime_debut, $datetime_fin, $terrain);

			return $res2;
		}
		else{
			return "resa impossible";
		}
	}
}
function annuler_resa_by_complexe($resa_id){	
	$db = connexionBdd();

	// Test autorisation d'action sur la résa
	if (isset($_SESSION['complexe_id'])){
		$req = $db->prepare('SELECT * FROM terrain INNER JOIN plage_horaire ON terrain.id = plage_horaire.terrain_id WHERE reservation_id = :resa_id AND terrain.complexe_id = :complexe_id');
		$req->bindValue("resa_id", $resa_id, PDO::PARAM_INT);
		$req->bindValue("complexe_id", $_SESSION['complexe_id'], PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch();

		if (!empty($res)){
			$req2 = $db->prepare('DELETE FROM plage_horaire WHERE reservation_id = :resa_id');
			$req2->bindValue("resa_id", $resa_id, PDO::PARAM_INT);
			$req2->execute();

			$req1 = $db->prepare('DELETE FROM reservation WHERE id = :resa_id');
			$req1->bindValue("resa_id", $resa_id, PDO::PARAM_INT);
			$req1->execute();

		}
	}
}
function annuler_resa_by_exterieur($resa_id){	
	$db = connexionBdd();

	// Test autorisation d'action sur la résa
	if (isset($_SESSION['complexe_id'])){
		$req = $db->prepare('SELECT * FROM terrain INNER JOIN plage_horaire ON terrain.id = plage_horaire.terrain_id WHERE reservation_id = :resa_id AND terrain.complexe_id = :complexe_id');
		$req->bindValue("resa_id", $resa_id, PDO::PARAM_INT);
		$req->bindValue("complexe_id", $_SESSION['complexe_id'], PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch();

		if (!empty($res)){
			$req1 = $db->prepare('DELETE FROM reservation WHERE id = :resa_id');
			$req1->bindValue("resa_id", $resa_id, PDO::PARAM_INT);
			$req1->execute();

			
		}
		join_plages_libres($res['terrain_id']);
	}
}
function annuler_resa_by_joueur($resa_id){	
	$db = connexionBdd();

	// Test autorisation d'action sur la résa
	if (isset($_SESSION['joueur_id'])){
		$req = $db->prepare('SELECT * FROM reservation WHERE res_num_tel_client = :tel AND id = :resa_id');
		$req->bindValue("resa_id", $resa_id, PDO::PARAM_INT);
		$req->bindValue("tel", $_SESSION['joueur_tel'], PDO::PARAM_STR);
		$req->execute();
		$res = $req->fetch();

		if (!empty($res)){

			$req2 = $db->prepare('
				UPDATE plage_horaire
				SET statut_id = 1, reservation_id = NULL
				WHERE reservation_id = :resa_id
			');
			$req2->bindValue("resa_id", $resa_id, PDO::PARAM_INT);
			$req2->execute();

			$req1 = $db->prepare('DELETE FROM reservation WHERE id = :resa_id');
			$req1->bindValue("resa_id", $resa_id, PDO::PARAM_INT);
			$req1->execute();
	
			join_plages_libres($res['terrain_id']);
		}
	}
}

/* ----------------------------------------------------				Fonctions relatives aux dispo		 ------------------------------------- */

function liste_plages_horaires_terrain($terrain_id){
	$db = connexionBdd();
	$req = $db->prepare('SELECT * FROM  terrain INNER JOIN plage_horaire ON terrain.id = plage_horaire.terrain_id WHERE terrain.id = :terrain_id');
	$req->bindValue(":terrain_id", $terrain_id, PDO::PARAM_INT);
	$req->execute();
	return $req->fetchAll();
}	
function ouvrir_fermer_plage($datetime_debut, $datetime_fin, $terrain, $statut_plage){
	// $datetime sont des objets dates
	// $terrains et $aa sont des tableaux
	// return false / true
	$db = connexionBdd();
		//echo "<br/>tt début";
	$obj_heure_plage_debut = clone($datetime_debut);
	$obj_heure_plage_fin = clone($datetime_fin);
		//echo "<br/>tt début";
	if ($obj_heure_plage_debut < $obj_heure_plage_fin) {
		//echo "<br/>premier if";
		$plages = liste_plages_horaires_terrain($terrain);
		$maj = 0;
		foreach ($plages as $plage_key => $plage_value) {
			//echo "<br/>premier foreach";
			$obj_heure_plage_debut2 = DateTime::createFromFormat('Y-m-j H:i:s', $plage_value['hor_heure_debut']);
			$obj_heure_plage_fin2 = DateTime::createFromFormat('Y-m-j H:i:s', $plage_value['hor_heure_fin']);
			//Si la maj s'opère sur une résa
			if ($plage_value['statut_id'] == 3){
				// Si la nouvelle plage n'a rien à voir avec la résa
				if ($obj_heure_plage_debut >= $obj_heure_plage_fin2 AND $obj_heure_plage_fin <= $obj_heure_plage_debut2){
					//on test la suivante
				}
				// Si la nouvelle plage est inclu dans une résa, alors on ne fait pas de maj;
				elseif ($obj_heure_plage_debut >= $obj_heure_plage_debut2 AND $obj_heure_plage_fin <= $obj_heure_plage_fin2){
					$maj = 1;
					break 1;
				}
				//chevauchement par la fin de la nouvelle plage
				elseif($obj_heure_plage_debut < $obj_heure_plage_debut2 AND $obj_heure_plage_fin <= $obj_heure_plage_fin2 AND $obj_heure_plage_fin > $obj_heure_plage_debut2){
					//on réduit la fin de la nouvelle plage
					$datetime_fin = $obj_heure_plage_debut2;
					$obj_heure_plage_fin = clone($datetime_fin);
				}
				//chevauchement par le début de la nouvelle plage
				elseif($obj_heure_plage_debut >= $obj_heure_plage_debut2 AND $obj_heure_plage_fin > $obj_heure_plage_fin2 AND $obj_heure_plage_debut < $obj_heure_plage_fin2){
					//on réduit la debut de la nouvelle plage
					$datetime_debut = $obj_heure_plage_fin2;
					$obj_heure_plage_debut = clone($datetime_debut);
				}
				//Si la résa testée est strictement inclu dans la plage déclarée, on scinde la plage en deux et on maj les deux segments
				elseif($obj_heure_plage_debut < $obj_heure_plage_debut2 AND $obj_heure_plage_fin > $obj_heure_plage_fin2){
					ouvrir_fermer_plage($datetime_debut, $obj_heure_plage_debut2, $terrain, $statut_plage);
					ouvrir_fermer_plage($obj_heure_plage_fin2, $datetime_fin, $terrain, $statut_plage);
					$maj = 1;
					break 1;			
				}
			}

			//Si la plage déclarée inclue la plage testée, => DELETE (au profit de la nouvelle plage) [6-8] + [2-9] => [2-9]
			elseif ($obj_heure_plage_debut <= $obj_heure_plage_debut2 AND $obj_heure_plage_fin >= $obj_heure_plage_fin2){
				delete_plage($plage_value['id']);
			}
			//Si la nouvelle plage est inclu dans une plage plus grande et de mm statut on ne fait rien
			elseif ($obj_heure_plage_debut >= $obj_heure_plage_debut2 AND $obj_heure_plage_fin <= $obj_heure_plage_fin2 AND $statut_plage == $plage_value['statut_id']){
				$maj = 1;
				break 1;
			}
			//Si la nouvelle plage est inclu dans une plage plus grande et de statut différent => on scinde en plusieurs plages [1-9] + [2-5] => [1-2]+[2-5]+[5-9] 
			elseif ($obj_heure_plage_debut >= $obj_heure_plage_debut2 AND $obj_heure_plage_fin <= $obj_heure_plage_fin2 AND $statut_plage != $plage_value['statut_id']){

				if ($obj_heure_plage_debut == $obj_heure_plage_debut2){
					//[1-9] + [3-9] => [1-3] + [3-9] (commun par la fin)
					// on scinde en deux
				 	// maj le début l'acienne plage par réduction de la période
					//echo "même début donc on décale le début de l'ancienne <br/>";
					maj_plage_sans_verif($plage_value['id'], $plage_value['statut_id'], $plage_value['reservation_id'], $datetime_fin, $obj_heure_plage_fin2, $plage_value['terrain_id']);
				}
				elseif ($obj_heure_plage_fin == $obj_heure_plage_fin2){
					//echo "même fin donc on décale la fin  de l'ancienne <br/>";
					//[1-9] + [1-4] => [1-4] + [4-9] (commun par le début)
					// on scinde en deux
					// maj le début l'acienne plage par réduction de la période
					maj_plage_sans_verif($plage_value['id'], $plage_value['statut_id'], $plage_value['reservation_id'], $obj_heure_plage_debut2, $datetime_debut, $plage_value['terrain_id']);
				}
				else{
					//echo "strictement inclu <br/>";
					//[1-9] + [3-5] => [1-3] + [3-5] + [5-9]
					//on supprimme l'ancienne
					//on crée une plage avec le mêmes propriétés que l'ancienne avec début identique à l'ancien et fin = début de la nouvelle plage
					//on crée une nouvelle plage avec le mêmes propriétés que l'ancienne. Début = fin de la nouvelle plage et fin = ancienne fin
									
					delete_plage($plage_value['id']);
					//insert_plage_sans_verif($plage_value['statut_id'], $plage_value['reservation_id'], $plage_value['hor_heure_debut'], $datetime_debut, $plage_value['terrain_id']);
					insert_plage_sans_verif($plage_value['statut_id'], $plage_value['reservation_id'], $obj_heure_plage_debut2, $datetime_debut, $plage_value['terrain_id']);
					insert_plage_sans_verif($plage_value['statut_id'], $plage_value['reservation_id'], $datetime_fin, $obj_heure_plage_fin2, $plage_value['terrain_id']);
				}
			}
			//Si chevauchement des plages cas 1 : [3-7] + [1-5] => [1-5] + [5-7]
			elseif ($obj_heure_plage_debut < $obj_heure_plage_debut2 AND $obj_heure_plage_fin < $obj_heure_plage_fin2 AND $obj_heure_plage_fin > $obj_heure_plage_debut2){
				//echo "chevauchement 1 <br/>";
				// maj le début l'acienne plage par réduction de la période
				maj_plage_sans_verif($plage_value['id'], $plage_value['statut_id'], $plage_value['reservation_id'],  $datetime_fin, $obj_heure_plage_fin2, $plage_value['terrain_id']);
			}
			//Si chevauchement des plages cas 1 : [3-7] + [5-9] => [3-5] + [5-9]
			elseif ($obj_heure_plage_debut > $obj_heure_plage_debut2 AND $obj_heure_plage_debut < $obj_heure_plage_fin2 AND $obj_heure_plage_fin > $obj_heure_plage_fin2){
				//echo "chevauchement 2 <br/>";
				// maj le début l'acienne plage par réduction de la période
				maj_plage_sans_verif($plage_value['id'], $plage_value['statut_id'], $plage_value['reservation_id'], $obj_heure_plage_debut2, $datetime_debut, $plage_value['terrain_id']);
			}
		}
		if($maj == 0){
			insert_plage_sans_verif($statut_plage, $reservation_id = NULL, $datetime_debut, $datetime_fin, $terrain);
		}
		//vérifier si des plages peuvent se regrouper avec la nouvelle
	}
	else {
		return false;
	}
}
function maj_plage_sans_verif($id, $statut_id, $reservation_id, $hor_heure_debut, $hor_heure_fin, $terrain_id){
	$db = connexionBdd();
	$req = $db->prepare('
		UPDATE plage_horaire
		SET statut_id = :statut_id, reservation_id = :reservation_id, hor_heure_fin = :hor_heure_fin, hor_heure_debut = :hor_heure_debut, terrain_id = :terrain_id
		WHERE id = :id
	');
	$req->bindValue(":id", $id, PDO::PARAM_INT);
	$req->bindValue(":statut_id", $statut_id, PDO::PARAM_INT);
	$req->bindValue(":reservation_id", $reservation_id, PDO::PARAM_INT);
	$req->bindValue(":hor_heure_debut", $hor_heure_debut->format('Y-m-j H:i:s'), PDO::PARAM_STR);
	$req->bindValue(":hor_heure_fin", $hor_heure_fin->format('Y-m-j H:i:s'), PDO::PARAM_STR);
	$req->bindValue(":terrain_id", $terrain_id, PDO::PARAM_INT);
	$req->execute();

	unset($req);
}
function insert_plage_sans_verif($statut_id, $reservation_id, $hor_heure_debut, $hor_heure_fin, $terrain_id){
	$db = connexionBdd();
	$req = $db->prepare('
		INSERT INTO plage_horaire(statut_id, reservation_id, hor_heure_debut, hor_heure_fin, terrain_id)
		VALUES (:statut_id, :reservation_id, :hor_heure_debut, :hor_heure_fin, :terrain_id)
	');
	$req->bindValue(":statut_id", $statut_id, PDO::PARAM_INT);
	$req->bindValue(":reservation_id", $reservation_id, PDO::PARAM_INT);
	$req->bindValue(":hor_heure_debut", $hor_heure_debut->format('Y-m-j H:i:s'), PDO::PARAM_STR);
	$req->bindValue(":hor_heure_fin", $hor_heure_fin->format('Y-m-j H:i:s'), PDO::PARAM_STR);
	$req->bindValue(":terrain_id", $terrain_id, PDO::PARAM_INT);
	$req->execute();
}
function delete_plage($id){
	$db = connexionBdd();
	$req = $db->prepare('DELETE FROM plage_horaire WHERE id = :id');
	$req->bindValue(":id", $id, PDO::PARAM_INT);
	$req->execute();
}
function liste_creneaux($terrain_id, $jour, $duree){
	$db = connexionBdd();
	if (empty($jour)){
		$jour = new DateTime;
		$jour = $jour->format('Y-m-j');
	}
	$heure_boucle = date_create_from_format('Y-m-j H:i:s', $jour.' 00:00:00');
	$heure_boucle_fin = date_create_from_format('Y-m-j H:i:s', $jour.'00:00:00');
	$heure_boucle_fin->add(new DateInterval('P1D'));
	
	$req1 = $db->prepare('SELECT * FROM plage_horaire WHERE terrain_id = :terrain_id AND statut_id = 1 ORDER BY hor_heure_debut ASC');
	$req1->execute(array(
		':terrain_id' => $terrain_id
	));
	
	$liste_plages = $req1->fetchAll();
	while ($heure_boucle <= $heure_boucle_fin) {
		
		$heure_boucle_duree = clone($heure_boucle);
		$heure_boucle_duree->add(new DateInterval('PT'.$duree.'M'));
		
		foreach ($liste_plages as $plage_key => $plage_value) {
			$debut_plage = date_create_from_format('Y-m-j H:i:s', $plage_value['hor_heure_debut']);
			$fin_plage = date_create_from_format('Y-m-j H:i:s', $plage_value['hor_heure_fin']);
			if( $heure_boucle >= $debut_plage AND $heure_boucle_duree <= $fin_plage){
				$liste_creneaux_resa[] = array(
					'debut' => $heure_boucle->format('Y-m-j H:i:s'),
					'fin' => $heure_boucle_duree->format('Y-m-j H:i:s')
				);
			}
		}
		$heure_boucle->add(new DateInterval('PT30M'));
	}
	if(!isset ($liste_creneaux_resa)){
		$liste_creneaux_resa = NULL;
	}
	return $liste_creneaux_resa;
}
function join_plages_libres($terrain_id){

	$db = connexionBdd();
	$req = $db->prepare('SELECT * FROM plage_horaire WHERE terrain_id = :terrain_id AND statut_id = 1');
	$req->bindValue(":terrain_id", $terrain_id, PDO::PARAM_INT);
	$req->execute();
	$res = $req->fetchAll();

	foreach ($res as $plage_key1 => $plage_value1) {
		foreach ($res as $plage_key2 => $plage_value2) {
			if ($plage_value1['hor_heure_debut'] == $plage_value2['hor_heure_fin']){
				maj_plage_sans_verif($plage_value1[0], $plage_value1['statut_id'], $plage_value1['reservation_id'], $plage_value2['hor_heure_debut'], $plage_value1['hor_heure_fin'], $plage_value1['terrain_id']);
				delete_plage($plage_value2[0]);
			}
			elseif ($plage_value1['hor_heure_fin'] == $plage_value2['hor_heure_debut']){
				maj_plage_sans_verif($plage_value1[0], $plage_value1['statut_id'], $plage_value1['reservation_id'], $plage_value1['hor_heure_debut'], $plage_value2['hor_heure_fin'], $plage_value1['terrain_id']);
				delete_plage($plage_value2[0]);
			}
		}
	}
}

/* ----------------------------------------------------			Fonctions relatives commissions		 ------------------------------------- */
function liste_commissions_terrain_aa($terrain_id, $aa_id){
	$db = connexionBdd();
	$req = $db->prepare('SELECT * FROM planning_commission WHERE terrain_id = :terrain_id AND utilisateur_api_id = :aa_id');
	$req->bindValue(":terrain_id", $terrain_id, PDO::PARAM_INT);
	$req->bindValue(":aa_id", $aa_id, PDO::PARAM_INT);
	$req->execute();
	return $req->fetchAll();
}

function maj_commissions($heure_debut, $heure_fin, $terrains, $aa, $jours, $commission, $interdiction){
	// $heure_debut et $ heure_fin sont au format H:i:s
	// $terrains et $aa sont des tableaux
	// return false / true
	$db = connexionBdd();
	$obj_heure_plage_debut = DateTime::createFromFormat('H:i:s', $heure_debut);
	$obj_heure_plage_fin = DateTime::createFromFormat('H:i:s', $heure_fin);
	if ($obj_heure_plage_debut < $obj_heure_plage_fin OR $heure_fin == "00:00:00") {
		foreach ($terrains as $terrain_key => $terrain_value) {
			foreach ($jours as $jour_key => $jour_value) {
				foreach ($aa as $aa_key => $aa_value) {

					$plages_com_terrain_aa = liste_commissions_terrain_aa($terrain_value, $aa_value);
					foreach ($plages_com_terrain_aa as $plage_com_aa_key => $plage_com_aa_value) {

						if ($plage_com_aa_value['com_jour'] == $jour_value){
							$obj_heure_plage_debut2 = DateTime::createFromFormat('H:i:s', $plage_com_aa_value['com_heure_debut']);
							$obj_heure_plage_fin2 = DateTime::createFromFormat('H:i:s', $plage_com_aa_value['com_heure_fin']);
							
							//Si la plage déclarée inclue la plage testée, => DELETE (au profit de la nouvelle plage) [6-8] + [2-9] => [2-9]
							if (
								$obj_heure_plage_debut <= $obj_heure_plage_debut2 
								AND 
								(
									(
										$obj_heure_plage_fin >= $obj_heure_plage_fin2
										AND
										$plage_com_aa_value['com_heure_fin'] != "00:00:00"
									)
									OR
									$heure_fin == "00:00:00"
								)
							){
								$req = $db->prepare('DELETE FROM planning_commission WHERE id = :id_com');
								$req->bindValue(":id_com", $plage_com_aa_value['id'], PDO::PARAM_INT);
								$req->execute();
								unset($req);
							}
							//Si la nouvelle plage est inclu dans une plage plus grande => on scinde en plusieurs plages [1-9] + [2-5] => [1-2]+[2-5]+[5-9]
							elseif (
								$obj_heure_plage_debut >= $obj_heure_plage_debut2 
								AND 
								(
									(
										$obj_heure_plage_fin <= $obj_heure_plage_fin2
										AND
										$heure_fin != "00:00:00"
									)
									OR
									$plage_com_aa_value['com_heure_fin'] == "00:00:00"
								)
							){

								// On vérifie qu'il s'agisse d'une MAj
								if ($commission == $plage_com_aa_value['com_montant'] OR ($interdiction == 1 AND ( empty($plage_com_aa_value['com_montant']) OR $plage_com_aa_value['com_montant'] == NULL) ) ){
								 	// Pas de MAJ
								}
								elseif ($obj_heure_plage_debut == $obj_heure_plage_debut2){
									//[1-9] + [3-9] => [1-3] + [3-9] (commun par la fin)
									// on scinde en deux
									// maj le début l'acienne plage par réduction de la période
									//insert la nouvelle
									$req = $db->prepare('
										UPDATE planning_commission
										SET com_heure_debut = :heure_debut
										WHERE id = :id_com
									');
									$req->bindValue(":heure_debut", $heure_fin, PDO::PARAM_STR);
									$req->bindValue(":id_com", $plage_com_aa_value['id'], PDO::PARAM_INT);
									$req->execute();

									unset($req);
								}
								elseif ($obj_heure_plage_fin == $obj_heure_plage_fin2){
									//[1-9] + [1-4] => [1-4] + [4-9] (commun par le début)
									// on scinde en deux
									// maj le début l'acienne plage par réduction de la période
									//insert la nouvelle
									$req = $db->prepare('
										UPDATE planning_commission
										SET com_montant = :com, com_heure_fin = :heure_fin
										WHERE id = :id_com
									');
									$req->bindValue(":com", $commission, PDO::PARAM_INT);
									$req->bindValue(":heure_fin", $heure_debut, PDO::PARAM_STR);
									$req->bindValue(":id_com", $plage_com_aa_value['id'], PDO::PARAM_INT);
									$req->execute();

									unset($req);
								}
								else{
									//"strictement inclu <br/>";
									//[1-9] + [3-5] => [1-3] + [3-5] + [5-9]
									//on supprimme l'ancienne
									//on crée une plage avec le mêmes propriétés que l'ancienne avec début identique à l'ancien et fin = début de la nouvelle plage
									//on crée la nouvelle plage
									//on crée une nouvelle plage avec le mêmes propriétés que l'ancienne. Début = fin de la nouvelle plage et fin = ancienne fin
									
									$req = $db->prepare('DELETE FROM planning_commission WHERE id = :id_com');
									$req->bindValue(":id_com", $plage_com_aa_value['id'], PDO::PARAM_INT);
									$req->execute();
									unset($req);
									
									$req2 = $db->prepare('
										INSERT INTO planning_commission(terrain_id, utilisateur_api_id, com_montant, com_heure_debut, com_heure_fin, com_jour)
										VALUES (:terrain_id, :utilisateur_api_id, :com_montant, :com_heure_debut, :com_heure_fin, :com_jour)
									');
									$req2->bindValue(":terrain_id", $terrain_value, PDO::PARAM_INT);
									$req2->bindValue(":utilisateur_api_id", $aa_value, PDO::PARAM_INT);
									$req2->bindValue(":com_montant", $plage_com_aa_value['com_montant'], PDO::PARAM_INT);
									$req2->bindValue(":com_heure_debut", $plage_com_aa_value['com_heure_debut'], PDO::PARAM_STR);
									$req2->bindValue(":com_heure_fin", $heure_debut, PDO::PARAM_STR);
									$req2->bindValue(":com_jour", $jour_value, PDO::PARAM_INT);
									$req2->execute();

									$req2 = $db->prepare('
										INSERT INTO planning_commission(terrain_id, utilisateur_api_id, com_montant, com_heure_debut, com_heure_fin, com_jour)
										VALUES (:terrain_id, :utilisateur_api_id, :com_montant, :com_heure_debut, :com_heure_fin, :com_jour)
									');
									$req2->bindValue(":terrain_id", $terrain_value, PDO::PARAM_INT);
									$req2->bindValue(":utilisateur_api_id", $aa_value, PDO::PARAM_INT);
									$req2->bindValue(":com_montant", $plage_com_aa_value['com_montant'], PDO::PARAM_INT);
									$req2->bindValue(":com_heure_debut", $heure_fin, PDO::PARAM_STR);
									$req2->bindValue(":com_heure_fin", $plage_com_aa_value['com_heure_fin'] , PDO::PARAM_STR);
									$req2->bindValue(":com_jour", $jour_value, PDO::PARAM_INT);
									$req2->execute();

									unset($req2);
								}
							}
							//Si chevauchement des plages cas 1 : [3-7] + [1-5] => [1-5] + [5-7]
							elseif (
								$obj_heure_plage_debut < $obj_heure_plage_debut2 
								AND 
								(
									(
										$obj_heure_plage_fin < $obj_heure_plage_fin2
										AND
										$heure_fin != "00:00:00"
									)
									OR
									(
										$heure_fin != "00:00:00"
										AND
										$plage_com_aa_value['com_heure_fin'] == "00:00:00"
									)
								)
								AND 
								(
									$obj_heure_plage_fin > $obj_heure_plage_debut2
									OR
									$heure_fin == "00:00:00"
								)
							){
									//echo "chevauchement 1 <br/>";
									// maj le début l'acienne plage par réduction de la période
									//insert la nouvelle
									$req = $db->prepare('
										UPDATE planning_commission
										SET com_heure_debut = :heure_debut
										WHERE id = :id_com
									');
									$req->bindValue(":heure_debut", $heure_fin, PDO::PARAM_STR);
									$req->bindValue(":id_com", $plage_com_aa_value['id'], PDO::PARAM_INT);
									$req->execute();

									unset($req);
							}
							//Si chevauchement des plages cas 1 : [3-7] + [5-9] => [3-5] + [5-9]
							elseif (
								$obj_heure_plage_debut > $obj_heure_plage_debut2 
								AND 
								(
									$obj_heure_plage_debut < $obj_heure_plage_fin2
									OR
									$plage_com_aa_value['com_heure_fin'] == "00:00:00"									
								)
								AND 
								(
									(
										$obj_heure_plage_fin > $obj_heure_plage_fin2
										AND
										$plage_com_aa_value['com_heure_fin'] != "00:00:00"	
									)
									OR
									(
										$heure_fin == "00:00:00"
										AND
										$plage_com_aa_value['com_heure_fin'] != "00:00:00"
									)
								)
							){
									//echo "chevauchement 2 <br/>";
									// maj le début l'acienne plage par réduction de la période
									//insert la nouvelle
									$req = $db->prepare('
										UPDATE planning_commission
										SET com_heure_fin = :heure_fin
										WHERE id = :id_com
									');
									$req->bindValue(":heure_fin", $heure_debut, PDO::PARAM_STR);
									$req->bindValue(":id_com", $plage_com_aa_value['id'], PDO::PARAM_INT);
									$req->execute();

									unset($req);
							}
						}
					}
					
					$req2 = $db->prepare('
						INSERT INTO planning_commission(terrain_id, utilisateur_api_id, com_montant, com_heure_debut, com_heure_fin, com_jour)
						VALUES (:terrain_id, :utilisateur_api_id, :com_montant, :com_heure_debut, :com_heure_fin, :com_jour)
					');
					$req2->bindValue(":terrain_id", $terrain_value, PDO::PARAM_INT);
					$req2->bindValue(":utilisateur_api_id", $aa_value, PDO::PARAM_INT);
					$req2->bindValue(":com_montant", $commission, PDO::PARAM_INT);
					$req2->bindValue(":com_heure_debut", $heure_debut, PDO::PARAM_STR);
					$req2->bindValue(":com_heure_fin", $heure_fin, PDO::PARAM_STR);
					$req2->bindValue(":com_jour", $jour_value, PDO::PARAM_INT);
					$req2->execute();

					unset($req2);
					
				}
			}
		}
	}
	else {
		return false;
	}
}
/* ----------------------------------------------------			Fonctions relatives tarifs		 ------------------------------------- */

function liste_tarifs_terrain($terrain_id){
	$db = connexionBdd();
	$req = $db->prepare('SELECT * FROM  terrain INNER JOIN planning_tarif ON terrain.id = planning_tarif.terrain_id WHERE terrain.id = :terrain_id');
	$req->bindValue(":terrain_id", $terrain_id, PDO::PARAM_INT);
	$req->execute();
	return $req->fetchAll();
}
function maj_tarifs($heure_debut, $heure_fin, $terrains, $jours, $tarif){
	// $heure_debut et $ heure_fin sont au format H:i:s
	// $terrains et $aa sont des tableaux
	// return false / true
	$db = connexionBdd();
	$obj_heure_plage_debut = DateTime::createFromFormat('H:i:s', $heure_debut);
	$obj_heure_plage_fin = DateTime::createFromFormat('H:i:s', $heure_fin);
	if ($obj_heure_plage_debut < $obj_heure_plage_fin OR $heure_fin == "00:00:00") {
		foreach ($terrains as $terrain_key => $terrain_value) {
			foreach ($jours as $jour_key => $jour_value) {
				$plages_tarifs = liste_tarifs_terrain($terrain_value);
				foreach ($plages_tarifs as $plage_tarif_key => $plage_tarif_value) {
					//echo "dernier foreach <br/>";
					if ($plage_tarif_value['tarif_jour'] == $jour_value){
						//echo "test du jour ok <br/>";
						$obj_heure_plage_debut2 = DateTime::createFromFormat('H:i:s', $plage_tarif_value['tarif_heure_debut']);
						$obj_heure_plage_fin2 = DateTime::createFromFormat('H:i:s', $plage_tarif_value['tarif_heure_fin']);
							
						//Si la plage déclarée inclue la plage testée, => DELETE (au profit de la nouvelle plage) [6-8] + [2-9] => [2-9]
						if (
							$obj_heure_plage_debut <= $obj_heure_plage_debut2 
							AND 
							(
								(
									$obj_heure_plage_fin >= $obj_heure_plage_fin2
									AND
									$plage_tarif_value['tarif_heure_fin'] != "00:00:00"
								)
								OR
								$heure_fin == "00:00:00"
							)
						){
							$req = $db->prepare('DELETE FROM planning_tarif WHERE id = :id_tarif');
							$req->bindValue(":id_tarif", $plage_tarif_value['id'], PDO::PARAM_INT);
							$req->execute();
							unset($req);
							//echo "delete";
						}
						//Si la nouvelle plage est inclu dans une plage plus grande => on scinde en plusieurs plages [1-9] + [2-5] => [1-2]+[2-5]+[5-9]
						elseif (
							$obj_heure_plage_debut >= $obj_heure_plage_debut2 
							AND 
							(
								(
									$obj_heure_plage_fin <= $obj_heure_plage_fin2
									AND
									$heure_fin != "00:00:00"
								)
								OR
								$plage_tarif_value['tarif_heure_fin'] == "00:00:00"
							)
						){

								// On vérifie qu'il s'agisse d'une MAj
								if ($tarif == $plage_tarif_value['tarif_montant']){
								 	// Pas de MAJ
								 	//echo "pas de maj <br/>";
								}
								elseif ($obj_heure_plage_debut == $obj_heure_plage_debut2){
									//[1-9] + [3-9] => [1-3] + [3-9] (commun par la fin)
									// on scinde en deux
									// maj le début l'acienne plage par réduction de la période
									//insert la nouvelle
									//echo "même début donc on décale le début de l'ancienne <br/>";
									$req = $db->prepare('
										UPDATE planning_tarif
										SET tarif_heure_debut = :heure_debut
										WHERE id = :id
									');
									$req->bindValue(":heure_debut", $heure_fin, PDO::PARAM_STR);
									$req->bindValue(":id", $plage_tarif_value['id'], PDO::PARAM_INT);
									$req->execute();

									unset($req);
								}
								elseif ($obj_heure_plage_fin == $obj_heure_plage_fin2){
									//echo "même fin donc on décale la fin  de l'ancienne <br/>";
									//[1-9] + [1-4] => [1-4] + [4-9] (commun par le début)
									// on scinde en deux
									// maj le début l'acienne plage par réduction de la période
									//insert la nouvelle
									$req = $db->prepare('
										UPDATE planning_tarif
										SET tarif_montant = :tarif, tarif_heure_fin = :heure_fin
										WHERE id = :id
									');
									$req->bindValue(":tarif", $tarif, PDO::PARAM_INT);
									$req->bindValue(":heure_fin", $heure_debut, PDO::PARAM_STR);
									$req->bindValue(":id", $plage_tarif_value['id'], PDO::PARAM_INT);
									$req->execute();

									unset($req);
								}
								else{
									//echo "strictement inclu <br/>";
									//[1-9] + [3-5] => [1-3] + [3-5] + [5-9]
									//on supprimme l'ancienne
									//on crée une plage avec le mêmes propriétés que l'ancienne avec début identique à l'ancien et fin = début de la nouvelle plage
									//on crée la nouvelle plage
									//on crée une nouvelle plage avec le mêmes propriétés que l'ancienne. Début = fin de la nouvelle plage et fin = ancienne fin
									
									$req = $db->prepare('DELETE FROM planning_tarif WHERE id = :id');
									$req->bindValue(":id", $plage_tarif_value['id'], PDO::PARAM_INT);
									$req->execute();
									unset($req);
									
									$req2 = $db->prepare('
										INSERT INTO planning_tarif(terrain_id, tarif_montant, tarif_heure_debut, tarif_heure_fin, tarif_jour)
										VALUES (:terrain_id, :tarif, :tarif_heure_debut, :tarif_heure_fin, :tarif_jour)
									');
									$req2->bindValue(":terrain_id", $terrain_value, PDO::PARAM_INT);
									$req2->bindValue(":tarif", $plage_tarif_value['tarif_montant'], PDO::PARAM_INT);
									$req2->bindValue(":tarif_heure_debut", $plage_tarif_value['tarif_heure_debut'], PDO::PARAM_STR);
									$req2->bindValue(":tarif_heure_fin", $heure_debut, PDO::PARAM_STR);
									$req2->bindValue(":tarif_jour", $jour_value, PDO::PARAM_INT);
									$req2->execute();

									$req2 = $db->prepare('
										INSERT INTO planning_tarif(terrain_id, tarif_montant, tarif_heure_debut, tarif_heure_fin, tarif_jour)
										VALUES (:terrain_id, :tarif, :tarif_heure_debut, :tarif_heure_fin, :tarif_jour)
									');
									$req2->bindValue(":terrain_id", $terrain_value, PDO::PARAM_INT);
									$req2->bindValue(":tarif", $plage_tarif_value['tarif_montant'], PDO::PARAM_INT);
									$req2->bindValue(":tarif_heure_debut", $heure_fin, PDO::PARAM_STR);
									$req2->bindValue(":tarif_heure_fin", $plage_tarif_value['tarif_heure_fin'] , PDO::PARAM_STR);
									$req2->bindValue(":tarif_jour", $jour_value, PDO::PARAM_INT);
									$req2->execute();

									unset($req2);
								}
						}
						//Si chevauchement des plages cas 1 : [3-7] + [1-5] => [1-5] + [5-7]
						elseif (
							$obj_heure_plage_debut < $obj_heure_plage_debut2 
							AND 
							(
								(
									$obj_heure_plage_fin < $obj_heure_plage_fin2
									AND
									$heure_fin != "00:00:00"
								)
								OR
								(
									$heure_fin != "00:00:00"
									AND
									$plage_tarif_value['tarif_heure_fin'] == "00:00:00"
								)
							)
							AND
							(
								$obj_heure_plage_fin > $obj_heure_plage_debut2
								OR
								$heure_fin == "00:00:00"
							)
						){
									//echo "chevauchement 1 <br/>";
									// maj le début l'acienne plage par réduction de la période
									//insert la nouvelle
									$req = $db->prepare('
										UPDATE planning_tarif
										SET tarif_heure_debut = :heure_debut
										WHERE id = :id
									');
									$req->bindValue(":heure_debut", $heure_fin, PDO::PARAM_STR);
									$req->bindValue(":id", $plage_tarif_value['id'], PDO::PARAM_INT);
									$req->execute();

									unset($req);
						}
						//Si chevauchement des plages cas 1 : [3-7] + [5-9] => [3-5] + [5-9]
						elseif (
							$obj_heure_plage_debut > $obj_heure_plage_debut2
							AND 
							(
								$obj_heure_plage_debut < $obj_heure_plage_fin2
								OR
								$plage_tarif_value['tarif_heure_fin'] == "00:00:00"
							)
							AND 
							(
								(
									$obj_heure_plage_fin > $obj_heure_plage_fin2
									AND
									$plage_tarif_value['tarif_heure_fin'] != "00:00:00"
								)
								OR
								(
									$heure_fin == "00:00:00"
									AND
									$plage_tarif_value['tarif_heure_fin'] != "00:00:00"
								)
							)
						){
									//echo "chevauchement 2 <br/>";
									// maj le début l'acienne plage par réduction de la période
									//insert la nouvelle
									$req = $db->prepare('
										UPDATE planning_tarif
										SET heure_fin = :heure_fin
										WHERE id = :id
									');
									$req->bindValue(":heure_fin", $heure_debut, PDO::PARAM_STR);
									$req->bindValue(":id", $plage_tarif_value['id'], PDO::PARAM_INT);
									$req->execute();

									unset($req);
						}
					}
				}
				$req2 = $db->prepare('
				INSERT INTO planning_tarif(terrain_id, tarif_montant, tarif_heure_debut, tarif_heure_fin, tarif_jour)
					VALUES (:terrain_id, :tarif_montant, :tarif_heure_debut, :tarif_heure_fin, :tarif_jour)
				');
				$req2->bindValue(":terrain_id", $terrain_value, PDO::PARAM_INT);
				$req2->bindValue(":tarif_montant", $tarif, PDO::PARAM_INT);
				$req2->bindValue(":tarif_heure_debut", $heure_debut, PDO::PARAM_STR);
				$req2->bindValue(":tarif_heure_fin", $heure_fin, PDO::PARAM_STR);
				$req2->bindValue(":tarif_jour", $jour_value, PDO::PARAM_INT);
				$req2->execute();
				unset($req2);
			}
		}
	}
	else {
		return false;
	}
}
?>