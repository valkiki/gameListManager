<?php

declare(strict_types=1);

namespace App\Core\Port\Notification\Client\Flashbag;

/**
 * Interface FlashbagNotifierInterface
 * @package App\Core\Port\Notification\Client\Flashbag
 */
interface FlashbagNotifierInterface
{
    public function sendFlashbag(FlashbagNotification $flashbagNotification): void;
}
