<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 29/08/2017
 * Time: 15:54
 */

namespace CmbSdk;

use CmbSdk\ClassesMetiers\ClasseMetierInterface;
use CmbSdk\ClassesMetiers\Complexe;
use CmbSdk\ClassesMetiers\ComplexeGerant;
use CmbSdk\ClassesMetiers\Coordonnee;
use CmbSdk\ClassesMetiers\PlageHoraire;
use CmbSdk\ClassesMetiers\PlageHoraireStatut;
use CmbSdk\ClassesMetiers\PlanningComission;
use CmbSdk\ClassesMetiers\PlanningTarif;
use CmbSdk\ClassesMetiers\Reservation;
use CmbSdk\ClassesMetiers\Terrain;
use CmbSdk\ClassesMetiers\TerrainType;
use CmbSdk\ClassesMetiers\UtilisateurApi;
use CmbSdk\Exceptions\ReponseException;

class Actions extends Requetes
{
    // TODO Gérer les permissions
    private $permission_create = false;
    private $permission_read = false;
    private $permission_update = false;
    private $permission_delete = false;

    public function __construct($url, $api_key)
    {
        parent::__construct($url, $api_key);
    }

    public function Creer(UtilisateurApi $user){
        $content = $this->arraySerialize($user);
        return $this->convertJsonToPHP($this->sendPostRequest($content));
    }

    private function arraySerialize(UtilisateurApi $user){
        // TODO Implémenter cette méthode pour toutes les ClassesMetiers
        return array(
            "userClientId" => $user->getUserClientId(),
            "userPassword" => $user->getUserPassword(),
            "nomSociete" => $user->getNomSociete(),
            "adresseL1" => $user->getCoordonnee()->getAdresseLigne1(),
            "adresseL2" => $user->getCoordonnee()->getAdresseLigne2(),
            "ville" => $user->getCoordonnee()->getVille(),
            "codePostal" => $user->getCoordonnee()->getCodePostal(),
            "telephone" => $user->getCoordonnee()->getTelephone(),
            "mail" => $user->getCoordonnee()->getMail()
        );
    }

    private function convertJsonToPHP($reponse_json){
        $array_user_json = json_decode($reponse_json);;
        if (isset($array_user_json->code) && isset($array_user_json->message)){
            throw new ReponseException("Erreur de réponse. Le serveur a renvoyé le code : " . $array_user_json->code
            ." avec le message suivant : " . $array_user_json->message);
        }else{
            $user = new UtilisateurApi();
            return $this->hydraterObjet($user, $array_user_json);
        }
    }

    private function hydraterObjetDansObjet($objet, $getter, $setter, $proprieteObjet){
        if ($objet->$getter() instanceof Complexe) {
            $objet->$setter($this->hydraterObjet(new Complexe(), $proprieteObjet));
        } elseif ($objet->$getter() instanceof ComplexeGerant) {
            $objet->$setter($this->hydraterObjet(new ComplexeGerant(), $proprieteObjet));
        } elseif ($objet->$getter() instanceof Coordonnee) {
            $objet->$setter($this->hydraterObjet(new Coordonnee(), $proprieteObjet));
        } elseif ($objet->$getter() instanceof PlageHoraire) {
            $objet->$setter($this->hydraterObjet(new PlageHoraire(), $proprieteObjet));
        } elseif ($objet->$getter() instanceof PlageHoraireStatut) {
            $objet->$setter($this->hydraterObjet(new PlageHoraireStatut(), $proprieteObjet));
        } elseif ($objet->$getter() instanceof PlanningComission) {
            $objet->$setter($this->hydraterObjet(new PlanningComission(), $proprieteObjet));
        } elseif ($objet->$getter() instanceof PlanningTarif) {
            $objet->$setter($this->hydraterObjet(new PlanningTarif(), $proprieteObjet));
        } elseif ($objet->$getter() instanceof Reservation) {
            $objet->$setter($this->hydraterObjet(new Reservation(), $proprieteObjet));
        } elseif ($objet->$getter() instanceof Terrain) {
            $objet->$setter($this->hydraterObjet(new Terrain(), $proprieteObjet));
        } else if ($objet->$getter() instanceof TerrainType) {
            $objet->$setter($this->hydraterObjet(new TerrainType(), $proprieteObjet));
        }
    }

    private function hydraterObjet(ClasseMetierInterface $objet, $array_user_json){
        foreach ($objet->iterateProperties()as $key => $val) {
            $setter = 'set' . ucfirst($key);
            $getter = 'get' . ucfirst($key);
            if (isset($array_user_json->$key) && method_exists($objet, $setter)) {
                $valeur_a_set = $array_user_json->$key;
                // On appelle le setter ou à nouveau la fonction si la propriété est un objet
                if (is_array($objet->$getter())) {
                    if (count($objet->$getter()) > 0) {
                        foreach ($valeur_a_set as $k => $v) {
                            $setter = 'add' . ucfirst($key);
                            $this->hydraterObjetDansObjet($objet, $getter, $setter, $valeur_a_set);
                        }
                    }
                }elseif ($objet->$getter() instanceof ClasseMetierInterface) {
                    if (method_exists($objet, $getter)){
                        $this->hydraterObjetDansObjet($objet, $getter, $setter, $valeur_a_set);
                    }
                }else{
                    $objet->$setter($array_user_json->$key);
                }
            }
        }
        return $objet;
    }

    /**
     * @return mixed
     */
    public function getPermissionCreate()
    {
        return $this->permission_create;
    }
    /**
     * @param mixed $permission_create
     */
    public function setPermissionCreate($permission_create)
    {
        $this->permission_create = $permission_create;
    }

    /**
     * @return mixed
     */
    public function getPermissionRead()
    {
        return $this->permission_read;
    }
    /**
     * @param mixed $permission_read
     */
    public function setPermissionRead($permission_read)
    {
        $this->permission_read = $permission_read;
    }

    /**
     * @return mixed
     */
    public function getPermissionUpdate()
    {
        return $this->permission_update;
    }
    /**
     * @param mixed $permission_update
     */
    public function setPermissionUpdate($permission_update)
    {
        $this->permission_update = $permission_update;
    }

    /**
     * @return mixed
     */
    public function getPermissionDelete()
    {
        return $this->permission_delete;
    }
    /**
     * @param mixed $permission_delete
     */
    public function setPermissionDelete($permission_delete)
    {
        $this->permission_delete = $permission_delete;
    }

}