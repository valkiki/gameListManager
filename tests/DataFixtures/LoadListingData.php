<?php

declare(strict_types=1);

namespace App\tests\DataFixtures;

use App\Core\Component\Listing\Entity\Listing;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadListingData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $listing = new Listing();
        $listing->setName('My first listing');

        $manager->persist($listing);

        $listing = new Listing();
        $listing->setName('My second listing');

        $manager->persist($listing);
        $manager->flush();
    }
}