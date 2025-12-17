<?php

declare(strict_types=1);

namespace App\Interfaces\Entity;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

interface HasUserInterface
{
    public function getUser(): ?UserInterface;

    public function setUser(User $user): static;
}
