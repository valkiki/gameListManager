<?php

declare(strict_types=1);

namespace App\Core\Listing\Service;

use App\Core\Listing\Entity\Listing;
use App\Infrastructure\Persistence\DoctrineEntityManager;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Class ListingService
 * @package App\Core\Listing\Service
 */
class ListingService
{
    /**
     * @var DoctrineEntityManager
     */
    private $doctrineEntityManager;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * ListingService constructor.
     * @param DoctrineEntityManager $doctrineEntityManager
     * @param FlashBagInterface $flashBag
     */
    public function __construct
    (
        DoctrineEntityManager $doctrineEntityManager,
        FlashBagInterface $flashBag
    )
    {
        $this->doctrineEntityManager = $doctrineEntityManager;
        $this->flashBag = $flashBag;
    }

    /**
     * @param Listing $listing
     */
    public function post(Listing $listing): void
    {
        try {
            $this->doctrineEntityManager->persist($listing);
            $this->flashBag->add('success', 'listing.post.success');
        } catch (\Exception $exception) {
            $this->flashBag->add('error', 'listing.post.failed');
        }
    }
}

