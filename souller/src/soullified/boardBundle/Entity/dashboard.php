<?php

namespace soullified\boardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * dashboard
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\boardBundle\Entity\dashboardRepository")
 */
class dashboard
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
     * @var boolean
     *
     * @ORM\Column(name="about", type="boolean",nullable=true)
     */
    private $about;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="avatar", type="boolean",nullable=true)
     */
    private $avatar;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="lifesoundtrack", type="boolean",nullable=true)
     */
    private $lifesoundtrack;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="todolist", type="boolean",nullable=true)
     */
    private $todolist;

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
     * Set about
     *
     * @param boolean $about
     * @return dashboard
     */
    public function setAbout($about)
    {
        $this->about = $about;
    
        return $this;
    }

    /**
     * Get about
     *
     * @return boolean 
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set avatar
     *
     * @param boolean $avatar
     * @return dashboard
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    
        return $this;
    }

    /**
     * Get avatar
     *
     * @return boolean 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set lifesoundtrack
     *
     * @param boolean $lifesoundtrack
     * @return dashboard
     */
    public function setLifesoundtrack($lifesoundtrack)
    {
        $this->lifesoundtrack = $lifesoundtrack;
    
        return $this;
    }

    /**
     * Get lifesoundtrack
     *
     * @return boolean 
     */
    public function getLifesoundtrack()
    {
        return $this->lifesoundtrack;
    }

    /**
     * Set todolist
     *
     * @param boolean $todolist
     * @return dashboard
     */
    public function setTodolist($todolist)
    {
        $this->todolist = $todolist;
    
        return $this;
    }

    /**
     * Get todolist
     *
     * @return boolean 
     */
    public function getTodolist()
    {
        return $this->todolist;
    }
}