<?php

declare(strict_types=1);

namespace App\Core\Component\Item\Repository;

use App\Core\Component\Item\Entity\Item;

interface ItemRepositoryInterface
{
    public function findAll(): array;

    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null) : array;

    public function find(int $id): Item;

    public function create(Item $item): void;

    public function delete(Item $item): void;
}
