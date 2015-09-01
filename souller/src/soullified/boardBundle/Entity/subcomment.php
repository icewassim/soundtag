<?php

namespace soullified\boardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * subcomment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="soullified\boardBundle\Entity\subcommentRepository")
 */
class subcomment
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
     * @ORM\Column(name="date", type="string", length=255)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

  /**
    * @ORM\ManyToOne(targetEntity="soullified\boardBundle\Entity\comment",inversedBy="subcomments",cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */

    private $comment;

  /**
    * @ORM\ManyToOne(targetEntity="soullified\profilBundle\Entity\profil",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $owner;


  /**
    * @ORM\ManyToOne(targetEntity="soullified\boardBundle\Entity\host",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */

    private $host;


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
     * Set date
     *
     * @param string $date
     * @return subcomment
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
     * Set content
     *
     * @param string $content
     * @return subcomment
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
     * Set comment
     *
     * @param \soullified\boardBundle\Entity\comment $comment
     * @return subcomment
     */
    public function setComment(\soullified\boardBundle\Entity\comment $comment)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return \soullified\boardBundle\Entity\comment 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set owner
     *
     * @param \soullified\profilBundle\Entity\profil $owner
     * @return subcomment
     */
    public function setOwner(\soullified\profilBundle\Entity\profil $owner = null)
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


}