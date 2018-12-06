<?php

declare(strict_types=1);

namespace App\Core\Listing\Service;

use App\Core\Listing\Entity\Listing;
use App\Infrastructure\Persistence\PersistenceService;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Class ListingService
 * @package App\Core\Listing\Service
 */
class ListingService
{
    /**
     * @var PersistenceService
     */
    private $persistenceService;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * ListingService constructor.
     * @param PersistenceService $persistenceService
     * @param FlashBagInterface $flashBag
     */
    public function __construct(
        PersistenceService $persistenceService,
        FlashBagInterface $flashBag
    ) {
        $this->persistenceService = $persistenceService;
        $this->flashBag = $flashBag;
    }

    /**
     * @param Listing $listing
     */
    public function post(Listing $listing): void
    {
        try {
            $this->persistenceService->persist($listing);
            $this->flashBag->add('success', 'listing.post.success');
        } catch (\Exception $exception) {
            $this->flashBag->add('error', 'listing.post.failed');
        }
    }
}
