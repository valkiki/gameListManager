<?php

declare(strict_types=1);

namespace App\UserInterface\Website\Form\Handler;

use App\Core\Listing\Entity\Listing;
use App\UserInterface\Website\Form\Type\ListingType;
use Doctrine\ORM\EntityManagerInterface;
use Hostnet\Component\FormHandler\HandlerConfigInterface;
use Hostnet\Component\FormHandler\HandlerTypeInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Class EditListingFormHandler
 * @package App\UserInterface\Website\Form\Handler
 */
class EditListingFormHandler implements HandlerTypeInterface
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
    public function __construct(
        EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag
    ) {
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
    }

    /**
     * Configure the Handler.
     *
     * @param HandlerConfigInterface $config
     */
    public function configure(HandlerConfigInterface $config): void
    {
        $config->setType(ListingType::class);

        $config->onSuccess(function (Listing $listing) {
            $this->doPersist($listing);
            $this->doAddFlash(
                'success',
                'The listing has been updated.'
            );
        });
    }

    /**
     * @param Listing $listing
     */
    private function doPersist(Listing $listing): void
    {
        $this->entityManager->persist($listing);
        $this->entityManager->flush();
    }

    /**
     * @param string $type
     * @param string $message
     */
    private function doAddFlash(
        string $type,
        string $message
    ): void {
        $this->flashBag->add($type, $message);
    }
}
