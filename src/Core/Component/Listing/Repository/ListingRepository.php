<?php

declare(strict_types=1);

namespace App\Core\Component\Listing\Repository;

use App\Core\Component\Listing\Entity\Listing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class ListingRepository
 * @package App\Core\Component\Listing\Repository
 */
class ListingRepository extends ServiceEntityRepository
{
    /**
     * ListingRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Listing::class);
    }
}
