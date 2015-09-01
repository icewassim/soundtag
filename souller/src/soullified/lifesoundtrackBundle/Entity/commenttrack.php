<?php

namespace soullified\lifesoundtrackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * commenttrack
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\lifesoundtrackBundle\Entity\commenttrackRepository")
 */
class commenttrack
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
     * @ORM\Column(name="content", type="string", length=255)
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
    * @ORM\JoinColumn(nullable=true)
    */

    private $owner;


  /**
    * @ORM\ManyToOne(targetEntity="soullified\lifesoundtrackBundle\Entity\track",inversedBy="commentstrack",cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */

    private $track;
    

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
     * Set content
     *
     * @param string $content
     * @return commenttrack
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

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
     * @return commenttrack
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
     * Set owner
     *
     * @param \soullified\profilBundle\Entity\profil $owner
     * @return comment
     */
    public function setOwner(\soullified\profilBundle\Entity\profil $owner)
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
     * Set track
     *
     * @param \soullified\lifesoundtrackBundle\Entity\track $track
     * @return commenttrack
     */
    public function setTrack(\soullified\lifesoundtrackBundle\Entity\track $track)
    {
        $this->track = $track;
    
        return $this;
    }

    /**
     * Get track
     *
     * @return \soullified\lifesoundtrackBundle\Entity\track 
     */
    public function getTrack()
    {
        return $this->track;
    }
    
}