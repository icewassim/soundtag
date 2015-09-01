<?php

namespace soullified\profilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * friend
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\profilBundle\Entity\friendRepository")
 */
class friend
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


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
    * @ORM\OneToOne(targetEntity="soullified\profilBundle\Entity\profil",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $profil;


    /**
     * Set profil
     *
     * @param \soullified\profilBundle\Entity\profil $profil
     * @return friend
     */
    public function setProfil(\soullified\profilBundle\Entity\profil $profil = null)
    {
        $this->profil = $profil;
    
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
}