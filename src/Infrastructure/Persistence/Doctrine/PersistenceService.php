<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Core\Port\Persistence\PersistenceServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PersistenceService
 * @package App\Core\Infrastructure\Persistence
 */
class PersistenceService implements PersistenceServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * DoctrineEntityManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $entity
     * @param bool $flush
     */
    public function upsert(
        $entity,
        bool $flush = true
    ): void {
        $this->getEntityManager()->persist($entity);

        if ($flush === true) {
            $this->flush();
        }
    }

    /**
     * @param $entity
     * @param bool $flush
     */
    public function delete(
        $entity,
        bool $flush = true
    ): void {
        $this->getEntityManager()->remove($entity);

        if ($flush === true) {
            $this->flush();
        }
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}
