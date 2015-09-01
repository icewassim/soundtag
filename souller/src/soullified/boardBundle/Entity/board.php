<?php

namespace soullified\boardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * board
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\boardBundle\Entity\boardRepository")
 */
class board
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
     * @ORM\Column(name="title", type="string", length=255,nullable=true)
     */
    private $title;

   /**
     * @var integer
     *
     * @ORM\Column(name="maxheigth", type="integer",nullable=true)
     */
    private $maxheigth;

  /**
     * @var string
     *
     * @ORM\Column(name="container", type="string", length=255,nullable=true)
     */
    private $container;

   /**
     * @var boolean
     *
     * @ORM\Column(name="darkBackground", type="boolean",nullable=true)
     */
    private $darkBackground;


   /**
     * @var boolean
     *
     * @ORM\Column(name="iscommunity", type="boolean",nullable=true)
     */
    private $iscommunity;


   /**
     * @var boolean
     *
     * @ORM\Column(name="pinned", type="boolean",nullable=true)
     */
    private $pinned;

  /**
    * @ORM\ManyToOne(targetEntity="soullified\lifesoundtrackBundle\Entity\track",inversedBy="board",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $track;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255,nullable=true)
     */
    private $url;


    /**
     * @var string
     *
     * @ORM\Column(name="viewprivacy", type="string", length=255,nullable=true)
     */
    private $viewprivacy;

    /**
     * @var string
     *
     * @ORM\Column(name="commentpricacy", type="string", length=255,nullable=true)
     */
    private $commentprivacy;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


  /**
    * @ORM\OneToMany(targetEntity="soullified\boardBundle\Entity\photo",mappedBy="board",cascade={"persist","remove"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $photos;



    /**
    * @ORM\ManyToMany(targetEntity="soullified\profilBundle\Entity\profil", mappedBy="boardsliked",cascade={"persist","remove"})
    */
    protected $likers;
    

  /**
    * @ORM\ManyToOne(targetEntity="soullified\profilBundle\Entity\profil",inversedBy="boards",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $profil;


  /**
    * @ORM\OneToMany(targetEntity="soullified\boardBundle\Entity\comment",mappedBy="board",cascade={"persist","remove"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $comments;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255,nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="previewpic", type="string", length=255,nullable=true)
     */
    private $previewpic;

   /**
     * @var integer
     *
     * @ORM\Column(name="popularity", type="integer",nullable=true)
     */
    private $popularity;

   /**
     * @var integer
     *
     * @ORM\Column(name="maxLetters", type="integer",nullable=true)
     */
    private $maxLetters;

   /**
     * @var integer
     *
     * @ORM\Column(name="isprofil", type="integer",nullable=true)
     */
    private $isprofil;

       /**
     * @var integer
     *
     * @ORM\Column(name="filter", type="integer",nullable=true)
     */
    private $filter;

    /**
     * @var string
     *
     * @ORM\Column(name="coverurl", type="string", length=255,nullable=true)
     */
    private $coverurl;

        /**
     * @var string
     *
     * @ORM\Column(name="postop", type="string", length=255,nullable=true)
     */
    private $postop;

        /**
     * @var string
     *
     * @ORM\Column(name="posleft", type="string", length=255,nullable=true)
     */
    private $posleft;


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
     * @return board
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
     * Set description
     *
     * @param string $description
     * @return board
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

    /**
     * Set date
     *
     * @param string $date
     * @return board
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
     * Set maxheigth
     *
     * @param integer $maxheigth
     * @return board
     */
    public function setMaxheigth($maxheigth)
    {
        $this->maxheigth = $maxheigth;
    
        return $this;
    }

    /**
     * Get maxheigth
     *
     * @return integer 
     */
    public function getMaxheigth()
    {
        return $this->maxheigth;
    }



    /**
     * Set coverurl
     *
     * @param string $coverurl
     * @return board
     */
    public function setCoverurl($coverurl)
    {
        $this->coverurl = $coverurl;
    
        return $this;
    }

    /**
     * Get coverurl
     *
     * @return string 
     */
    public function getCoverurl()
    {
        return $this->coverurl;
    }


     public function addPhoto(\soullified\boardBundle\Entity\photo $photos)
    {
        $this->photos[] = $photos;
    
        return $this;
    }

    /**
     * Remove photos
     *
     * @param \soullified\boardBundle\Entity\photo $photos
     */
    public function removePhoto(\soullified\boardBundle\Entity\photo $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    public function addComment(\soullified\boardBundle\Entity\comment $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \soullified\boardBundle\Entity\comment $comments
     */
    public function removeComment(\soullified\boardBundle\Entity\comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getcomments()
    {
        return $this->comments;
    }

    /**
     * Set profil
     *
     * @param \soullified\profilBundle\Entity\profil $profil
     * @return video
     */
    public function setprofil(\soullified\profilBundle\Entity\profil $profil)
    {
        $this->profil = $profil;
    
        return $this;
    }

    /**
     * Get profil
     *
     * @return \soullified\profilBundle\Entity\profil 
     */
    public function getprofil()
    {
        return $this->profil;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set postop
     *
     * @param string $postop
     * @return board
     */
    public function setpostop($postop)
    {
        $this->postop = $postop;
    
        return $this;
    }

    /**
     * Get postop
     *
     * @return string 
     */
    public function getpostop()
    {
        return $this->postop;
    }

    /**
     * Set posleft
     *
     * @param string $posleft
     * @return board
     */
    public function setposleft($posleft)
    {
        $this->posleft = $posleft;
    
        return $this;
    }

    /**
     * Get posleft
     *
     * @return string 
     */
    public function getposleft()
    {
        return $this->posleft;
    }

    
    public function resetplaylist(){

        $this->songs[]=NULL;

    }


    /**
     * Set url
     *
     * @param string $url
     * @return board
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
     * Set previewpic
     *
     * @param string $previewpic
     * @return board
     */
    public function setPreviewpic($previewpic)
    {
        $this->previewpic = $previewpic;
    
        return $this;
    }

    /**
     * Get previewpic
     *
     * @return string 
     */
    public function getPreviewpic()
    {
        return $this->previewpic;
    }


    

    /**
     * Set viewprivacy
     *
     * @param string $viewprivacy
     * @return board
     */
    public function setViewprivacy($viewprivacy)
    {
        $this->viewprivacy = $viewprivacy;
    
        return $this;
    }

    /**
     * Get viewprivacy
     *
     * @return string 
     */
    public function getViewprivacy()
    {
        return $this->viewprivacy;
    }

    /**
     * Set commentprivacy
     *
     * @param string $commentprivacy
     * @return board
     */
    public function setCommentprivacy($commentprivacy)
    {
        $this->commentprivacy = $commentprivacy;
    
        return $this;
    }

    /**
     * Get commentprivacy
     *
     * @return string 
     */
    public function getCommentprivacy()
    {
        return $this->commentprivacy;
    }

    public function copyboard(\soullified\boardBundle\Entity\board $clone){ 
        $this->url=$clone->getUrl();
        $this->comments=$clone->getComments();
        $this->title=$clone->getTitle();
        $this->viewprivacy=$clone->getViewprivacy();
        $this->commentprivacy=$clone->getCommentprivacy();
        $this->description=$clone->getDescription();
        $this->profil=$clone->getProfil();    
    }

    /**
     * Add likers
     *
     * @param \soullified\profilBundle\Entity\profil $likers
     * @return board
     */
    public function addLiker(\soullified\profilBundle\Entity\profil $likers)
    {
        $this->likers[] = $likers;
    
        return $this;
    }

    /**
     * Remove likers
     *
     * @param \soullified\profilBundle\Entity\profil $likers
     */
    public function removeLiker(\soullified\profilBundle\Entity\profil $likers)
    {
        $this->likers->removeElement($likers);
    }

    /**
     * Get likers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLikers()
    {
        return $this->likers;
    }

    /**
     * Set popularity
     *
     * @param integer $popularity
     * @return board
     */
    public function setpopularity($popularity)
    {
        $this->popularity = $popularity;
    
        return $this;
    }

    /**
     * Get popularity
     *
     * @return integer
     */
    public function getpopularity()
    {
        return $this->popularity;
    }

    public function incrementpopularity()
    {
        $this->popularity++;
    }
    

    public function decrementpopularity()
    {
        $this->popularity--;
    }
   

   /**
     * Set isprofil
     *
     * @param integer $isprofil
     * @return board
     */
    public function setIsprofil($isprofil)
    {
        $this->isprofil = $isprofil;
    
        return $this;
    }

    /**
     * Get isprofil
     *
     * @return integer 
     */
    public function getIsprofil()
    {
        return $this->isprofil;
    }



        /**
     * Set darkBackground
     *
     * @param boolean $darkBackground
     * @return board
     */
    public function setDarkBackground($darkBackground)
    {
        $this->darkBackground = $darkBackground;
    
        return $this;
    }

    /**
     * Get darkBackground
     *
     * @return boolean 
     */
    public function getDarkBackground()
    {
        return $this->darkBackground;
    }



        /**
     * Set pinned
     *
     * @param boolean $pinned
     * @return board
     */
    public function setPinned($pinned)
    {
        $this->pinned = $pinned;
    
        return $this;
    }

    /**
     * Get pinned
     *
     * @return boolean 
     */
    public function getPinned()
    {
        return $this->pinned;
    }

    /**
     * Set iscommunity
     *
     * @param boolean $iscommunity
     * @return board
     */
    public function setIscommunity($iscommunity)
    {
        $this->iscommunity = $iscommunity;
    
        return $this;
    }

    /**
     * Get iscommunity
     *
     * @return boolean 
     */
    public function getIscommunity()
    {
        return $this->iscommunity;
    }

        /**
     * Set container
     *
     * @param string $container
     * @return comment
     */
    public function setContainer($container)
    {
        $this->container = $container;
    
        return $this;
    }

    /**
     * Get container
     *
     * @return string 
     */
    public function getContainer()
    {
        return $this->container;
    }


    /**
     * Set track
     *
     * @param \soullified\lifesoundtrackBundle\Entity\track $track
     * @return board
     */
    public function setTrack(\soullified\lifesoundtrackBundle\Entity\track $track = null)
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


       /**
     * Set filter
     *
     * @param integer $filter
     * @return board
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    
        return $this;
    }

    /**
     * Get filter
     *
     * @return integer 
     */
    public function getFilter()
    {
        return $this->filter;
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
     * Set maxLetters
     *
     * @param integer $maxLetters
     * @return board
     */
    public function setMaxLetters($maxLetters)
    {
        $this->maxLetters = $maxLetters;
        return $this;
    }

    /**
     * Get maxLetters
     *
     * @return integer
     */
    public function getMaxLetters()
    {
        if($this->maxLetters)
            return $this->maxLetters;
        else
            return 55;
    }

}