<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\LinkCollection;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LinkCollection>
 */
class LinkCollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinkCollection::class);
    }

    public function findByIdAndUser(int $id, User $user): ?LinkCollection
    {
        $result = $this->createQueryBuilder('lc')
            ->andWhere('lc.id = :id')
            ->andWhere('lc.user = :user')
            ->setParameter('id', $id)
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();

        return $result instanceof LinkCollection ? $result : null;
    }
}
