<?php

declare(strict_types=1);

namespace App\tests\UnitTest\Core\Component\Item\Service;

use App\Core\Component\Item\Entity\Item;
use App\Core\Component\Item\Repository\ItemRepository;
use App\Core\Component\Item\Service\ItemService;
use App\Core\Component\Listing\Entity\Listing;
use App\Core\Port\Notification\NotificationServiceInterface;
use App\Infrastructure\Notification\NotificationService;
use App\Infrastructure\Persistence\Doctrine\PersistenceService;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

/**
 * Class ListingServiceTest
 * @package App\tests\UnitTest\Core\Component\Listing\Service
 */
class ItemServiceTest extends KernelTestCase
{
    private $service;
    private $entityManager;

    public function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $loader = new Loader();
        $loader->loadFromDirectory('/opt/gameListManager/tests/DataFixtures');

        (new ORMExecutor(
            $this->entityManager,
            new ORMPurger()
        ))->execute($loader->getFixtures());

        $this->service = new ItemService(
            new ItemRepository($this->entityManager, new PersistenceService($this->entityManager)),
            $this->getMockBuilder(NotificationService::class)->getMock()
        );
    }

    /**
     * @test
     */
    public function addSuccessfully()
    {
        $listing = $this->entityManager
            ->getRepository(Listing::class)
            ->findOneBy(['name' => 'My first listing']);

        $item = new Item();
        $item->setName('My awesome item');
        $item->setListing($listing);

        $this->service->add($item);

        $items = $this->entityManager
            ->getRepository(Item::class)
            ->findBy(['name' => 'My awesome item']);

        $this->assertCount(1, $items);
    }
}
