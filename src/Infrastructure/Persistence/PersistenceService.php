<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PersistenceService
 * @package App\Core\Infrastructure\Persistence
 */
class PersistenceService
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
    public function upsert($entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @param $entity
     */
    public function delete($entity) : void
    {
        $this->getEntityManager()->remove($entity);
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