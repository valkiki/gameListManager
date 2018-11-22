<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DoctrineEntityManager
 * @package App\Core\Infrastructure\Persistence
 */
class DoctrineEntityManager
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
    public function persist($entity, $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function flush() : void
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
