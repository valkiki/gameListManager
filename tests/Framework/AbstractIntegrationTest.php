<?php

declare(strict_types=1);

namespace App\tests\Framework;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Hgraca\DoctrineTestDbRegenerationBundle\EventSubscriber\DatabaseAwareTestInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractIntegrationTest extends KernelTestCase implements DatabaseAwareTestInterface
{
    protected function setUp()
    {
        self::bootKernel();

        $em = $this->getContainer()
            ->get('doctrine')
            ->getManager();

        $loader = new Loader();
        $loader->loadFromDirectory('/opt/gameListManager/tests/DataFixtures');

        (new ORMExecutor($em, new ORMPurger()))->execute($loader->getFixtures());
    }

    protected function getContainer(): ContainerInterface
    {
        self::bootKernel();

        return static::$kernel->getContainer();
    }
}
