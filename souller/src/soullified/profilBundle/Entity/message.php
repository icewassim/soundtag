<?php

namespace soullified\profilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * message
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\profilBundle\Entity\messageRepository")
 */
class message
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
     * @var integer
     *
     * @ORM\Column(name="seen", type="integer",nullable=true)
     */
    private $seen;


    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;


  /**
    * @ORM\ManyToOne(targetEntity="soullified\profilBundle\Entity\profil",cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */

    private $sender;



  /**
    * @ORM\ManyToOne(targetEntity="soullified\profilBundle\Entity\profil",inversedBy="messages",cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */

    private $receiver;


    public function timeElapsed ($time)
    {

        $time = time() - $time; // to get the time since that moment

        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hr',
            60 => 'min',
            1 => 'sec'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }

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
     * Set date
     *
     * @param string $date
     * @return message
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
        $time = strtotime($this->date);
        return $this->timeElapsed($time);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return message
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
     * @return message
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
     * @return message
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
    public function getreceiver()
    {
        return $this->receiver;
    }

    /**
     * Set seen
     *
     * @param integer $seen
     * @return message
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;
    
        return $this;
    }

    /**
     * Get seen
     *
     * @return integer 
     */
    public function getSeen()
    {
        return $this->seen;
    }
}