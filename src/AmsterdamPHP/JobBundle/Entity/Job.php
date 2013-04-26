<?php

namespace AmsterdamPHP\JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AmsterdamPHP\UserBundle\Entity\User;

/**
 * @ORM\Table(name="jobs")
 * @ORM\Entity(repositoryClass="AmsterdamPHP\JobBundle\Entity\JobRepository")
 */
class Job
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $languageOfAd;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $contractType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $salary;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $url;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $expires;

    /**
     * User owning this object
     *
     * @ORM\ManyToOne(targetEntity="AmsterdamPHP\UserBundle\Entity\User")
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $blocked = false;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $archived = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $notes;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $calculatedRating = 0;

    /**
     * @ORM\OneToMany(targetEntity="JobRating", mappedBy="job")
     * @var JobRating[]
     */
    private $ratings;

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
     *
     * @return Job
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
     *
     * @return Job
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
     * Sets the value of id.
     *
     * @param integer $id the id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Gets the value of created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Sets the value of created.
     *
     * @param \DateTime $created the created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * Gets the value of expires.
     *
     * @return \DateTime
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * Sets the value of expires.
     *
     * @param \DateTime $expires the expires
     */
    public function setExpires(\DateTime $expires)
    {
        $this->expires = $expires;
    }

    /**
     * Gets the User owning this object.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the User owning this object.
     *
     * @param User $user the user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * Gets the value of location.
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Sets the value of location.
     *
     * @param string $location the location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getLanguageOfAd()
    {
        return $this->languageOfAd;
    }

    /**
     * @param string $languageOfAd
     */
    public function setLanguageOfAd($languageOfAd)
    {
        $this->languageOfAd = $languageOfAd;
    }

    /**
     * @return string
     */
    public function getContractType()
    {
        return $this->contractType;
    }

    /**
     * @param string $contractType
     */
    public function setContractType($contractType)
    {
        $this->contractType = $contractType;
    }

    /**
     * @return string
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param string $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return boolean
     */
    public function getBlocked()
    {
        return $this->blocked;
    }

    /**
     * @param boolean $blocked
     */
    public function setBlocked($blocked)
    {
        $this->blocked = $blocked;
    }

    /**
     * @return boolean
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * @param boolean $archived
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return int
     */
    public function getCalculatedRating()
    {
        return $this->calculatedRating;
    }

    /**
     * @param int $calculatedRating
     */
    public function setCalculatedRating($calculatedRating)
    {
        $this->calculatedRating = $calculatedRating;
    }

    public function getRatings()
    {
        return $this->ratings;
    }

    public function setRatings($ratings)
    {
        $this->ratings = $ratings;
    }
}
