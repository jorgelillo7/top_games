<?php

namespace JorgeLillo\TopGamesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * juego
 */
class Juego
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string titulo
     */
    private $titulo;

    /**
     * @var string descripcion
     */
    private $descripcion;
    /**
     * 
     * 
     * 
     */
    private $imagen;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->titulo = '';
        $this->descripcion = '';
    }
    
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
     * Set titulo
     *
     * @param  string  $titulo
     * @return Juego
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string titulo
     */
    public function getTitulo()
    {
        return $this->titulo;
    }
    
      /**
     * Set descripcion
     *
     * @param  string  $descripcion
     * @return Juego
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

}
