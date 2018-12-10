<?php

declare(strict_types=1);

namespace App\tests\UnitTest\Core\Component\Listing\Service;

use App\Core\Component\Listing\Entity\Listing;
use App\Core\Component\Listing\Service\ListingService;
use App\Infrastructure\Persistence\PersistenceService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

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

        $this->service = new ListingService(
            new PersistenceService($this->entityManager),
            new FlashBag()
        );

        $this->entityManager->getConnection()->beginTransaction();
    }

    /**
     * @test
     */
    public function postSuccessfully()
    {
        $listing = new Listing();
        $listing->setId('666-666-666');
        $listing->setName('toto');

        $this->service->post($listing);

        $listings = $this->entityManager
            ->getRepository(Listing::class)
            ->findBy(['name' => 'toto']);

        $this->assertCount(1, $listings);
    }

    public function tearDown()
    {
        $this->entityManager->getConnection()->rollback();
    }
}
