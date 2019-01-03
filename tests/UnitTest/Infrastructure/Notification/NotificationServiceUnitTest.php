<?php

declare(strict_types=1);

namespace App\tests\UnitTest\Infrastructure\Notification;

use App\Core\Port\Notification\NotificationInterface;
use App\Infrastructure\Notification\NotificationService;
use App\Infrastructure\Notification\NotificationType;
use App\Infrastructure\Notification\Strategy\NotificationStrategyInterface;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

/**
 * @small
 */
final class NotificationServiceUnitTest extends TestCase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function onlyExpectedStrategiesGetToNotify(): void
    {
        /* @var NotificationInterface|MockInterface $notification */
        $notification = Mockery::mock(NotificationInterface::class);

        $notificationType = NotificationType::FLASHBAG;
        $flashbagStrategyMock = $this->createStrategyMockThatShouldNotify($notificationType, $notification);

        $notificationService = new NotificationService($flashbagStrategyMock);

        $notificationService->notify($notification);
    }

    private function createStrategyMockThatShouldNotify(
        string $type,
        $notification
    ): NotificationStrategyInterface {
        /* @var NotificationStrategyInterface|MockInterface $strategyMock */
        $strategyMock = Mockery::mock(NotificationStrategyInterface::class);
        $strategyMock->shouldReceive('getType')->twice()->andReturn($type);
        $strategyMock->shouldReceive('notify')->once()->with($notification);
        $strategyMock->shouldReceive('canHandleNotification')->once()->with($notification)->andReturn(true);

        return $strategyMock;
    }
}
