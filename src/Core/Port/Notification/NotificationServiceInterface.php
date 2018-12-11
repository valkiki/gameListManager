<?php

declare(strict_types=1);

namespace App\Core\Port\Notification;

/**
 * Interface NotificationServiceInterface
 * @package App\Core\Port\Notification
 */
interface NotificationServiceInterface
{
    public function notify(NotificationInterface $notification): void;
}
