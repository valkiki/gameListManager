<?php

declare(strict_types=1);

namespace App\tests\UnitTest\Core\Component\Listing\Service;

use App\Core\Component\Listing\Entity\Listing;
use App\Core\Component\Listing\Repository\ListingRepository;
use App\Core\Component\Listing\Service\ListingService;
use App\Infrastructure\Notification\NotificationService;
use App\Infrastructure\Persistence\Doctrine\PersistenceService;
use App\tests\Framework\AbstractIntegrationTest;

/**
 * Class ListingServiceTest
 * @package App\tests\UnitTest\Core\Component\Listing\Service
 */
class ListingServiceTest extends AbstractIntegrationTest
{
    private $service;
    private $entityManager;

    public function setUp()
    {
        parent::setUp();

        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->service = new ListingService(
            new ListingRepository($this->entityManager, new PersistenceService($this->entityManager)),
            $this->getMockBuilder(NotificationService::class)->getMock()
        );
    }

    /**
     * @test
     */
    public function createSuccessfully()
    {
        $listing = new Listing();
        $listing->setId(1);
        $listing->setName('toto');

        $this->service->create($listing);

        $listings = $this->entityManager
            ->getRepository(Listing::class)
            ->findBy(['name' => 'toto']);

        $this->assertCount(1, $listings);
    }

    /**
     * @test
     */
    public function updateSuccessfully()
    {
        $listing = $this->entityManager
            ->getRepository(Listing::class)
            ->findOneBy(['name' => 'My first listing']);

        $listing->setName('My first listing after update');

        $this->service->update($listing);

        $listings = $this->entityManager
            ->getRepository(Listing::class)
            ->findBy(['name' => 'My first listing after update']);

        $this->assertCount(1, $listings);
    }

    /**
     * @test
     */
    public function deleteSuccessfully()
    {
        $listing = $this->entityManager
            ->getRepository(Listing::class)
            ->findOneBy(['name' => 'My first listing']);

        $this->service->delete($listing);

        $listing = $this->entityManager
            ->getRepository(Listing::class)
            ->findOneBy(['name' => 'My first listing']);

        $this->assertNull($listing);
    }
}
