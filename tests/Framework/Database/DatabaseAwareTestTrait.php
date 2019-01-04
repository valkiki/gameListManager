<?php

declare(strict_types=1);

namespace App\tests\Framework\Database;

use Doctrine\ORM\EntityManagerInterface;

trait DatabaseAwareTestTrait
{
    /**
     * @return mixed
     */
    abstract protected function getService(string $service);

    protected function clearDatabaseCache(): void
    {
        $this->getEntityManager()->clear();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->getService(EntityManagerInterface::class);
    }
}
