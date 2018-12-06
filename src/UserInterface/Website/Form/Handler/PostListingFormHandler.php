<?php

declare(strict_types=1);

namespace App\UserInterface\Website\Form\Handler;

use App\Core\Listing\Service\ListingService;
use App\Core\Listing\Entity\Listing;
use App\UserInterface\Website\Form\Type\ListingType;
use Hostnet\Component\FormHandler\HandlerConfigInterface;
use Hostnet\Component\FormHandler\HandlerTypeInterface;

/**
 * Class PostListingFormHandler
 * @package App\UserInterface\Website\Form\Handler
 */
class PostListingFormHandler implements HandlerTypeInterface
{
    /**
     * @var ListingService
     */
    private $listingService;

    /**
     * PostListingFormHandler constructor.
     * @param ListingService $listingService
     */
    public function __construct(ListingService $listingService)
    {
        $this->listingService = $listingService;
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
            $this->listingService->post($listing);
        });
    }
}
