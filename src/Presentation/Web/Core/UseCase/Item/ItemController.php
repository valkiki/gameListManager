<?php

declare(strict_types=1);

namespace App\Presentation\Web\Core\UseCase\Item;

use App\Core\Component\Item\Entity\Item;
use App\Core\Component\Item\Service\ItemService;
use App\Core\Component\Listing\Service\ListingService;
use App\Core\Port\Response\ResponseFactoryInterface;
use App\Core\Port\TemplateEngine\TemplateEngineInterface;
use App\Infrastructure\TemplateEngine\Twig\TemplateEngine;
use App\Presentation\Web\Core\Form\Type\ItemType;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ItemController
 * @package App\Presentation\Web\UseCase\Item
 */
class ItemController extends AbstractController
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
     * @var TemplateEngine
     */
    private $templateEngine;
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * ItemController constructor.
     * @param ItemService $itemService
     * @param ListingService $listingService
     * @param TemplateEngineInterface $templateEngine
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(
        ItemService $itemService,
        ListingService $listingService,
        TemplateEngineInterface $templateEngine,
        ResponseFactoryInterface $responseFactory
    ) {
        $this->itemService = $itemService;
        $this->listingService = $listingService;
        $this->templateEngine = $templateEngine;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): ResponseInterface
    {
        $item = new Item();
        $listing = $this->listingService->get((int)$request->get('listing_id'));

        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->itemService->create($listing, $item);
            return $this->responseFactory->redirectToRoute('listing_index');
        }

        return $this->templateEngine->renderResponse(
            '@Item/form.html.twig',
            ['create_form' => $form->createView()]
        );
    }

    public function delete(Item $item): ResponseInterface
    {
        $this->itemService->delete($item);

        return $this->responseFactory->redirectToRoute(
            'listing_show',
            ['id' => $item->getListing()->getId()]
        );
    }
}
