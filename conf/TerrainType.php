<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TerrainType
 *
 * @ORM\Table(name="type_terrain")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeTerrainRepository")
 */
class TerrainType
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
     * @ORM\Column(name="typeNom", type="string", length=255)
     */
    private $typeNom;


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
     * Set typeNom
     *
     * @param string $typeNom
     *
     * @return TerrainType
     */
    public function setTypeNom($typeNom)
    {
        $this->typeNom = $typeNom;

        return $this;
    }

    /**
     * Get typeNom
     *
     * @return string
     */
    public function getTypeNom()
    {
        return $this->typeNom;
    }
}

