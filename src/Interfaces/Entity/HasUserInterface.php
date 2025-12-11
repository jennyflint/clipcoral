<?php

namespace App\Interfaces\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

interface HasUserInterface
{
    public function getUser(): ?UserInterface;
}