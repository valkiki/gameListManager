<?php

declare(strict_types=1);

namespace App\tests\UnitTest\Infrastructure\Notification\Client\Flashbag;

use App\Core\Port\Notification\Client\Flashbag\FlashbagNotification;
use App\Infrastructure\Notification\Client\Flashbag\FlashbagClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

/**
 * Class FlashbagClientTest
 * @package App\tests\UnitTest\Infrastructure\Notification\Client\Flashbag
 */
class FlashbagClientTest extends TestCase
{
    /**
     * @var FlashbagClient $client
     */
    private $client;

    protected function setUp()
    {
        $this->client = new FlashbagClient(
            $this->getMockBuilder(FlashBag::class)->getMock()
        );
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function sendFlashbag()
    {
        $this->client->sendFlashbag(
            new FlashbagNotification('success', 'Ma notification')
        );
    }
}
