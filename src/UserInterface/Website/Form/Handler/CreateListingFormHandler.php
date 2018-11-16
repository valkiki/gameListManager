<?php

declare(strict_types=1);

namespace App\UserInterface\Website\Form\Handler;

use App\Core\Listing\Entity\Listing;
use App\UserInterface\Website\Form\Type\ListingType;
use Doctrine\ORM\EntityManagerInterface;
use Hostnet\Component\FormHandler\HandlerConfigInterface;
use Hostnet\Component\FormHandler\HandlerTypeInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class CreateListingFormHandler implements HandlerTypeInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * CreateListingFormHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param FlashBagInterface $flashBag
     */
    public function __construct
    (
        EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag
    )
    {
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
    }

    /**
     * Configure the Handler.
     *
     * @param HandlerConfigInterface $config
     */
    public function configure(HandlerConfigInterface $config)
    {
        $config->setType(ListingType::class);

        $config->onSuccess(function(Listing $listing){

            $this->entityManager->persist($listing);
            $this->entityManager->flush();

            $this->flashBag->add('success', 'The listing has been created.');
        });
    }
}