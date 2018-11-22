<?php

declare(strict_types=1);

namespace App\UserInterface\Website\Form\Handler;

use App\Core\Infrastructure\Persistence\DoctrineEntityManager;
use App\Core\Listing\Entity\Listing;
use App\UserInterface\Website\Form\Type\ListingType;
use Doctrine\ORM\EntityManagerInterface;
use Hostnet\Component\FormHandler\HandlerConfigInterface;
use Hostnet\Component\FormHandler\HandlerTypeInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Class CreateListingFormHandler
 * @package App\UserInterface\Website\Form\Handler
 */
class CreateListingFormHandler implements HandlerTypeInterface
{
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * @var DoctrineEntityManager
     */
    private $doctrineEntityManager;

    /**
     * CreateListingFormHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param FlashBagInterface $flashBag
     */
    public function __construct(
        DoctrineEntityManager $doctrineEntityManager,
        FlashBagInterface $flashBag
    ) {
        $this->flashBag = $flashBag;
        $this->doctrineEntityManager = $doctrineEntityManager;
    }

    /**
     * Configure the Handler.
     *
     * @param HandlerConfigInterface $config
     */
    public function configure(HandlerConfigInterface $config)
    {
        $config->setType(ListingType::class);

        $config->onSuccess(function (Listing $listing) {
            $this->doctrineEntityManager->persist($listing);
            $this->flashBag->add('success', 'The listing has been created.');
        });
    }
}
