<?php

declare(strict_types=1);

namespace App\State\Processor\LinkCollection;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DTO\ApiPlatform\LinkCollection\LinkCollectionDto;
use App\Entity\LinkCollection;
use App\State\Processor\AbstractProcessor;
use InvalidArgumentException;

/**
 * @implements ProcessorInterface<mixed, mixed>
 */
final class LinkCollectionProcessor extends AbstractProcessor implements ProcessorInterface
{
    /**
     * @param array<string, int> $uriVariables
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): LinkCollection
    {
        if (!$data instanceof LinkCollectionDto) {
            throw new InvalidArgumentException('Data must be instance of LinkCollectionDto');
        }

        // todo remove duplicate select query if use voter
        $entity = $this->getEntity($uriVariables, LinkCollection::class);

        if ($data->name) {
            $entity->setName($data->name);
        }

        if ($data->description) {
            $entity->setDescription($data->description);
        }

        if ($data->colorBadge) {
            $entity->setColorBadge($data->colorBadge);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}
