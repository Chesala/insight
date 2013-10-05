<?php

namespace Fogs\InsightBundle\Entity\Interfaces;

interface InquiryInterface
{
    public function setTitle($title);
    public function getTitle();
    public function setDescription($description);
    public function getDescription();
    public function setLocation(\Point $location);
    public function getLocation();
    public function getId();
    public function setTraveller(\Fogs\UserBundle\Entity\Interfaces\UserInterface $traveller, $cascade=true);
    public function getTraveller();
}
