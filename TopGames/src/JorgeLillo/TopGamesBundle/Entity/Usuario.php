<?php

namespace JorgeLillo\TopGamesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Usuario
 */
class Usuario implements UserInterface, \Serializable
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string Nombre del usuario
     */
    private $username;

    /**
     * @var string Contraseña del usuario
     */
    private $password;

    /**
     * @var boolean Indica si el usuario es Administrador
     */
    private $isAdmin;

    /**
     * @var boolean Indica si el usuario está o no activo
     */
    private $isActive;

    /**
     * @var string Dirección de correo electrónico
     */
    private $email;

    /**
     * @var \DateTime Fecha de alta
     */
    private $createTime;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isAdmin = false;
        $this->isActive = true;
        $this->createTime = new \DateTime();
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
     * Set username
     *
     * @param  string  $username
     * @return Usuario
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param  string  $password
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set isAdmin
     *
     * @param  boolean $isAdmin
     * @return Usuario
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get isAdmin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Set isActive
     *
     * @param  boolean $isActive
     * @return Usuario
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * Set email
     *
     * @param  string  $email
     * @return Usuario
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set createTime
     *
     * @param  \DateTime $createTime
     * @return Usuario
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return \DateTime
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        if ($this->isActive) { // sólo si el usuario está activo
            $roles = ($this->isAdmin) ? array('ROLE_ADMIN', 'ROLE_USER') : array('ROLE_USER');
        } else {
            $roles = array();
        }

        return $roles;
    }

    /**
     * {@inheritDoc}
     */
    public function getSalt()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
          $this->id,
          $this->username,
          $this->password,
          $this->isActive,
          $this->isAdmin,
          $this->email,
      ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list(
          $this->id,
          $this->username,
          $this->password,
          $this->isActive,
          $this->isAdmin,
          $this->email,
          ) = unserialize($serialized);
    }
    
    

    /**
     * Get isAdmin
     *
     * @return boolean 
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
