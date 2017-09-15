<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReservationRepository")
 */
class Reservation
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
     * @ORM\Column(name="res_reference", type="string", length=15)
     */
    private $reference;

    /**
     * @var bool
     *
     * @ORM\Column(name="res_est_confirmee", type="boolean")
     */
    private $estConfirmee;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="PlageHoraire", mappedBy="reservation")
     */
    private $plageHoraire;


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
     * Set reference
     *
     * @param string $reference
     *
     * @return Reservation
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set estConfirmee
     *
     * @param boolean $estConfirmee
     *
     * @return Reservation
     */
    public function setEstConfirmee($estConfirmee)
    {
        $this->estConfirmee = $estConfirmee;

        return $this;
    }

    /**
     * Get estConfirmee
     *
     * @return bool
     */
    public function getEstConfirmee()
    {
        return $this->estConfirmee;
    }

    /**
     * Set plageHoraire
     *
     * @param string $plageHoraire
     *
     * @return Reservation
     */
    public function setPlageHoraire($plageHoraire)
    {
        $this->plageHoraire = $plageHoraire;

        return $this;
    }

    /**
     * Get plageHoraire
     *
     * @return string
     */
    public function getPlageHoraire()
    {
        return $this->plageHoraire;
    }
}

