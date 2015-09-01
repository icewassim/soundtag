<?php

namespace soullified\boardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * host
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\boardBundle\Entity\hostRepository")
 */
class host
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
     * @ORM\Column(name="fullname", type="string", length=255)
     */
    private $fullname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255,nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255)
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="ipadress", type="string", length=255,nullable=true)
     */
    private $ipadress;

    /**
    * @ORM\OneToMany(targetEntity="soullified\boardBundle\Entity\comment",mappedBy="host",cascade={"persist","remove"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $comments;

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
     * Set fullname
     *
     * @param string $fullname
     * @return host
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
     * Set email
     *
     * @param string $email
     * @return host
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * Set avatar
     *
     * @param string $avatar
     * @return host
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    
        return $this;
    }

    /**
     * Get avatarail
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }


    /**
     * Set ipadress
     *
     * @param string $ipadress
     * @return host
     */
    public function setIpadress($ipadress)
    {
        $this->ipadress = $ipadress;
    
        return $this;
    }

    /**
     * Get ipadress
     *
     * @return string 
     */
    public function getIpadress()
    {
        return $this->ipadress;
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

}
