<?php

declare(strict_types=1);

namespace App\tests\UnitTest\Infrastructure\Notification\Strategy\Flashbag;

use App\Core\Port\Notification\Client\Flashbag\FlashbagNotification;
use App\Infrastructure\Notification\Client\Flashbag\FlashbagClient;
use App\Infrastructure\Notification\Strategy\Flashbag\FlashbagNotificationStrategy;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

/**
 * Class FlashbagNotificationStrategyTest
 * @package App\tests\UnitTest\Infrastructure\Notification\Strategy\Flashbag
 */
class FlashbagNotificationStrategyTest extends TestCase
{
    private $flashbagNotifier;
    private $notificationStrategy;

    protected function setUp()
    {
        $this->flashbagNotifier = $this->getMockBuilder(FlashbagClient::class)
            ->setConstructorArgs([new FlashBag()])
            ->setMethods(['sendFlashbag'])
            ->getMock();

        $this->notificationStrategy = new FlashbagNotificationStrategy($this->flashbagNotifier);
    }

    /**
     * @test
     */
    public function notifyTest()
    {
        $flashBagNotification = new FlashbagNotification('success', 'Ma notification');

        $this->flashbagNotifier
            ->expects($this->once())
            ->method('sendFlashbag')
            ->with($flashBagNotification);

        $this->notificationStrategy->notify($flashBagNotification);
    }
}
