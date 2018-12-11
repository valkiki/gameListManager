<?php

declare(strict_types=1);

namespace App\Core\Component\Listing\Service;

use App\Core\Component\Listing\Entity\Listing;
use App\Core\Port\Notification\Client\Flashbag\FlashbagNotification;
use App\Core\Port\Notification\NotificationServiceInterface;
use App\Core\Port\Persistence\PersistenceServiceInterface;

/**
 * Class ListingService
 * @package App\Core\Listing\Service
 */
class ListingService
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
     * ListingService constructor.
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
     * @param Listing $listing
     */
    public function post(Listing $listing): void
    {
        try {
            $this->persistenceService->upsert($listing);
            $this->notificationService->notify(
                new FlashbagNotification('success', 'listing.post.success')
            );
        } catch (\Exception $exception) {
            $this->notificationService->notify(
                new FlashbagNotification('success', 'listing.post.error')
            );
        }
    }

    /**
     * @param Listing $listing
     */
    public function delete(Listing $listing): void
    {
        try {
            $this->persistenceService->delete($listing);
            $this->notificationService->notify(
                new FlashbagNotification('success', 'listing.delete.success')
            );
        } catch (\Exception $exception) {
            $this->notificationService->notify(
                new FlashbagNotification('error', 'listing.delete.error')
            );
        }
    }
}
