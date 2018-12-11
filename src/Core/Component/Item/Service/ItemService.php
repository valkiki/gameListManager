<?php

declare(strict_types=1);

namespace App\Core\Component\Item\Service;

use App\Core\Component\Item\Entity\Item;
use App\Core\Component\Listing\Repository\ListingRepository;
use App\Core\Port\Notification\Client\Flashbag\FlashbagNotification;
use App\Core\Port\Notification\NotificationServiceInterface;
use App\Core\Port\Persistence\PersistenceServiceInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ItemService
{
    /**
     * @var PersistenceServiceInterface
     */
    private $persistenceService;
    /**
     * @var NotificationServiceInterface
     */
    private $notificationService;

    /**
     * ItemService constructor.
     * @param PersistenceServiceInterface $persistenceService
     * @param NotificationServiceInterface $notificationService
     */
    public function __construct(
        PersistenceServiceInterface $persistenceService,
        NotificationServiceInterface $notificationService
    ) {
        $this->persistenceService = $persistenceService;
        $this->notificationService = $notificationService;
    }

    /**
     * @param Item $item
     */
    public function add(Item $item): void
    {
        try {
            $this->persistenceService->upsert($item);
            $this->notificationService->notify(
                new FlashbagNotification('success', 'item.post.success')
            );
        } catch (\Exception $exception) {
            $this->notificationService->notify(
                new FlashbagNotification('success', 'item.post.error')
            );
        }
    }
}
