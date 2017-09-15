<?php

namespace CmbSdk\ClassesMetiers;

/**
 * Complexe
 *
 */
class Complexe implements ClasseMetierInterface
{

    public function iterateProperties()
    {
        $array_prop_valeurs = array();
        foreach($this as $key => $value) {
            $array_prop_valeurs[$key] = $value;
        }
        return $array_prop_valeurs;
    }

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var Coordonnee
     */
    private $coordonnees;

    /**
     * @var Terrain[]
     */
    private $listeTerrains;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->coordonnees = new Coordonnee();
        $this->listeTerrains = array();
    }


    /**
     * Set id
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Complexe
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set coordonnees
     *
     * @param Coordonnee $coordonnees
     *
     * @return Complexe
     */
    public function setCoordonnees(Coordonnee $coordonnees = null)
    {
        $this->coordonnees = $coordonnees;

        return $this;
    }

    /**
     * Get coordonnees
     *
     * @return Coordonnee
     */
    public function getCoordonnees()
    {
        return $this->coordonnees;
    }

    /**
     * Get listeTerrains
     *
     * @return Terrain[]
     */
    public function getListeTerrains()
    {
        return $this->listeTerrains;
    }

    /**
     * Add terrain
     *
     * @param Terrain $terrain
     *
     * @return Complexe
     */
    public function addListeTerrains(Terrain $terrain) {
        $this->listeTerrains[] = $terrain;

        return $this;
    }
}
