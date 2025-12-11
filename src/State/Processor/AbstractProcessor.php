<?php
namespace App\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

abstract class AbstractProcessor implements ProcessorInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected Security $security
    ) {
    }
    abstract public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): object;

    protected function getEntityByHttpMethod(string $httpMethod, array $uriVariables, string $entityClass)
    {
        if ($httpMethod === Request::METHOD_PATCH) {
            if (isset($uriVariables['id']) && is_int($uriVariables['id'])) {
                $entity = $this->entityManager->find($entityClass, $uriVariables['id']);
            } else {
                throw new BadRequestHttpException('Missing or incorrect record id in url');
            }

        } elseif ($httpMethod === Request::METHOD_POST) {
            $entity = new $entityClass();

            if ($user = $this->security->getUser()) {
                $entity->setUser($user);
            }
        } else {
            throw new MethodNotAllowedHttpException(['POST', 'PATCH']);
        }

        return $entity;
    }
}