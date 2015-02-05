<?php
// src/Acme/UserBundle/Entity/User.php

namespace Acme\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cosmetician", type="boolean")
     */
    private $cosmetician;

    /**
     * Set cosmetician
     *
     * @param boolean $cosmetician
     * @return user
     */
    public function setCosmetician($cosmetician)
    {
        $this->cosmetician = $cosmetician;

        return $this;
    }

    /**
     * Get cosmetician
     *
     * @return boolean
     */
    public function getCosmetician()
    {
        return $this->cosmetician;
    }

    public function __construct()
    {
        parent::__construct();
        // your own logic


    }
}