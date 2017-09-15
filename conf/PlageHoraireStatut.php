<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlageHoraireStatut
 *
 * @ORM\Table(name="plage_horaire_statut")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlageHoraireStatutRepository")
 */
class PlageHoraireStatut
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
     * @ORM\Column(name="statutNom", type="string", length=255)
     */
    private $statutNom;


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
     * Set statutNom
     *
     * @param string $statutNom
     *
     * @return PlageHoraireStatut
     */
    public function setStatutNom($statutNom)
    {
        $this->statutNom = $statutNom;

        return $this;
    }

    /**
     * Get statutNom
     *
     * @return string
     */
    public function getStatutNom()
    {
        return $this->statutNom;
    }
}

