<?php

declare(strict_types=1);

namespace App\Core\Component\Item\Service;

use App\Core\Component\Item\Entity\Item;
use App\Core\Component\Item\Repository\ItemRepositoryInterface;
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
     * @param Item $item
     */
    public function add(Item $item): void
    {
        try {
            $this->itemRepository->add($item);
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
