<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification\Client\Flashbag;

use App\Core\Port\Notification\Client\Flashbag\FlashbagNotification;
use App\Core\Port\Notification\Client\Flashbag\FlashbagNotifierInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Class FlashbagClient
 * @package App\Infrastructure\Notification\Client\Flashbag
 */
class FlashbagClient implements FlashbagNotifierInterface
{
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * FlashbagClient constructor.
     * @param FlashBagInterface $flashBag
     */
    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    /**
     * @param FlashbagNotification $flashbagNotification
     */
    public function sendFlashbag(FlashbagNotification $flashbagNotification): void
    {
        $this->flashBag->add(
            $flashbagNotification->getType(),
            $flashbagNotification->getContent()
        );
    }
}
