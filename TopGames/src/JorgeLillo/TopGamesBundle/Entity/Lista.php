<?php

namespace JorgeLillo\TopGamesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lista
 */
class Lista
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
    private $descripcion;

    /**
     * @var string
     */
    private $autorOriginal;

    /**
     * @var integer
     */
    private $idUsuario;


    public $juegoParaHome;
     
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
     * @return Lista
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Lista
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set autorOriginal
     *
     * @param string $autorOriginal
     * @return Lista
     */
    public function setAutorOriginal($autorOriginal)
    {
        $this->autorOriginal = $autorOriginal;

        return $this;
    }

    /**
     * Get autorOriginal
     *
     * @return string 
     */
    public function getAutorOriginal()
    {
        return $this->autorOriginal;
    }

    /**
     * Set idUsuario
     *
     * @param integer $idUsuario
     * @return Lista
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return integer 
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
    
    public function setJuegoParaHome($juegoParaHome) {
        $this->juegoParaHome = $juegoParaHome;

        return $this;
    }
}
