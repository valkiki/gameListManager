<?php

declare(strict_types=1);

namespace App\tests\Integration\Listing;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ListingControllerTest
 * @package App\tests\Integration\Listing
 */
class ListingControllerTest extends WebTestCase
{
    private $client;
    private $routes;

    protected function setUp()
    {
        $this->client = static::createClient();
        $this->routes = [
            '/list/all' => 'GET',
            '/list/create' => 'POST'
        ];
    }

    /**
     * @test
     */
    public function isAvailable()
    {
        foreach ($this->routes as $route => $method) {
            $this->client->request($method, $route);
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        }
    }
}
