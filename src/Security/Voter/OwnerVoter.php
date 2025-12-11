<?php

namespace App\Security\Voter;

use App\Interfaces\Entity\HasUserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class OwnerVoter extends Voter
{
    public const IS_OWNER = 'IS_OWNER';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::IS_OWNER && $subject instanceof HasUserInterface;
    }

    protected function voteOnAttribute(string $attribute, mixed $entity, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }


        return $entity->getUser() === $user;
    }
}