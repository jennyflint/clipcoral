<?php

declare(strict_types=1);

namespace App\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\Interfaces\Entity\HasUserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

/**
 * @implements ProcessorInterface<mixed, void>
 */
abstract class AbstractProcessor implements ProcessorInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected Security $security,
    ) {
    }

    /**
     * @param array<string, int> $uriVariables
     */
    abstract public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): object;

    /**
     * @template T of object
     *
     * @param array<string, mixed> $uriVariables
     * @param class-string<T>      $entityClass
     *
     * @return T
     */
    protected function getEntity(array $uriVariables, string $entityClass): object
    {
        $id = $uriVariables['id'] ?? null;
        $entity = $id ? $this->entityManager->find($entityClass, $id) : new $entityClass();

        if (!$entity) {
            throw new NotFoundHttpException();
        }

        if (!$id && $entity instanceof HasUserInterface) {
            $user = $this->security->getUser();
            $user instanceof User ? $entity->setUser($user) : throw new UserNotFoundException();
        }

        return $entity;
    }
}
