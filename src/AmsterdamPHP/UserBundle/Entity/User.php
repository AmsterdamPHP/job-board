<?php
namespace AmsterdamPHP\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Simple user class
 *
 */
class User extends BaseUser
{

    /**
     * Name of the user
     *
     * @var string
     */
    private $name;

    /**
     * linkedin url
     *
     * @var string
     */
    private $linkedin;

    /**
     * facebook url
     *
     * @var string
     */
    private $facebook;

    /**
     * twitter has
     *
     * @var string
     */
    private $twitter;

    /**
     * phone number
     *
     * @var string
     */
    private $phone;

    /**
     * Company name
     *
     * @var string
     */
    private $company;

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
     * Gets the linkedin url.
     *
     * @return string
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * Sets the linkedin url.
     *
     * @param string $linkedin the linkedin
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;
    }

    /**
     * Gets the facebook url.
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Sets the facebook url.
     *
     * @param string $facebook the facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * Gets the twitter has.
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Sets the twitter has.
     *
     * @param string $twitter the twitter
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * Gets the phone number.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets the phone number.
     *
     * @param string $phone the phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Gets the Company name.
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Sets the Company name.
     *
     * @param string $company the company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }
}