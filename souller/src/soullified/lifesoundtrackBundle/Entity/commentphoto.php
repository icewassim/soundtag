<?php

namespace soullified\lifesoundtrackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * commentphoto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\lifesoundtrackBundle\Entity\commentphotoRepository")
 */
class commentphoto
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
     * @ORM\Column(name="editid", type="string", length=255)
     */
    private $editid;

 /**
    * @ORM\ManyToOne(targetEntity="soullified\lifesoundtrackBundle\Entity\track",inversedBy="photos",cascade={"persist","remove"})
    * @ORM\JoinColumn(nullable=true)
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
     * Set url
     *
     * @param string $url
     * @return commentphoto
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
     * Set track
     *
     * @param \soullified\lifesoundtrackBundle\Entity\track $track
     * @return commentphoto
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

    /**
     * Set editid
     *
     * @param string $editid
     * @return commentphoto
     */
    public function setEditid($editid)
    {
        $this->editid = $editid;
    
        return $this;
    }

    /**
     * Get editid
     *
     * @return string 
     */
    public function getEditid()
    {
        return $this->editid;
    }
}