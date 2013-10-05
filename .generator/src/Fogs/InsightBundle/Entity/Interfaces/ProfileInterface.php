<?php

namespace Fogs\InsightBundle\Entity\Interfaces;

interface ProfileInterface
{
    public function setName($name);
    public function getName();
    public function setDateOfBirth($dateOfBirth);
    public function getDateOfBirth();
    public function setDescription($description);
    public function getDescription();
    public function getId();
    public function setOwner(\Fogs\UserBundle\Entity\Interfaces\UserInterface $owner, $cascade=true);
    public function getOwner();
}
