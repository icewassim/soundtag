<?php

namespace soullified\profilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * event
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\profilBundle\Entity\eventRepository")
 */
class event
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255,nullable=true)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255)
     */
    private $date;


  /**
    * @ORM\ManyToOne(targetEntity="soullified\profilBundle\Entity\profil",cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */

    private $sender;



  /**
    * @ORM\ManyToOne(targetEntity="soullified\profilBundle\Entity\profil",inversedBy="events",cascade={"persist"})
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
     * Set type
     *
     * @param string $type
     * @return event
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return event
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
     * Set date
     *
     * @param string $date
     * @return event
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
     * Set sender
     *
     * @param \soullified\profilBundle\Entity\profil $sender
     * @return event
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
     * @return event
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