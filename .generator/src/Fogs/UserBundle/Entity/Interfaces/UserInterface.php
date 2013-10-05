<?php

namespace Fogs\UserBundle\Entity\Interfaces;

interface UserInterface
{
    public function __construct();
    public function getId();
    public function setProfile(\Fogs\InsightBundle\Entity\Interfaces\ProfileInterface $profile = null, $cascade=true);
    public function getProfile();
    public function addOffer(\Fogs\InsightBundle\Entity\Interfaces\OfferInterface $offers, $cascade=true);
    public function removeOffer(\Fogs\InsightBundle\Entity\Interfaces\OfferInterface $offers);
    public function getOffers();
    public function addInquiry(\Fogs\InsightBundle\Entity\Interfaces\InquiryInterface $inquirys, $cascade=true);
    public function removeInquiry(\Fogs\InsightBundle\Entity\Interfaces\InquiryInterface $inquirys);
    public function getInquirys();
}
