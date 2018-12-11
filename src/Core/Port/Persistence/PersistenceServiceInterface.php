<?php

declare(strict_types=1);

namespace App\Core\Port\Persistence;

/**
 * Interface PersistenceServiceInterface
 * @package App\Core\Port\Persistence
 */
interface PersistenceServiceInterface
{
    public function upsert($entity): void;

    public function delete($entity): void;
}
