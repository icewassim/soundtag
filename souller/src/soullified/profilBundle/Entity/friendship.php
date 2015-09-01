<?php

namespace soullified\profilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * friendship
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\profilBundle\Entity\friendshipRepository")
 */
class friendship
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
    * @ORM\ManyToOne(targetEntity="soullified\profilBundle\Entity\profil",inversedBy="friendship",cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */

    private $firstfriend;



      /**
    * @ORM\ManyToOne(targetEntity="soullified\profilBundle\Entity\profil",cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */

    private $secondfriend;


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
     * Set firstfriend
     *
     * @param \soullified\profilBundle\Entity\profil $firstfriend
     * @return friendship
     */
    public function setFirstfriend(\soullified\profilBundle\Entity\profil $firstfriend)
    {
        $this->firstfriend = $firstfriend;
    
        return $this;
    }

    /**
     * Get firstfriend
     *
     * @return \soullified\profilBundle\Entity\profil 
     */
    public function getFirstfriend()
    {
        return $this->firstfriend;
    }

    /**
     * Set secondfriend
     *
     * @param \soullified\profilBundle\Entity\profil $secondfriend
     * @return friendship
     */
    public function setSecondfriend(\soullified\profilBundle\Entity\profil $secondfriend)
    {
        $this->secondfriend = $secondfriend;
    
        return $this;
    }

    /**
     * Get secondfriend
     *
     * @return \soullified\profilBundle\Entity\profil 
     */
    public function getSecondfriend()
    {
        return $this->secondfriend;
    }
}