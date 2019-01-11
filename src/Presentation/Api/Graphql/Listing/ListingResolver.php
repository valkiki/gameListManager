<?php

namespace App\Presentation\Api\Graphql\Listing;

use App\Core\Component\Listing\Service\ListingService;

class ListingResolver
{
    /**
     * @var ListingService
     */
    private $listingService;

    /**
     * ListingResolver constructor.
     * @param ListingService $listingService
     */
    public function __construct(ListingService $listingService)
    {
        $this->listingService = $listingService;
    }

    /**
     * @return array
     */
    public function resolveListings() : array
    {
        return $this->listingService->getAll();
    }
}
