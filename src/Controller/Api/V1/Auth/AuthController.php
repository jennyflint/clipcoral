<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Auth;

use App\DTO\User\UserSignupDto;
use App\Entity\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/auth')]
class AuthController extends AbstractController
{
    #[Route('/api/signup', methods: ['POST'])]
    public function signup(
        #[MapRequestPayload]
        UserSignupDto $userSignupDto,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
    ): JsonResponse {
        $user = new User();
        $user->setEmail($userSignupDto->email);

        $hashedPassword = $passwordHasher->hashPassword($user, $userSignupDto->password);
        $user->setPassword($hashedPassword);

        try {
            $entityManager->persist($user);
            $entityManager->flush();
        } catch (UniqueConstraintViolationException) {
            return $this->json([
                'message' => 'User with this email already exists',
            ], 409);
        }

        return $this->json([
            'message' => 'User successful registered',
            'email' => $user->getEmail(),
        ], 201);
    }
}
