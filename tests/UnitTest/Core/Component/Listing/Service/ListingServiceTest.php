<?php

declare(strict_types=1);

namespace App\tests\UnitTest\Core\Component\Listing\Service;

use App\Core\Component\Listing\Entity\Listing;
use App\Core\Component\Listing\Service\ListingService;
use App\Infrastructure\Notification\NotificationService;
use App\Infrastructure\Persistence\Doctrine\PersistenceService;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ListingServiceTest
 * @package App\tests\UnitTest\Core\Component\Listing\Service
 */
class ListingServiceTest extends KernelTestCase
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

        $this->service = new ListingService(
            new PersistenceService($this->entityManager),
            $this->getMockBuilder(NotificationService::class)->getMock()
        );
    }

    /**
     * @test
     */
    public function postSuccessfully()
    {
        $listing = new Listing();
        $listing->setId(1);
        $listing->setName('toto');

        $this->service->post($listing);

        $listings = $this->entityManager
            ->getRepository(Listing::class)
            ->findBy(['name' => 'toto']);

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
