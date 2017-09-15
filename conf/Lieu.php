<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lieu
 *
 * @ORM\Table(name="lieu")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LieuxRepository")
 */
class Lieu
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Coordonnee
     *
     * @ORM\Column(name="lieu_nom", type="string")
     */
    private $nom;

    /**
     * @var Coordonnee
     *
     * @ORM\OneToOne(targetEntity="Coordonnee")
     */
    private $coordonnees;

    /**
     * @var Terrain[]
     *
     * @ORM\OneToMany(targetEntity="Terrain", mappedBy="lieu")
     */
    private $listeTerrains;

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
     * Constructor
     */
    public function __construct()
    {
        $this->lieuListeTerrains = new \Doctrine\Common\Collections\ArrayCollection();
    }



    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Lieu
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
     * @param \AppBundle\Entity\Coordonnee $coordonnees
     *
     * @return Lieu
     */
    public function setCoordonnees(\AppBundle\Entity\Coordonnee $coordonnees = null)
    {
        $this->coordonnees = $coordonnees;

        return $this;
    }

    /**
     * Get coordonnees
     *
     * @return \AppBundle\Entity\Coordonnee
     */
    public function getCoordonnees()
    {
        return $this->coordonnees;
    }

    /**
     * Add listeTerrain
     *
     * @param \AppBundle\Entity\Terrain $listeTerrain
     *
     * @return Lieu
     */
    public function addListeTerrain(\AppBundle\Entity\Terrain $listeTerrain)
    {
        $this->listeTerrains[] = $listeTerrain;

        return $this;
    }

    /**
     * Remove listeTerrain
     *
     * @param \AppBundle\Entity\Terrain $listeTerrain
     */
    public function removeListeTerrain(\AppBundle\Entity\Terrain $listeTerrain)
    {
        $this->listeTerrains->removeElement($listeTerrain);
    }

    /**
     * Get listeTerrains
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListeTerrains()
    {
        return $this->listeTerrains;
    }
}
