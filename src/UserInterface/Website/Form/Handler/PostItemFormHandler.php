<?php

declare(strict_types=1);

namespace App\UserInterface\Website\Form\Handler;

use App\Core\Component\Item\Entity\Item;
use App\Core\Component\Item\Service\ItemService;
use App\UserInterface\Website\Form\Type\ItemType;
use Hostnet\Component\FormHandler\HandlerConfigInterface;
use Hostnet\Component\FormHandler\HandlerTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class PostItemFormHandler
 * @package App\UserInterface\Website\Form\Handler
 */
class PostItemFormHandler implements HandlerTypeInterface
{
    /**
     * @var ItemService
     */
    private $itemService;
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * PostItemFormHandler constructor.
     * @param ItemService $itemService
     * @param RequestStack $requestStack
     */
    public function __construct(
        ItemService $itemService,
        RequestStack $requestStack
    ) {
        $this->itemService = $itemService;
        $this->requestStack = $requestStack;
    }

    /**
     * Configure the Handler.
     *
     * @param HandlerConfigInterface $config
     */
    public function configure(HandlerConfigInterface $config): void
    {
        $config->setType(ItemType::class);

        $config->onSuccess(function (Item $item) {
            $this->itemService->add($item);
        });
    }
}
