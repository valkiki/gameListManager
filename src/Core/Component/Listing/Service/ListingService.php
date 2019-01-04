<?php

declare(strict_types=1);

namespace App\Core\Component\Listing\Service;

use App\Core\Component\Listing\Entity\Listing;
use App\Core\Component\Listing\Repository\ListingRepositoryInterface;
use App\Core\Port\Notification\Client\Flashbag\FlashbagNotification;
use App\Core\Port\Notification\NotificationServiceInterface;

/**
 * Class ListingService
 * @package App\Core\Listing\Service
 */
class ListingService
{
    /**
     * @var NotificationServiceInterface
     */
    private $notificationService;
    /**
     * @var ListingRepositoryInterface
     */
    private $listingRepository;

    /**
     * ListingService constructor.
     * @param ListingRepositoryInterface $listingRepository
     * @param NotificationServiceInterface $notificationService
     */
    public function __construct(
        ListingRepositoryInterface $listingRepository,
        NotificationServiceInterface $notificationService
    ) {
        $this->listingRepository = $listingRepository;
        $this->notificationService = $notificationService;
    }

    public function getAll()
    {
        return $this->listingRepository->findAll();
    }

    public function get(int $id)
    {
        return $this->listingRepository->find($id);
    }

    /**
     * @param Listing $listing
     */
    public function post(Listing $listing): void
    {
        try {
            $this->listingRepository->add($listing);
            $this->notificationService->notify(
                new FlashbagNotification(FlashbagNotification::ALERT_SUCCESS, 'listing.post.success')
            );
        } catch (\Exception $exception) {
            $this->notificationService->notify(
                new FlashbagNotification(FlashbagNotification::ALERT_ERROR, 'listing.post.error')
            );
        }
    }

    /**
     * @param Listing $listing
     */
    public function delete(Listing $listing): void
    {
        try {
            $this->listingRepository->delete($listing);
            $this->notificationService->notify(
                new FlashbagNotification(FlashbagNotification::ALERT_SUCCESS, 'listing.delete.success')
            );
        } catch (\Exception $exception) {
            $this->notificationService->notify(
                new FlashbagNotification(FlashbagNotification::ALERT_ERROR, 'listing.delete.error')
            );
        }
    }
}
