<?php

declare(strict_types=1);

namespace App\tests\UnitTest\Core\Component\Item\Service;

use App\Core\Component\Item\Entity\Item;
use App\Core\Component\Item\Repository\ItemRepository;
use App\Core\Component\Item\Service\ItemService;
use App\Core\Component\Listing\Entity\Listing;
use App\Infrastructure\Notification\NotificationService;
use App\Infrastructure\Persistence\Doctrine\PersistenceService;
use App\tests\Framework\AbstractIntegrationTest;
use Doctrine\ORM\EntityManager;

/**
 * Class ListingServiceTest
 * @package App\tests\UnitTest\Core\Component\Listing\Service
 */
class ItemServiceTest extends AbstractIntegrationTest
{
    /**
     * @var ItemService $service
     */
    private $service;

    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    public function setUp()
    {
        parent::setUp();

        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();

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

        $this->service->add($listing, $item);

        $items = $this->entityManager
            ->getRepository(Item::class)
            ->findBy(['name' => 'My awesome item']);

        $this->assertCount(1, $items);
    }

    /**
     * @test
     */
    public function deleteSuccessfully()
    {
        $item = $this->entityManager
            ->getRepository(Item::class)
            ->findOneBy(['name' => 'My first item']);

        $this->service->delete($item);

        $item = $this->entityManager
            ->getRepository(Item::class)
            ->findOneBy(['name' => 'My first item']);

        $this->assertNull($item);
    }
}
