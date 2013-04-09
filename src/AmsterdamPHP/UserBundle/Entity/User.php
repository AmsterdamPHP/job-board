<?php
namespace AmsterdamPHP\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * Name of the user
     *
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $companyUrl;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $companyBio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $companyLogo;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $recruiter;

    /**
     * constructs the class
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Gets the Name of the user.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the Name of the user.
     *
     * @param string $name the name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return string
     */
    public function getCompanyUrl()
    {
        return $this->companyUrl;
    }

    /**
     * @param string $companyUrl
     */
    public function setCompanyUrl($companyUrl)
    {
        $this->companyUrl = $companyUrl;
    }

    /**
     * @return string
     */
    public function getCompanyBio()
    {
        return $this->companyBio;
    }

    /**
     * @param string $companyBio
     */
    public function setCompanyBio($companyBio)
    {
        $this->companyBio = $companyBio;
    }

    /**
     * @return string
     */
    public function getCompanyLogo()
    {
        return $this->companyLogo;
    }

    /**
     * @param string $companyLogo
     */
    public function setCompanyLogo($companyLogo)
    {
        $this->companyLogo = $companyLogo;
    }

    /**
     * @return boolean
     */
    public function isRecruiter()
    {
        return $this->recruiter;
    }

    /**
     * @param boolean $recruiter
     */
    public function setRecruiter($recruiter)
    {
        $this->recruiter = $recruiter;
    }
}