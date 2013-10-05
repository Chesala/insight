<?php

namespace Fogs\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * User
 */
class User extends BaseUser implements \Fogs\UserBundle\Entity\Interfaces\UserInterface , ParticipantInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \Fogs\InsightBundle\Entity\Interfaces\ProfileInterface
     */
    private $profile;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $offers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $inquirys;

    /**
     * Constructor
     */
    public function __construct()
    {
    	parent::__construct();
        $this->offers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->inquirys = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set profile
     *
     * @param \Fogs\InsightBundle\Entity\Interfaces\ProfileInterface $profile
     *
     * @return User
     */
    public function setProfile(\Fogs\InsightBundle\Entity\Interfaces\ProfileInterface $profile = null, $cascade=true)
    {
    	if ($cascade and !is_null($profile)) {
    		$profile->setOwner($this, false);
    	}
    	$this->profile = $profile;
    
    	return $this;
    }
    
    /**
     * Get profile
     *
     * @return \Fogs\InsightBundle\Entity\Interfaces\ProfileInterface
     */
    public function getProfile()
    {
    	return $this->profile;
    }
    
    /**
     * Add offers
     *
     * @param \Fogs\InsightBundle\Entity\Interfaces\OfferInterface $offers
     *
     * @return User
     */
    public function addOffer(\Fogs\InsightBundle\Entity\Interfaces\OfferInterface $offers, $cascade=true)
    {
    	if ($cascade) {
    		$offers->setHost($this, false);
    	}
    	$this->offers[] = $offers;
    
    	return $this;
    }
    
    /**
     * Remove offers
     *
     * @param \Fogs\InsightBundle\Entity\Interfaces\OfferInterface $offers
     */
    public function removeOffer(\Fogs\InsightBundle\Entity\Interfaces\OfferInterface $offers)
    {
    	$this->offers->removeElement($offers);
    }
    
    /**
     * Get offers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOffers()
    {
    	return $this->offers;
    }
    
    /**
     * Add inquirys
     *
     * @param \Fogs\InsightBundle\Entity\Interfaces\InquiryInterface $inquirys
     *
     * @return User
     */
    public function addInquiry(\Fogs\InsightBundle\Entity\Interfaces\InquiryInterface $inquirys, $cascade=true)
    {
    	if ($cascade) {
    		$inquirys->setTraveller($this, false);
    	}
    	$this->inquirys[] = $inquirys;
    
    	return $this;
    }
    
    /**
     * Remove inquirys
     *
     * @param \Fogs\InsightBundle\Entity\Interfaces\InquiryInterface $inquirys
     */
    public function removeInquiry(\Fogs\InsightBundle\Entity\Interfaces\InquiryInterface $inquirys)
    {
    	$this->inquirys->removeElement($inquirys);
    }
    
    /**
     * Get inquirys
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInquirys()
    {
    	return $this->inquirys;
    }
}
