<?php

namespace App\Presentation\Api\Graphql\Item;

use App\Core\Component\Item\Service\ItemService;
use Overblog\GraphQLBundle\Definition\Argument;

class ItemResolver
{
    /**
     * @var ItemService
     */
    private $itemService;

    /**
     * ItemResolver constructor.
     * @param ItemService $itemService
     */
    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }
}
