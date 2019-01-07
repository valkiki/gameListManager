<?php

declare(strict_types=1);

namespace App\Core\Component\Listing\Repository;

use App\Core\Component\Listing\Entity\Listing;

interface ListingRepositoryInterface
{
    public function findAll(): array;

    public function find(int $id): Listing;

    public function create(Listing $listing): void;

    public function update(Listing $listing): void;

    public function delete(Listing $listing): void;
}
