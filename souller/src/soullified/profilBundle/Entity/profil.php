<?php

namespace soullified\profilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * profil
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\profilBundle\Entity\profilRepository")
 */
class profil
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
     * @ORM\Column(name="fullname", type="string", length=255,nullable=true)
     */
    private $fullname;

      /**
    * @ORM\OneToOne(targetEntity="soullified\boardBundle\Entity\board",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $profilboard;


      /**
    * @ORM\OneToOne(targetEntity="soullified\boardBundle\Entity\dashboard",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $dashboard;


   /**
    * @ORM\OneToOne(targetEntity="soullified\UserBundle\Entity\User",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $user;

  /**
    * @ORM\OneToMany(targetEntity="soullified\boardBundle\Entity\board",mappedBy="profil",cascade={"persist","remove"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $boards;

  /**
    * @ORM\OneToMany(targetEntity="soullified\lifesoundtrackBundle\Entity\track",mappedBy="profil",cascade={"persist","remove"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $tracks;


      /**
    * @ORM\OneToMany(targetEntity="soullified\profilBundle\Entity\friendrequest",mappedBy="receiver",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $friendrequests;


      /**
    * @ORM\OneToMany(targetEntity="soullified\profilBundle\Entity\event",mappedBy="receiver",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $events;


      /**
    * @ORM\OneToMany(targetEntity="soullified\profilBundle\Entity\message",mappedBy="receiver",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $messages;


  /**
    * @ORM\ManyToMany(targetEntity="soullified\boardBundle\Entity\board", inversedBy="likers")
    */
    protected $boardsliked;


      /**
    * @ORM\OneToMany(targetEntity="soullified\profilBundle\Entity\friendship",mappedBy="firstfriend",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $friendship;

   /**
     * @var string
     *
     * @ORM\Column(name="about", type="string", length=255,nullable=true)
     */
    private $about;

   /**
     * @var string
     *
     * @ORM\Column(name="favfont", type="string", length=255,nullable=true)
     */
    private $favfont;

       /**
     * @var string
     *
     * @ORM\Column(name="favcolor", type="string", length=255,nullable=true)
     */
    private $favcolor;

    /**
     * @var integer
     *
     * @ORM\Column(name="unseenmessages", type="integer",nullable=true)
     */
    private $unseenmessages;


    /**
     * @var integer
     *
     * @ORM\Column(name="unseenevents", type="integer",nullable=true)
     */
    private $unseenevents;


   /**
     * @var boolean
     *
     * @ORM\Column(name="abouttrigger", type="boolean",nullable=true)
     */
    private $abouttrigger;



   /**
     * @var boolean
     *
     * @ORM\Column(name="profilphototrigger", type="boolean",nullable=true)
     */
    private $profilphototrigger;


   /**
     * @var boolean
     *
     * @ORM\Column(name="menuboardcompressed", type="boolean",nullable=true)
     */
    private $menuboardcompressed;

    /**
     * @var string
     *
     * @ORM\Column(name="trackbackground", type="string", length=255,nullable=true)
     */
    private $trackbackground;

    /**
     * @var string
     *
     * @ORM\Column(name="wallbackground", type="string", length=255,nullable=true)
     */
    private $wallbackground;

      /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255,nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="feedback", type="string", length=255,nullable=true)
     */
    private $feedback;

    /**
     * @var string
     *
     * @ORM\Column(name="photoconnect", type="string", length=255,nullable=true)
     */
    private $photoconnect;



   /**
    * @ORM\OneToOne(targetEntity="soullified\boardBundle\Entity\photo",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $photourl;

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
     * Set trackbackground
     *
     * @param string $trackbackground
     * @return profil
     */
    public function setTrackbackground($trackbackground)
    {
        $this->trackbackground = $trackbackground;
    
        return $this;
    }

    /**
     * Get wallbackground
     *
     * @return string 
     */
    public function getWallbackground()
    {
        return $this->wallbackground;
    }

    /**
     * Set wallbackground
     *
     * @param string $wallbackground
     * @return profil
     */
    public function setWallbackground($wallbackground)
    {
        $this->wallbackground = $wallbackground;
    
        return $this;
    }

    /**
     * Get trackbackground
     *
     * @return string 
     */
    public function getTrackbackground()
    {
        return $this->trackbackground;
    }



    /**
     * Set feedback
     *
     * @param string $feedback
     * @return profil
     */
    public function setFeedback($feedback)
    {
        $this->feedback = $feedback;
    
        return $this;
    }

    /**
     * Get feedback
     *
     * @return string 
     */
    public function getFeedback()
    {
        return $this->feedback;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
  
    }
    



    /**
     * Set fullname
     *
     * @param string $fullname
     * @return profil
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    
        return $this;
    }

    /**
     * Get fullname
     *
     * @return string 
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set about
     *
     * @param string $about
     * @return profil
     */
    public function setAbout($about)
    {
        $this->about = $about;
    
        return $this;
    }

    /**
     * Get about
     *
     * @return string 
     */
    public function getAbout()
    {
        return $this->about;
    }


    /**
     * Set favfont
     *
     * @param string $favfont
     * @return profil
     */
    public function setFavfont($favfont)
    {
        $this->favfont = $favfont;
    
        return $this;
    }

    /**
     * Get favfont
     *
     * @return string 
     */
    public function getFavfont()
    {
        return $this->favfont;
    }

     /**
     * Set favcolor
     *
     * @param string $favcolor
     * @return profil
     */
    public function setFavColor($favcolor)
    {
        $this->favcolor = $favcolor;
    
        return $this;
    }

    /**
     * Get favcolor
     *
     * @return string 
     */
    public function getFavColor()
    {
        return $this->favcolor;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return profil
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Add board
     *
     * @param \soullified\boardBundle\Entity\board $board
     * @return profil
     */
    public function addBoard(\soullified\boardBundle\Entity\board $board)
    {
        $this->boards[] = $board;
    
        return $this;
    }

    /**
     * Remove board
     *
     * @param \soullified\boardBundle\Entity\board $board
     */
    public function removeBoard(\soullified\boardBundle\Entity\board $board)
    {
        $this->boards->removeElement($board);
    }

    /**
     * Get boards
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBoards()
    {
        return $this->boards;
    }  

    /**
     * Add friendrequests
     *
     * @param \soullified\profilBundle\Entity\friendrequest $friendrequests
     * @return profil
     */
    public function addFriendrequest(\soullified\profilBundle\Entity\friendrequest $friendrequests)
    {
        $this->friendrequests[] = $friendrequests;
    
        return $this;
    }

    /**
     * Remove friendrequests
     *
     * @param \soullified\profilBundle\Entity\friendrequest $friendrequests
     */
    public function removeFriendrequest(\soullified\profilBundle\Entity\friendrequest $friendrequests)
    {
        $this->friendrequests->removeElement($friendrequests);
    }

    /**
     * Get friendrequests
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFriendrequests()
    {
        return $this->friendrequests;
    }

    /**
     * Add friendship
     *
     * @param \soullified\profilBundle\Entity\friendship $friendship
     * @return profil
     */
    public function addFriendship(\soullified\profilBundle\Entity\friendship $friendship)
    {
        $this->friendship[] = $friendship;
    
        return $this;
    }

    /**
     * Remove friendship
     *
     * @param \soullified\profilBundle\Entity\friendship $friendship
     */
    public function removeFriendship(\soullified\profilBundle\Entity\friendship $friendship)
    {
        $this->friendship->removeElement($friendship);
    }

    /**
     * Get friendship
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFriendship()
    {
        return $this->friendship;
    }

    /**
     * Add messages
     *
     * @param \soullified\profilBundle\Entity\message $messages
     * @return profil
     */
    public function addMessage(\soullified\profilBundle\Entity\message $messages)
    {
        $this->messages[] = $messages;
    
        return $this;
    }

    /**
     * Remove messages
     *
     * @param \soullified\profilBundle\Entity\message $messages
     */
    public function removeMessage(\soullified\profilBundle\Entity\message $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set profilboard
     *
     * @param \soullified\boardBundle\Entity\board $profilboard
     * @return profil
     */
    public function setProfilboard(\soullified\boardBundle\Entity\board $profilboard = null)
    {
        $this->profilboard = $profilboard;
    
        return $this;
    }

    /**
     * Get profilboard
     *
     * @return \soullified\boardBundle\Entity\board 
     */
    public function getProfilboard()
    {
        return $this->profilboard;
    }

    /**
     * Set menuboardcompressed
     *
     * @param boolean $menuboardcompressed
     * @return profil
     */
    public function setMenuboardcompressed($menuboardcompressed)
    {
        $this->menuboardcompressed = $menuboardcompressed;
    
        return $this;
    }

    /**
     * Get menuboardcompressed
     *
     * @return boolean 
     */
    public function getMenuboardcompressed()
    {
        return $this->menuboardcompressed;
    }

    /**
     * Set unseenmessages
     *
     * @param integer $unseenmessages
     * @return profil
     */
    public function setUnseenmessages($unseenmessages)
    {
        $this->unseenmessages = $unseenmessages;
    
        return $this;
    }

    /**
     * Get unseenmessages
     *
     * @return integer 
     */
    public function getUnseenmessages()
    {
        return $this->unseenmessages;
    }

    /**
     * Set unseenevents
     *
     * @param integer $unseenevents
     * @return profil
     */
    public function setUnseenevents($unseenevents)
    {
        $this->unseenevents = $unseenevents;
    
        return $this;
    }

    /**
     * Get unseenevents
     *
     * @return integer 
     */
    public function getUnseenevents()
    {
        return $this->unseenevents;
    }

    /**
     * Add events
     *
     * @param \soullified\profilBundle\Entity\event $events
     * @return profil
     */
    public function addEvent(\soullified\profilBundle\Entity\event $events)
    {
        $this->events[] = $events;
    
        return $this;
    }

    /**
     * Remove events
     *
     * @param \soullified\profilBundle\Entity\event $events
     */
    public function removeEvent(\soullified\profilBundle\Entity\event $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add boardsliked
     *
     * @param \soullified\boardBundle\Entity\board $boardsliked
     * @return profil
     */
    public function addBoardsliked(\soullified\boardBundle\Entity\board $boardsliked)
    {
        $this->boardsliked[] = $boardsliked;
    
        return $this;
    }

    /**
     * Remove boardsliked
     *
     * @param \soullified\boardBundle\Entity\board $boardsliked
     */
    public function removeBoardsliked(\soullified\boardBundle\Entity\board $boardsliked)
    {
        $this->boardsliked->removeElement($boardsliked);
    }

    /**
     * Get boardsliked
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBoardsliked()
    {
        return $this->boardsliked;
    }

    /**
     * Set photourl
     *
     * @param \soullified\boardBundle\Entity\photo $photourl
     * @return profil
     */
    public function setPhotourl(\soullified\boardBundle\Entity\photo $photourl = null)
    {
        $this->photourl = $photourl;
    
        return $this;
    }

    /**
     * Get photourl
     *
     * @return \soullified\boardBundle\Entity\photo 
     */
    public function getPhotourl()
    {
        return $this->photourl;
    }

    /**
     * Set abouttrigger
     *
     * @param boolean $abouttrigger
     * @return profil
     */
    public function setAbouttrigger($abouttrigger)
    {
        $this->abouttrigger = $abouttrigger;
    
        return $this;
    }

    /**
     * Get abouttrigger
     *
     * @return boolean 
     */
    public function getAbouttrigger()
    {
        return $this->abouttrigger;
    }

    /**
     * Set profilphototrigger
     *
     * @param boolean $profilphototrigger
     * @return profil
     */
    public function setProfilphototrigger($profilphototrigger)
    {
        $this->profilphototrigger = $profilphototrigger;
    
        return $this;
    }

    /**
     * Get profilphototrigger
     *
     * @return boolean 
     */
    public function getProfilphototrigger()
    {
        return $this->profilphototrigger;
    }



    /**
     * Set photoconnect
     *
     * @param string $photoconnect
     * @return profil
     */
    public function setPhotoconnect($photoconnect)
    {
        $this->photoconnect = $photoconnect;
    
        return $this;
    }

    /**
     * Get photoconnect
     *
     * @return string 
     */
    public function getPhotoconnect()
    {
        return $this->photoconnect;
    }

    
    /**
     * Set user
     *
     * @param \soullified\UserBundle\Entity\User $user
     * @return profil
     */
    public function setUser(\soullified\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \soullified\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set dashboard
     *
     * @param \soullified\boardBundle\Entity\dashboard $dashboard
     * @return profil
     */
    public function setDashboard(\soullified\boardBundle\Entity\dashboard $dashboard = null)
    {
        $this->dashboard = $dashboard;
    
        return $this;
    }

    /**
     * Get dashboard
     *
     * @return \soullified\boardBundle\Entity\dashboard 
     */
    public function getDashboard()
    {
        return $this->dashboard;
    }

    /**
     * Add tracks
     *
     * @param \soullified\lifesoundtrackBundle\Entity\track $tracks
     * @return profil
     */
    public function addTrack(\soullified\lifesoundtrackBundle\Entity\track $tracks)
    {
        $this->tracks[] = $tracks;
    
        return $this;
    }

    /**
     * Remove tracks
     *
     * @param \soullified\lifesoundtrackBundle\Entity\track $tracks
     */
    public function removeTrack(\soullified\lifesoundtrackBundle\Entity\track $tracks)
    {
        $this->tracks->removeElement($tracks);
    }

    /**
     * Get tracks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTracks()
    {
        return $this->tracks;
    }


    public function getProfilPicture()
    {
        if ($this->getPhotoconnect()) 
                return $this->getPhotoconnect();
        else
        {
            if ($this->getPhotourl())
            {
                if($this->getPhotourl()->getFolder() == "avatar")
                    return $this->getPhotourl()->getUrl();
                else
                    return "/web/uploads/tmp/attachments/".$this->getPhotourl()->getFolder()."/thumbnails/".$this->getPhotourl()->getUrl();
            }else 
                return "/pictures/icons/thumbuser.png";
        }

    }

    public function getProfilPictureBig()
    {
       if ($this->getPhotoconnect()) 
                return $this->getPhotoconnect();
        else
        {
            if ($this->getPhotourl())
            {
                if($this->getPhotourl()->getFolder() == "avatar")
                    return $this->getPhotourl()->getUrl();
                else
                    return "/web/uploads/tmp/attachments/".$this->getPhotourl()->getFolder()."/medium/".$this->getPhotourl()->getUrl();
            }else 
                return "/pictures/icons/thumbuser.png";
        }

    }
}