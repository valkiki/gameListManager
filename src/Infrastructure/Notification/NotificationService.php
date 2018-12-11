<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification;

use App\Core\Port\Notification\NotificationInterface;
use App\Core\Port\Notification\NotificationServiceInterface;
use App\Infrastructure\Notification\Strategy\NotificationStrategyInterface;

/**
 * Class NotificationService
 * @package App\Infrastructure\Notification
 * @author Herberto Graca <herberto.graca@gmail.com>
 * @author Nicolae Nichifor
 */
class NotificationService implements NotificationServiceInterface
{
    /**
     * @var NotificationStrategyInterface[]
     */
    private $notificationStrategyList;

    /**
     * NotificationService constructor.
     * @param NotificationStrategyInterface ...$notificationStrategyList
     */
    public function __construct(NotificationStrategyInterface ...$notificationStrategyList)
    {
        foreach ($notificationStrategyList as $notificationStrategy) {
            $this->notificationStrategyList[$notificationStrategy->getType()] = $notificationStrategy;
        }
    }

    /**
     * @param NotificationInterface $notification
     * @throws \Exception
     */
    public function notify(NotificationInterface $notification): void
    {
        foreach ($this->resolveNotificationStrategy($notification) as $notificationStrategyType) {
            $this->getNotificationStrategyForType($notificationStrategyType)->notify($notification);
        }
    }

    /**
     * @param string $notificationType
     * @return NotificationStrategyInterface
     */
    private function getNotificationStrategyForType(string $notificationType): NotificationStrategyInterface
    {
        return $this->notificationStrategyList[$notificationType];
    }

    /**
     * @param NotificationInterface $notification
     * @return array
     * @throws \Exception
     */
    private function resolveNotificationStrategy(NotificationInterface $notification): array
    {
        $deliverableBy = \array_map(
            function (NotificationStrategyInterface $strategy) {
                return $strategy->getType();
            },
            \array_filter(
                $this->notificationStrategyList,
                function (NotificationStrategyInterface $strategy) use ($notification) {
                    return $strategy->canHandleNotification($notification);
                }
            )
        );

        if (empty($deliverableBy)) {
            throw new \Exception(
                'Could not find a strategy to deliver the notification ' . \get_class($notification)
            );
        }

        return $deliverableBy;
    }
}
