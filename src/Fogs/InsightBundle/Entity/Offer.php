<?php

namespace Fogs\InsightBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CrEOF\Spatial\PHP\Types\Geometry\Point;

/**
 * Offer
 */
class Offer implements \Fogs\InsightBundle\Entity\Interfaces\OfferInterface
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $validFrom;

    /**
     * @var \DateTime
     */
    private $validUntil;

    /**
     * @var Point
     */
    private $location;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Fogs\UserBundle\Entity\Interfaces\UserInterface
     */
    private $host;


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Offer
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
     * @return Offer
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
     * Set validFrom
     *
     * @param \DateTime $validFrom
     *
     * @return Offer
     */
    public function setValidFrom($validFrom)
    {
        $this->validFrom = $validFrom;

        return $this;
    }

    /**
     * Get validFrom
     *
     * @return \DateTime 
     */
    public function getValidFrom()
    {
        return $this->validFrom;
    }

    /**
     * Set validUntil
     *
     * @param \DateTime $validUntil
     *
     * @return Offer
     */
    public function setValidUntil($validUntil)
    {
        $this->validUntil = $validUntil;

        return $this;
    }

    /**
     * Get validUntil
     *
     * @return \DateTime 
     */
    public function getValidUntil()
    {
        return $this->validUntil;
    }

    /**
     * Set location
     *
     * @param Point $location
     *
     * @return Offer
     */
    public function setLocation(Point $location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \Point 
     */
    public function getLocation()
    {
        return $this->location;
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
     * Set host
     *
     * @param \Fogs\UserBundle\Entity\Interfaces\UserInterface $host
     *
     * @return Offer
     */
    public function setHost(\Fogs\UserBundle\Entity\Interfaces\UserInterface $host, $cascade=true)
    {
        if ($cascade) {
               $host->addOffer($this, false);
        }
        $this->host = $host;

        return $this;
    }

    /**
     * Get host
     *
     * @return \Fogs\UserBundle\Entity\Interfaces\UserInterface 
     */
    public function getHost()
    {
        return $this->host;
    }
}
