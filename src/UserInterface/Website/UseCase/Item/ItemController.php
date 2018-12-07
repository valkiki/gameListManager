<?php

declare(strict_types=1);

namespace App\UserInterface\Website\UseCase\Item;

use App\Core\Component\Item\Entity\Item;
use App\Core\Component\Item\Service\ItemService;
use App\Core\Component\Listing\Repository\ListingRepository;
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
    /**
     * @var ListingRepository
     */
    private $listingRepository;

    public function __construct(
        ItemService $itemService,
        HandlerFactoryInterface $handlerFactory,
        ListingRepository $listingRepository
    ) {
        $this->itemService = $itemService;
        $this->handlerFactory = $handlerFactory;
        $this->listingRepository = $listingRepository;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $item = new Item();
        $listing = $this->listingRepository->find($request->get('listing_id'));

        $item->setListing($listing);

        $handler = $this->handlerFactory->create(PostItemFormHandler::class);
        $response = $handler->handle(
            $request,
            $item
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
