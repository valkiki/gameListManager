<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification\Strategy;

use App\Core\Port\Notification\NotificationInterface;

/**
 * Interface NotificationStrategyInterface
 * @package App\Infrastructure\Notification\Strategy
 */
interface NotificationStrategyInterface
{
    public function getType(): string;

    public function notify(NotificationInterface $notification): void;

    public function canHandleNotification(NotificationInterface $notification) : bool;
}
