<?php

namespace soullified\boardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * upvotes
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\boardBundle\Entity\upvotesRepository")
 */
class upvotes
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
    * @ORM\ManyToOne(targetEntity="soullified\profilBundle\Entity\profil",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $owner;

   /**
     * @var boolean
     *
     * @ORM\Column(name="isup", type="boolean",nullable=true)
     */
    private $isup;

    /**
     * @var integer
     *
     * @ORM\Column(name="commentid", type="integer")
     */
    private $commentid;

    /**
     * @var integer
     *
     * @ORM\Column(name="boardid", type="integer")
     */
    private $boardid;

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
     * Set commentid
     *
     * @param integer $commentid
     * @return upvotes
     */
    public function setCommentid($commentid)
    {
        $this->commentid = $commentid;
    
        return $this;
    }

    /**
     * Get commentid
     *
     * @return integer 
     */
    public function getCommentid()
    {
        return $this->commentid;
    }

    /**
     * Set boardid
     *
     * @param integer $boardid
     * @return upvotes
     */
    public function setBoardid($boardid)
    {
        $this->boardid = $boardid;
    
        return $this;
    }

    /**
     * Get boardid
     *
     * @return integer 
     */
    public function getBoardid()
    {
        return $this->boardid;
    }

    /**
     * Set owner
     *
     * @param \soullified\profilBundle\Entity\profil $owner
     * @return upvotes
     */
    public function setOwner(\soullified\profilBundle\Entity\profil $owner = null)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return \soullified\profilBundle\Entity\profil 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set isup
     *
     * @param boolean $isup
     * @return board
     */
    public function setIsUp($isup)
    {
        $this->isup = $isup;
    
        return $this;
    }

    /**
     * Get isup
     *
     * @return boolean 
     */
    public function getIsUp()
    {
        return $this->isup;
    }
}