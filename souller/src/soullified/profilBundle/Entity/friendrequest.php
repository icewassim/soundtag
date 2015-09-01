<?php

namespace soullified\profilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * friendrequest
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\profilBundle\Entity\friendrequestRepository")
 */
class friendrequest
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
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255,nullable=true)
     */
    private $content;


  /**
    * @ORM\ManyToOne(targetEntity="soullified\profilBundle\Entity\profil",cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */

    private $sender;



  /**
    * @ORM\ManyToOne(targetEntity="soullified\profilBundle\Entity\profil",inversedBy="friendrequests",cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */

    private $receiver;


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
     * Set date
     *
     * @param string $date
     * @return friendrequest
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return friendrequest
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set sender
     *
     * @param \soullified\profilBundle\Entity\profil $sender
     * @return friendrequest
     */
    public function setSender(\soullified\profilBundle\Entity\profil $sender)
    {
        $this->sender = $sender;
    
        return $this;
    }

    /**
     * Get sender
     *
     * @return \soullified\profilBundle\Entity\profil 
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set receiver
     *
     * @param \soullified\profilBundle\Entity\profil $receiver
     * @return friendrequest
     */
    public function setReceiver(\soullified\profilBundle\Entity\profil $receiver)
    {
        $this->receiver = $receiver;
    
        return $this;
    }

    /**
     * Get receiver
     *
     * @return \soullified\profilBundle\Entity\profil 
     */
    public function getReceiver()
    {
        return $this->receiver;
    }
}