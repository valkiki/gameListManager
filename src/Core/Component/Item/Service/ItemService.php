<?php

declare(strict_types=1);

namespace App\Core\Component\Item\Service;

use App\Core\Component\Item\Entity\Item;
use App\Core\Component\Item\Repository\ItemRepositoryInterface;
use App\Core\Component\Listing\Entity\Listing;
use App\Core\Port\Notification\Client\Flashbag\FlashbagNotification;
use App\Core\Port\Notification\NotificationServiceInterface;

/**
 * Class ItemService
 * @package App\Core\Component\Item\Service
 */
class ItemService
{
    /**
     * @var NotificationServiceInterface
     */
    private $notificationService;
    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;

    /**
     * ItemService constructor.
     * @param ItemRepositoryInterface $itemRepository
     * @param NotificationServiceInterface $notificationService
     */
    public function __construct(
        ItemRepositoryInterface $itemRepository,
        NotificationServiceInterface $notificationService
    ) {
        $this->itemRepository = $itemRepository;
        $this->notificationService = $notificationService;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->itemRepository->findAll();
    }

    /**
     * @param Listing $listing
     * @param Item $item
     */
    public function create(Listing $listing, Item $item): void
    {
        try {
            $item->setListing($listing);

            $this->itemRepository->create($item);
            $this->notificationService->notify(
                new FlashbagNotification(FlashbagNotification::ALERT_SUCCESS, 'item.post.success')
            );
        } catch (\Exception $exception) {
            $this->notificationService->notify(
                new FlashbagNotification(FlashbagNotification::ALERT_ERROR, 'item.post.error')
            );
        }
    }

    /**
     * @param Item $item
     */
    public function delete(Item $item): void
    {
        $this->itemRepository->delete($item);

        $this->notificationService->notify(
            new FlashbagNotification(FlashbagNotification::ALERT_SUCCESS, 'item.delete.success')
        );
    }

    /**
     * @param int $listing_id
     * @return array
     */
    public function getItemsByListing(int $listing_id) : array
    {
        return $this->itemRepository->findBy([
            'listing' => $listing_id
        ]);
    }
}
