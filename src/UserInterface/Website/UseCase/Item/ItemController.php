<?php

declare(strict_types=1);

namespace App\UserInterface\Website\UseCase\Item;

use App\Core\Component\Item\Entity\Item;
use App\Core\Component\Item\Service\ItemService;
use App\UserInterface\Website\Form\Handler\PostItemFormHandler;
use Hostnet\Component\FormHandler\HandlerFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ItemController
 * @package App\UserInterface\Website\UseCase\Item
 */
class ItemController extends AbstractController
{
    /**
     * @var ItemService
     */
    private $itemService;
    /**
     * @var HandlerFactoryInterface
     */
    private $handlerFactory;

    public function __construct(
        ItemService $itemService,
        HandlerFactoryInterface $handlerFactory
    ) {
        $this->itemService = $itemService;
        $this->handlerFactory = $handlerFactory;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $handler = $this->handlerFactory->create(PostItemFormHandler::class);
        $response = $handler->handle(
            $request,
            new Item()
        );

        if ($response instanceof RedirectResponse) {
            return $response;
        }

        return $this->render(
            '@Item/form.html.twig',
            ['create_form' => $handler->getForm()->createView()]
        );
    }
}
