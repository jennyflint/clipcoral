<?php

namespace App\State\Processor\LinkCollection;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DTO\ApiPlatform\LinkCollection\LinkCollectionDto;
use App\Entity\LinkCollection;
use App\State\Processor\AbstractProcessor;

final class LinkCollectionProcessor extends AbstractProcessor implements ProcessorInterface
{
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): LinkCollection
    {
        if (!$data instanceof LinkCollectionDto) {
            throw new \InvalidArgumentException('Data must be instance of LinkCollectionDto');
        }

        // todo remove duplicate select query if use voter
        $entity = $this->getEntityByHttpMethod($operation->getMethod(), $uriVariables, LinkCollection::class);

        if ($data?->name) {
            $entity->setName($data->name);
        }

        if ($data?->description) {
            $entity->setDescription($data->description);
        }

        if ($data?->colorBadge) {
            $entity->setColorBadge($data->colorBadge);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}