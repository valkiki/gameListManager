<?php

declare(strict_types=1);

namespace App\UserInterface\Website\UseCase\Listing;

use App\Core\Listing\Entity\Listing;
use App\Core\Listing\Service\ListingService;
use App\UserInterface\Website\Form\Handler\PostListingFormHandler;
use Hostnet\Component\FormHandler\HandlerFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ListingController
 * @package App\UserInterface\Listing
 */
class ListingController extends AbstractController
{
    /**
     * @var HandlerFactoryInterface
     */
    private $handlerFactory;
    /**
     * @var ListingService
     */
    private $listingService;

    /**
     * ListingController constructor.
     * @param HandlerFactoryInterface $handlerFactory
     * @param ListingService $listingService
     */
    public function __construct(
        HandlerFactoryInterface $handlerFactory,
        ListingService $listingService
    ) {
        $this->handlerFactory = $handlerFactory;
        $this->listingService = $listingService;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        $listings = $this->getDoctrine()->getRepository(Listing::class)->findAll();

        return $this->render(
            '@Listing/index.html.twig',
            ['listings' => $listings]
        );
    }

    /**
     * @param Listing $listing
     * @return Response
     */
    public function show(Listing $listing) : Response
    {
        return $this->render(
            '@Listing/show.html.twig',
            ['listing' => $listing]
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $handler = $this->handlerFactory->create(PostListingFormHandler::class);
        $response = $handler->handle(
            $request,
            new Listing()
        );

        if ($response instanceof RedirectResponse) {
            return $response;
        }

        return $this->render(
            '@Listing/form.html.twig',
            ['create_form' => $handler->getForm()->createView()]
        );
    }

    /**
     * @param Request $request
     * @param Listing $listing
     * @return Response
     */
    public function edit(Request $request, Listing $listing): Response
    {
        $handler = $this->handlerFactory->create(PostListingFormHandler::class);
        $response = $handler->handle(
            $request,
            $listing ?? new Listing()
        );

        if ($response instanceof RedirectResponse) {
            return $response;
        }

        return $this->render(
            '@Listing/form.html.twig',
            ['create_form' => $handler->getForm()->createView()]
        );
    }

    /**
     * @param Listing $listing
     * @return Response
     */
    public function delete(Listing $listing): Response
    {
        $this->listingService->delete($listing);

        return $this->redirectToRoute('listing_index');
    }
}
