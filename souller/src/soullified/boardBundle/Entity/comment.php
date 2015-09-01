<?php

namespace soullified\boardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * comment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\boardBundle\Entity\commentRepository")
 */
class comment
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
     * @ORM\Column(name="nbrsubcomments", type="integer",nullable=true)
     */
    private $nbrsubcomments;

    /**
     * @var integer
     *
     * @ORM\Column(name="votes", type="integer",nullable=true)
     */
    private $votes;


  /**
    * @ORM\OneToMany(targetEntity="soullified\boardBundle\Entity\subcomment",mappedBy="comment",cascade={"persist","remove"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $subcomments;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

        /**
     * @var string
     *
     * @ORM\Column(name="allowedcontent", type="string", length=255,nullable=true)
     */
    private $allowedContent;


   /**
     * @var string
     *
     * @ORM\Column(name="longtitle", type="string", length=25500 ,nullable= true)
     */
    private $longtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255,nullable= true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="font", type="string", length=255,nullable= true)
     */
    private $font;


    /**
     * @var string
     *
     * @ORM\Column(name="posx", type="string", length=255,nullable= true)
     */
    private $posx;


    /**
     * @var string
     *
     * @ORM\Column(name="posy", type="string", length=255,nullable= true)
     */
    private $posy;


    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=255,nullable= true)
     */
    private $size;


  /**
    * @ORM\ManyToOne(targetEntity="soullified\boardBundle\Entity\board",inversedBy="comments",cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */

    private $board;

  
  /**
    * @ORM\ManyToOne(targetEntity="soullified\boardBundle\Entity\host",inversedBy="comments",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $host;


  /**
    * @ORM\ManyToOne(targetEntity="soullified\profilBundle\Entity\profil",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $owner;


    /**
     * @var string
     *
     * @ORM\Column(name="rotation", type="string", length=255)
     */
    private $rotation;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;


    public function comment($color,$content,$allowedContent,$longtitle,$rotation,$size,$posy,$posx,$font,$date)
    {
        $this->color=$color;
        $this->rotation=$rotation;
        $this->size=$size;
        $this->posy=$posy;
        $this->posx=$posx;
        $this->font=$font;
        $this->date=$date;
        $this->content=$content;
        $this->allowedContent=$allowedContent;
        $this->longtitle=$longtitle;
        $this->nbrsubcomments = 0;
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
     * @return comment
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
     * Get allowedContent
     *
     * @return string 
     */
    public function getAllowedContent()
    {
        return $this->allowedContent;
    }

    /**
     * Set longtitle
     *
     * @param string $longtitle
     * @return comment
     */
    public function setLongtitle($longtitle)
    {
        $this->longtitle = $longtitle;
        return $this;
    }

    /**
     * Get longtitle
     *
     * @return string 
     */
    public function getLongtitle()
    {
        return $this->longtitle;
    }

    /**
     * Set date
     *
     * @param string $date
     * @return comment
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
     * Set font
     *
     * @param string $font
     * @return comment
     */
    public function setFont($font)
    {
        $this->font = $font;
    
        return $this;
    }

    /**
     * Get font
     *
     * @return string 
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return comment
     */
    public function setSize($size)
    {
        $this->size = $size;
    
        return $this;
    }

    /**
     * Get size
     *
     * @return string 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set rotation
     *
     * @param string $rotation
     * @return comment
     */
    public function setRotation($rotation)
    {
        $this->rotation = $rotation;
    
        return $this;
    }

    /**
     * Get rotation
     *
     * @return string 
     */
    public function getRotation()
    {
        return $this->rotation;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return comment
     */
    public function setColor($color)
    {
        $this->color = $color;
    
        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set posx
     *
     * @param string $posx
     * @return comment
     */
    public function setPosx($posx)
    {
        $this->posx = $posx;
    
        return $this;
    }

    /**
     * Get posx
     *
     * @return string 
     */
    public function getPosx()
    {
        return $this->posx;
    }

    /**
     * Set posy
     *
     * @param string $posy
     * @return comment
     */
    public function setPosy($posy)
    {
        $this->posy = $posy;
    
        return $this;
    }

    /**
     * Get posy
     *
     * @return string 
     */
    public function getPosy()
    {
        return $this->posy;
    }


      /**
     * Set board
     *
     * @param \soullified\boardBundle\Entity\board $board
     * @return album
     */
    public function setBoard(\soullified\boardBundle\Entity\board $board)
    {
        $this->board = $board;
    
        return $this;
    }

    /**
     * Get board
     *
     * @return \soullified\boardBundle\Entity\board 
     */
    public function getBoard()
    {
        return $this->board;
    }



      /**
     * Set host
     *
     * @param \soullified\boardBundle\Entity\host $host
     * @return host
     */
    public function setHost(\soullified\boardBundle\Entity\host $host)
    {
        $this->host = $host;
    
        return $this;
    }

    /**
     * Get host
     *
     * @return \soullified\boardBundle\Entity\host 
     */
    public function getHost()
    {
        return $this->host;
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
     * Constructor
     */
    public function __construct()
    {
        $this->subcomments = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add subcomments
     *
     * @param \soullified\boardBundle\Entity\subcomment $subcomments
     * @return comment
     */
    public function addSubcomment(\soullified\boardBundle\Entity\subcomment $subcomments)
    {
        $this->subcomments[] = $subcomments;
        $this->nbrsubcomments = $this->nbrsubcomments + 1;
        return $this;
    }

    /**
     * Remove subcomments
     *
     * @param \soullified\boardBundle\Entity\subcomment $subcomments
     */
    public function removeSubcomment(\soullified\boardBundle\Entity\subcomment $subcomments)
    {
        $this->subcomments->removeElement($subcomments);
        $this->nbrsubcomments = $this->nbrsubcomments - 1;
    }

    /**
     * Get subcomments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubcomments()
    {
        return $this->subcomments;
    }

    /**
     * Set nbrsubcomments
     *
     * @param integer $nbrsubcomments
     * @return comment
     */
    public function setNbrsubcomments($nbrsubcomments)
    {
        $this->nbrsubcomments = $nbrsubcomments;
    
        return $this;
    }

    /**
     * Set votes
     *
     * @param integer $nbrsubcomments
     * @return comment
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;
        return $this;
    }

    /**
     * Get nbrsubcomments
     *
     * @return integer 
     */
    public function getNbrsubcomments()
    {
        return $this->nbrsubcomments;
    }

    /**
     * Get votes
     *
     * @return integer 
     */
    public function getVotes()
    {
        return $this->votes;
    }

    public function upVote()
    {
        $this->votes = $this->votes +1;
    }

    public function downVote()
    {
        $this->votes = $this->votes -1;
    }


}