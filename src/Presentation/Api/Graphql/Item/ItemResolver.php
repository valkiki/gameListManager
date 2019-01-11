<?php

namespace App\Presentation\Api\Graphql\Item;

use App\Core\Component\Item\Entity\Item;
use App\Core\Component\Item\Service\ItemService;
use App\Core\Component\Listing\Service\ListingService;
use Overblog\GraphQLBundle\Definition\Argument;

class ItemResolver
{
    /**
     * @var ItemService
     */
    private $itemService;
    /**
     * @var ListingService
     */
    private $listingService;

    /**
     * ItemResolver constructor.
     * @param ItemService $itemService
     */
    public function __construct(ItemService $itemService, ListingService $listingService)
    {
        $this->itemService = $itemService;
        $this->listingService = $listingService;
    }

    public function resolveAddItemInListing(Argument $arguments) : void
    {
        $listing = $this->listingService->get($arguments['input']['listingId']);
        $item = new Item();
        $item->setName($arguments['input']['name']);

        $this->itemService->create(
            $listing,
            $item
        );
    }
}
