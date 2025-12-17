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
     * @param array<string, int> $uriVariables
     */
    protected function getEntity(array $uriVariables, string $entityClass): object
    {
        if (isset($uriVariables['id'])) {
            /** @var class-string $entityClass */
            $entity = $this->entityManager->find($entityClass, $uriVariables['id']);

            if (!$entity) {
                throw new NotFoundHttpException('Record not found');
            }
        } else {
            $entity = new $entityClass();

            if ($entity instanceof HasUserInterface) {
                $user = $this->security->getUser();
                if (!$user || !$user instanceof User) {
                    throw new UserNotFoundException('User must be logged in to create this entity.');
                }

                $entity->setUser($user);
            }
        }

        return $entity;
    }
}
