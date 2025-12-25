<?php

declare(strict_types=1);

namespace App\State\Processor\Link;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DTO\ApiPlatform\Link\LinkDto;
use App\Entity\Link;
use App\Repository\LinkCollectionRepository;
use App\State\Processor\AbstractProcessor;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @implements ProcessorInterface<mixed, mixed>
 */
final class LinkProcessor extends AbstractProcessor implements ProcessorInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected Security $security,
        private readonly LinkCollectionRepository $linkCollectionRepository,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Link
    {
        if (!$data instanceof LinkDto) {
            throw new InvalidArgumentException('Data must be instance of LinkDto');
        }

        // todo remove duplicate select query if use voter
        $entity = $this->getEntity($uriVariables, Link::class);

        if ($data->url) {
            $entity->setUrl($data->url);
        }

        if ($data->description) {
            $entity->setDescription($data->description);
        }

        $linkCollection = null;

        if (isset($uriVariables['linkCollectionId'])) {
            $linkCollection = $this->linkCollectionRepository->findByIdAndUser($uriVariables['linkCollectionId'], $this->getUserEntity());

            if (!$linkCollection instanceof \App\Entity\LinkCollection) {
                throw new NotFoundHttpException('Link collection not found');
            }

        } elseif ($data->linkCollection instanceof \App\Entity\LinkCollection) {
            $linkCollection = $data->linkCollection;
        }

        if ($linkCollection instanceof \App\Entity\LinkCollection) {
            $entity->setLinkCollection($linkCollection);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}
