<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification\Strategy\Flashbag;

use App\Core\Port\Notification\Client\Flashbag\FlashbagNotifierInterface;
use App\Core\Port\Notification\NotificationInterface;
use App\Infrastructure\Notification\NotificationType;
use App\Infrastructure\Notification\Strategy\NotificationStrategyInterface;

/**
 * Class FlashbagNotificationStrategy
 * @package App\Infrastructure\Notification\Strategy\Flashbag
 */
class FlashbagNotificationStrategy implements NotificationStrategyInterface
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var FlashbagNotifierInterface
     */
    private $flashbagNotifier;

    /**
     * FlashbagNotificationStrategy constructor.
     * @param FlashbagNotifierInterface $flashbagNotifier
     */
    public function __construct(FlashbagNotifierInterface $flashbagNotifier)
    {
        $this->type = NotificationType::FLASHBAG;
        $this->flashbagNotifier = $flashbagNotifier;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param NotificationInterface $notification
     */
    public function notify(NotificationInterface $notification): void
    {
        $this->flashbagNotifier->sendFlashbag($notification);
    }

    /**
     * @param NotificationInterface $notification
     * @return bool
     */
    public function canHandleNotification(NotificationInterface $notification) : bool
    {
        // Flashbag notifications are always active for the moment
        return true;
    }
}
