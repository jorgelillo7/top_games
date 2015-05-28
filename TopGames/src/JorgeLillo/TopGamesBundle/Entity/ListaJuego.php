<?php

namespace JorgeLillo\TopGamesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListaJuego
 */
class ListaJuego
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $idLista;

    /**
     * @var integer
     */
    private $idJuego;


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
     * Set idLista
     *
     * @param integer $idLista
     * @return ListaJuego
     */
    public function setIdLista($idLista)
    {
        $this->idLista = $idLista;

        return $this;
    }

    /**
     * Get idLista
     *
     * @return integer 
     */
    public function getIdLista()
    {
        return $this->idLista;
    }

    /**
     * Set idJuego
     *
     * @param integer $idJuego
     * @return ListaJuego
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
}
