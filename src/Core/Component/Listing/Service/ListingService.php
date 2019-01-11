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

    /**
     * @return array
     */
    public function getAll() : array
    {
        return $this->listingRepository->findAll();
    }

    /**
     * @param int $id
     * @return Listing
     */
    public function get(int $id) : ?Listing
    {
        return $this->listingRepository->find($id);
    }

    /**
     * @param Listing $listing
     */
    public function create(Listing $listing): void
    {
        try {
            $this->listingRepository->create($listing);
            $flashbagNotification = new FlashbagNotification(
                FlashbagNotification::ALERT_SUCCESS,
                'listing.create.success'
            );
        } catch (\Exception $exception) {
            $flashbagNotification = new FlashbagNotification(
                FlashbagNotification::ALERT_ERROR,
                'listing.create.error'
            );
        } finally {
            $this->notificationService->notify($flashbagNotification);
        }
    }

    /**
     * @param Listing $listing
     */
    public function update(Listing $listing): void
    {
        try {
            $this->listingRepository->create($listing);
            $flashbagNotification = new FlashbagNotification(
                FlashbagNotification::ALERT_SUCCESS,
                'listing.update.success'
            );
        } catch (\Exception $exception) {
            $flashbagNotification = new FlashbagNotification(
                FlashbagNotification::ALERT_ERROR,
                'listing.update.error'
            );
        } finally {
            $this->notificationService->notify($flashbagNotification);
        }
    }

    /**
     * @param Listing $listing
     */
    public function delete(Listing $listing): void
    {
        try {
            $this->listingRepository->delete($listing);
            $flashbagNotification = new FlashbagNotification(
                FlashbagNotification::ALERT_SUCCESS,
                'listing.delete.success'
            );
        } catch (\Exception $exception) {
            $flashbagNotification = new FlashbagNotification(
                FlashbagNotification::ALERT_ERROR,
                'listing.delete.error'
            );
        } finally {
            $this->notificationService->notify($flashbagNotification);
        }
    }
}
