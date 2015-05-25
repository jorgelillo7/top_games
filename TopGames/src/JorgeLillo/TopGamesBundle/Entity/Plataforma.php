<?php

namespace JorgeLillo\TopGamesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plataforma
 */
class Plataforma
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $color;
    
    /**
     * @var boolean
     */
    private $letraBlanca;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Plataforma
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return Plataforma
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }
  

    /**
     * Set letraBlanca
     *
     * @param boolean $letraBlanca
     * @return Plataforma
     */
    public function setLetraBlanca($letraBlanca)
    {
        $this->letraBlanca = $letraBlanca;

        return $this;
    }

    /**
     * Get letraBlanca
     *
     * @return boolean 
     */
    public function getLetraBlanca()
    {
        return $this->letraBlanca;
    }
}
