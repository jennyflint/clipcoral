<?php
namespace App\Controller\Api\V1\Auth;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/auth')]
class AuthController extends AbstractController
{
    #[Route('/signup', name: 'signup', methods: ['POST'])]
    public function signup(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $email = $data['username'] ?? $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return $this->json([
                'message' => 'Email and Password field is required'
            ], 400);
        }

        $user = new User();
        $user->setEmail($email);

        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        try {
            $entityManager->persist($user);
            $entityManager->flush();
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'User with this email already exist'
            ], 409);
        }

        return $this->json([
            'message' => 'User succesful registered',
            'email' => $user->getEmail()
        ], 201);
    }
}