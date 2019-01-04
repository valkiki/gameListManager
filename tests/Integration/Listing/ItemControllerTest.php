<?php

declare(strict_types=1);

namespace App\tests\Integration\Listing;

use App\Core\Component\Listing\Entity\Listing;
use App\tests\Framework\AbstractFunctionalTest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ListingControllerTest
 * @package App\tests\Integration\Item
 */
class ItemControllerTest extends AbstractFunctionalTest
{
    /**
     * @var Listing $listing
     */
    private $listing;

    protected function setUp()
    {
        parent::setUp();

        $this->listing = $this->getEntityManager()
            ->getRepository(Listing::class)
            ->findOneBy([
                'name' => 'My first listing'
            ]);
    }

    /**
     * @test
     * @dataProvider getPublicUrls
     */
    public function publicURLAreAvailable(string $url, int $status): void
    {
        $this->getClient()->request('GET|POST', sprintf($url, (string)$this->listing->getId()));
        $this->assertEquals($status, $this->getClient()->getResponse()->getStatusCode());
    }

    public function getPublicUrls()
    {
        yield ['/list/show/%s/create_item', Response::HTTP_OK];
    }
}
