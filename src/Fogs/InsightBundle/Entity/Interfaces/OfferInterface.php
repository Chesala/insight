<?php

namespace Fogs\InsightBundle\Entity\Interfaces;

interface OfferInterface
{
    public function setTitle($title);
    public function getTitle();
    public function setDescription($description);
    public function getDescription();
    public function setValidFrom($validFrom);
    public function getValidFrom();
    public function setValidUntil($validUntil);
    public function getValidUntil();
    public function setLocation(\Point $location);
    public function getLocation();
    public function getId();
    public function setHost(\Fogs\UserBundle\Entity\Interfaces\UserInterface $host, $cascade=true);
    public function getHost();
}
