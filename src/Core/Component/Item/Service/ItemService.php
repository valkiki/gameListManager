<?php

declare(strict_types=1);

namespace App\Core\Component\Item\Service;

use App\Core\Component\Item\Entity\Item;
use App\Core\Component\Listing\Repository\ListingRepository;
use App\Infrastructure\Persistence\PersistenceService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ItemService
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
     * ItemService constructor.
     * @param PersistenceService $persistenceService
     * @param ListingRepository $listingRepository
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
     * @param Item $item
     */
    public function add(Item $item): void
    {
        try {
            $this->persistenceService->upsert($item);
            $this->flashBag->add('success', 'item.post.success');
        } catch (\Exception $exception) {
            $this->flashBag->add('alert', 'item.post.error');
        }
    }
}
