<?php

namespace Fogs\InsightBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
	
/**
 * Inquiry
 */
class Inquiry implements \Fogs\InsightBundle\Entity\Interfaces\InquiryInterface
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
    private $traveller;


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Inquiry
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
     * @return Inquiry
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
     * Set location
     *
     * @param Point $location
     *
     * @return Inquiry
     */
    public function setLocation(Point $location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return Point 
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
     * Set traveller
     *
     * @param \Fogs\UserBundle\Entity\Interfaces\UserInterface $traveller
     *
     * @return Inquiry
     */
    public function setTraveller(\Fogs\UserBundle\Entity\Interfaces\UserInterface $traveller, $cascade=true)
    {
        if ($cascade) {
               $traveller->addInquiry($this, false);
        }
        $this->traveller = $traveller;

        return $this;
    }

    /**
     * Get traveller
     *
     * @return \Fogs\UserBundle\Entity\Interfaces\UserInterface 
     */
    public function getTraveller()
    {
        return $this->traveller;
    }
}
