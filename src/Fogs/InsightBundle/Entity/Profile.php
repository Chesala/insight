<?php

namespace Fogs\InsightBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fogs\TaggingBundle\Interfaces\Taggable;
use Fogs\TaggingBundle\Traits\TaggableTrait;

/**
 * Profile
 */
class Profile implements \Fogs\InsightBundle\Entity\Interfaces\ProfileInterface, Taggable
{
	use TaggableTrait;
	
    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $dateOfBirth;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Fogs\UserBundle\Entity\Interfaces\UserInterface
     */
    private $owner;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Profile
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return Profile
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime 
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Profile
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set owner
     *
     * @param \Fogs\UserBundle\Entity\Interfaces\UserInterface $owner
     *
     * @return Profile
     */
    public function setOwner(\Fogs\UserBundle\Entity\Interfaces\UserInterface $owner, $cascade=true)
    {
        if ($cascade and !is_null($owner)) {
            $owner->setProfile($this, false);
        }
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Fogs\UserBundle\Entity\Interfaces\UserInterface 
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
