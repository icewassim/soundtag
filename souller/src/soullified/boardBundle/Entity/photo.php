<?php

namespace soullified\boardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * photo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\boardBundle\Entity\photoRepository")
 */
class photo
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

  /**
    * @ORM\ManyToOne(targetEntity="soullified\boardBundle\Entity\board",inversedBy="photos",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $board;


   /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=255)
     */
    private $folder;


    /**
     * @var string
     *
     * @ORM\Column(name="posx", type="float",nullable=true)
     */
    private $posx;


    /**
     * @var string
     *
     * @ORM\Column(name="posy", type="float",nullable=true)
     */
    private $posy;


    /**
     * @var string
     *
     * @ORM\Column(name="rotation", type="string", length=255,nullable=true)
     */
    private $rotation;


    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255)
     */
    private $date;


    /**
     * Set url
     *
     * @param string $url
     * @return photo
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return photo
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
     * Set date
     *
     * @param string $date
     * @return photo
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
     * Get folder
     *
     * @return string 
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Set folder
     *
     * @param float $folder
     * @return album
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
    
        return $this;
    }

        /**
     * Set posx
     *
     * @param float $posx
     * @return album
     */
    public function setPosx($posx)
    {
        $this->posx = $posx;
    
        return $this;
    }

    /**
     * Get posx
     *
     * @return float 
     */
    public function getPosx()
    {
        return $this->posx;
    }

    /**
     * Set posy
     *
     * @param float $posy
     * @return album
     */
    public function setPosy($posy)
    {
        $this->posy = $posy;
    
        return $this;
    }

    /**
     * Get posy
     *
     * @return float 
     */
    public function getPosy()
    {
        return $this->posy;
    }

    /**
     * Set rotation
     *
     * @param string $rotation
     * @return album
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set description
     *
     * @param string $description
     * @return album
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

}