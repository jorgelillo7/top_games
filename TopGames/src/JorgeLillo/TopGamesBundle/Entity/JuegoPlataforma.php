<?php

namespace JorgeLillo\TopGamesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JuegoPlataforma
 */
class JuegoPlataforma
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $idJuego;

    /**
     * @var integer
     */
    private $idPlataforma;


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
     * Set idJuego
     *
     * @param integer $idJuego
     * @return JuegoPlataforma
     */
    public function setIdJuego($idJuego)
    {
        $this->idJuego = $idJuego;

        return $this;
    }

    /**
     * Get idJuego
     *
     * @return integer 
     */
    public function getIdJuego()
    {
        return $this->idJuego;
    }

    /**
     * Set idPlataforma
     *
     * @param integer $idPlataforma
     * @return JuegoPlataforma
     */
    public function setIdPlataforma($idPlataforma)
    {
        $this->idPlataforma = $idPlataforma;

        return $this;
    }

    /**
     * Get idPlataforma
     *
     * @return integer 
     */
    public function getIdPlataforma()
    {
        return $this->idPlataforma;
    }
}
