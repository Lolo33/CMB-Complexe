<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Terrain
 *
 * @ORM\Table(name="terrain")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TerrainRepository")
 */
class Terrain
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
     * @var string
     *
     * @ORM\Column(name="terrain_nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var TerrainType
     *
     * @ORM\ManyToOne(targetEntity="TerrainType")
     */
    private $type;

    /**
     * @var Lieu
     *
     * @ORM\ManyToOne(targetEntity="Lieu", inversedBy="listeTerrains")
     */
    private $lieu;

    /**
     * @var Lieu
     *
     * @ORM\OneToMany(targetEntity="PlageHoraire", mappedBy="terrain")
     */
    private $listeHoraires;

    /**
     * @var Lieu
     *
     * @ORM\OneToMany(targetEntity="PlanningTarif", mappedBy="terrain")
     */
    private $listeTarifs;

    /**
     * @var Lieu
     *
     * @ORM\OneToMany(targetEntity="PlanningComission", mappedBy="terrain")
     */
    private $listeComissions;


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
     * @return Terrain
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
     * Set type
     *
     * @param \AppBundle\Entity\TerrainType $type
     *
     * @return Terrain
     */
    public function setType(\AppBundle\Entity\TerrainType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\TerrainType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set lieu
     *
     * @param \AppBundle\Entity\Lieu $lieu
     *
     * @return Terrain
     */
    public function setLieu(\AppBundle\Entity\Lieu $lieu = null)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return \AppBundle\Entity\Lieu
     */
    public function getLieu()
    {
        return $this->lieu;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->listeHoraires = new \Doctrine\Common\Collections\ArrayCollection();
        $this->listeTarifs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->listeComissions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add listeHoraire
     *
     * @param \AppBundle\Entity\PlageHoraire $listeHoraire
     *
     * @return Terrain
     */
    public function addListeHoraire(\AppBundle\Entity\PlageHoraire $listeHoraire)
    {
        $this->listeHoraires[] = $listeHoraire;

        return $this;
    }

    /**
     * Remove listeHoraire
     *
     * @param \AppBundle\Entity\PlageHoraire $listeHoraire
     */
    public function removeListeHoraire(\AppBundle\Entity\PlageHoraire $listeHoraire)
    {
        $this->listeHoraires->removeElement($listeHoraire);
    }

    /**
     * Get listeHoraires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListeHoraires()
    {
        return $this->listeHoraires;
    }

    /**
     * Add listeTarif
     *
     * @param \AppBundle\Entity\PlanningTarif $listeTarif
     *
     * @return Terrain
     */
    public function addListeTarif(\AppBundle\Entity\PlanningTarif $listeTarif)
    {
        $this->listeTarifs[] = $listeTarif;

        return $this;
    }

    /**
     * Remove listeTarif
     *
     * @param \AppBundle\Entity\PlanningTarif $listeTarif
     */
    public function removeListeTarif(\AppBundle\Entity\PlanningTarif $listeTarif)
    {
        $this->listeTarifs->removeElement($listeTarif);
    }

    /**
     * Get listeTarifs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListeTarifs()
    {
        return $this->listeTarifs;
    }

    /**
     * Add listeComission
     *
     * @param \AppBundle\Entity\PlanningComission $listeComission
     *
     * @return Terrain
     */
    public function addListeComission(\AppBundle\Entity\PlanningComission $listeComission)
    {
        $this->listeComissions[] = $listeComission;

        return $this;
    }

    /**
     * Remove listeComission
     *
     * @param \AppBundle\Entity\PlanningComission $listeComission
     */
    public function removeListeComission(\AppBundle\Entity\PlanningComission $listeComission)
    {
        $this->listeComissions->removeElement($listeComission);
    }

    /**
     * Get listeComissions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListeComissions()
    {
        return $this->listeComissions;
    }
}
