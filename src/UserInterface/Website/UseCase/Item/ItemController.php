<?php

declare(strict_types=1);

namespace App\UserInterface\Website\UseCase\Item;

use App\Core\Component\Item\Entity\Item;
use App\Core\Component\Item\Service\ItemService;
use App\Core\Component\Listing\Repository\ListingRepository;
use App\UserInterface\Website\Form\Type\ItemType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @var ListingRepository
     */
    private $listingRepository;

    /**
     * ItemController constructor.
     * @param ItemService $itemService
     * @param ListingRepository $listingRepository
     */
    public function __construct(
        ItemService $itemService,
        ListingRepository $listingRepository
    ) {
        $this->itemService = $itemService;
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

        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->itemService->add($item);
            return $this->redirectToRoute('listing_index');
        }

        return $this->render(
            '@Item/form.html.twig',
            ['create_form' => $form->createView()]
        );
    }
}
