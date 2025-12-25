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
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @implements ProcessorInterface<mixed, void>
 */
abstract class AbstractProcessor implements ProcessorInterface
{
    protected ?UserInterface $user = null;

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected Security $security,
    ) {
    }

    /**
     * @param array<string, int> $uriVariables
     */
    abstract public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): object;

    protected function getUserEntity(): User
    {
        if (!$this->user instanceof UserInterface) {
            $this->user = $this->security->getUser();
        }

        if (!$this->user instanceof User) {
            throw new UserNotFoundException();
        }

        return $this->user;
    }

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
            $entity->setUser($this->getUserEntity());
        }

        return $entity;
    }
}
