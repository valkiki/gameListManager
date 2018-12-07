<?php

declare(strict_types=1);

namespace App\Core\Component\Item\Repository;

use App\Core\Component\Item\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class ItemRepository
 * @package App\Core\Component\Item\Repository
 */
class ItemRepository extends ServiceEntityRepository
{
    /**
     * ItemRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }
}
