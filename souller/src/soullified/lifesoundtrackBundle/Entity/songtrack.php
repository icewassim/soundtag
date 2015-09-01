<?php

namespace soullified\lifesoundtrackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * songtrack
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\lifesoundtrackBundle\Entity\songtrackRepository")
 */
class songtrack
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
     * @ORM\Column(name="songpic", type="string", length=255)
     */
    private $songPic;

    /**
     * @var string
     *
     * @ORM\Column(name="mainTitle", type="string", length=255)
     */
    private $mainTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="artist", type="string", length=255,nullable=true)
     */
    private $artist;

    /**
     * @var string
     *
     * @ORM\Column(name="fulllyrics", type="text", nullable=true)
     */
    private $fulllyrics;

   /**
     * @var boolean
     *
     * @ORM\Column(name="isready", type="boolean",nullable=true)
     */
    private $isready;

    /**
     * @var string
     *
     * @ORM\Column(name="youtubeid", type="string", length=255,nullable=true)
     */
    private $youtubeid;

    
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
     * Set title
     *
     * @param string $title
     * @return songtrack
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set artist
     *
     * @param string $artist
     * @return songtrack
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    
        return $this;
    }

    /**
     * Get artist
     *
     * @return string 
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Set fulllyrics
     *
     * @param string $fulllyrics
     * @return songtrack
     */
    public function setFulllyrics($fulllyrics)
    {
        $this->fulllyrics = $fulllyrics;
        $this->isready = true;
        return $this;
    }

    /**
     * Get fulllyrics
     *
     * @return string 
     */
    public function getFulllyrics()
    {
        return $this->fulllyrics;
    }

    /**
     * Set youtubeid
     *
     * @param string $youtubeid
     * @return songtrack
     */
    public function setYoutubeid($youtubeid)
    {
        $this->youtubeid = $youtubeid;
    
        return $this;
    }

    /**
     * Get youtubeid
     *
     * @return string 
     */
    public function getYoutubeid()
    {
        return $this->youtubeid;
    }


    /**
     * Set mainTitle
     *
     * @param string $mainTitle
     * @return songtrack
     */
    public function setMainTitle($mainTitle)
    {
        $this->mainTitle = $mainTitle;
    
        return $this;
    }


     /**
     * Set songPic
     *
     * @param string $mainTitle
     * @return songtrack
     */
    public function setSongPic($songPic)
    {
        $this->songPic = $songPic;
    
        return $songPic;
    }

    /**
     * Get songPic
     *
     * @return string 
     */
    public function getSongPic()
    {
        return $this->songPic;
    }


    /**
     * Get mainTitle
     *
     * @return string 
     */
    public function getMainTitle()
    {
        return $this->mainTitle;
    }

    /**
     * Set isready
     *
     * @param boolean $isready
     * @return songtrack
     */
    public function setIsready($isready)
    {
        $this->isready = $isready;
    
        return $this;
    }

    /**
     * Get isready
     *
     * @return boolean 
     */
    public function getIsready()
    {
        return $this->isready;
    }
}