<?php

namespace Acme\CologBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Acme\CologBundle\Repository\UserRepository")
 * @ORM\Table(name="userold")
 */
class user
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $nick_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $password;

//    /**
//     * @ORM\Column(type="string", length=255)
//     */
//    protected $img;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $admin;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

//    /**
//     * @return mixed
//     */
//    public function getImg()
//    {
//        return $this->img;
//    }
//
//    /**
//     * @param mixed $img
//     */
//    public function setImg($img)
//    {
//        $this->img = $img;
//
//        return $this;
//    }

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param mixed $admin
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNickName()
    {
        return $this->nick_name;

        return $this;
    }

    /**
     * @param mixed $nick_name
     */
    public function setNickName($nick_name)
    {
        $this->nick_name = $nick_name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

}
