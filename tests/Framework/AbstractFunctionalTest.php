<?php

declare(strict_types=1);

namespace App\tests\Framework;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Hgraca\DoctrineTestDbRegenerationBundle\EventSubscriber\DatabaseAwareTestInterface;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AbstractFunctionalTest
 * @package App\tests\Framework
 */
abstract class AbstractFunctionalTest extends WebTestCase implements DatabaseAwareTestInterface
{
    protected function setUp()
    {
        $em = $this->getContainer()
            ->get('doctrine')
            ->getManager();

        $loader = new Loader();
        $loader->loadFromDirectory('/opt/gameListManager/tests/DataFixtures');

        (new ORMExecutor($em, new ORMPurger()))->execute($loader->getFixtures());
    }

    /**
     * @var Client
     */
    private $client;

    protected function getClient(array $options = [], array $server = []): Client
    {
        return $this->client ?? $this->client = parent::createClient($options, $server);
    }

    protected function getContainer(): ContainerInterface
    {
        return $this->getClient()->getContainer();
    }

    protected function getEntityManager()
    {
        return $this->getContainer()
            ->get('doctrine')
            ->getManager();
    }
}
