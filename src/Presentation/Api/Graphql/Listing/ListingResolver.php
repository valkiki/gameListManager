<?php

namespace App\Presentation\Api\Graphql\Listing;

use App\Core\Component\Listing\Entity\Listing;
use App\Core\Component\Listing\Service\ListingService;
use Overblog\GraphQLBundle\Definition\Argument;

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

    /**
     * @param Argument $arguments
     * @return Listing
     */
    public function resolveListing(Argument $arguments) : Listing
    {
        return $this->listingService->get($arguments['id']);
    }

    /**
     * @param Argument $arguments
     */
    public function resolveCreateListing(Argument $arguments) : Listing
    {
        $listing = new Listing();
        $listing->setName($arguments['name']);

        $this->listingService->create($listing);

        return $listing;
    }

    /**
     * @param Argument $arguments
     */
    public function resolveDeleteListing(Argument $arguments) : Int
    {
        $listing = $this->listingService->get($arguments['id']);

        if (!$listing) {
            throw new \Exception('No listing to delete.');
        }

        $this->listingService->delete($listing);

        return $arguments['id'];
    }
}
