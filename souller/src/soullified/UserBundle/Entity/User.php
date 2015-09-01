<?php

namespace soullified\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;



/**
* @ORM\Entity
* @ORM\Table(name="user")
*/
class User extends BaseUser
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

   /**
    * @ORM\OneToOne(targetEntity="soullified\profilBundle\Entity\profil",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    protected $profil;


    /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;
 

    /**
     * @var string
     *
     * @ORM\Column(name="google_id",type="string", length=255, nullable=true)
     */
    protected $google_id;


    /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
    protected $google_access_token;

    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;

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
     * Set profil
     *
     * @param \soullified\profilBundle\Entity\profil $profil
     * @return User
     */
    public function setProfil(\soullified\profilBundle\Entity\profil $profil = null)
    {
        $this->profil = $profil;
        // $profil->setFullname($this->username);
        return $this;
    }

    /**
     * Get profil
     *
     * @return \soullified\profilBundle\Entity\profil 
     */
    public function getProfil()
    {
        return $this->profil;
    }

    public function setGoogleAccessToken($google_access_token) {

        $this->google_access_token=$google_access_token;

    }

    public function setGoogleId($googleId) {

        $this->google_id=$googleId;

    }


    public function getGoogle_id() {

       return  $this->google_id;

    }


    public function getFacebook_id() {

       return  $this->facebook_id;

    }


    public function setFacebookAccessToken($facebook_access_token) {

        $this->facebook_access_token=$facebook_access_token;

    }

    public function setFacebook_id($facebook_id) {

        $this->facebook_id=$facebook_id;

    }

}