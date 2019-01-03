<?php

declare(strict_types=1);

namespace App\UserInterface\Website\UseCase\Listing;

use App\Core\Component\Listing\Entity\Listing;
use App\Core\Component\Listing\Service\ListingService;
use App\UserInterface\Website\Form\Type\ListingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ListingController
 * @package App\UserInterface\Listing
 */
class ListingController extends AbstractController
{
    /**
     * @var ListingService
     */
    private $listingService;

    /**
     * ListingController constructor.
     * @param ListingService $listingService
     */
    public function __construct(
        ListingService $listingService
    ) {
        $this->listingService = $listingService;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->render(
            '@Listing/index.html.twig',
            ['listings' => $this->listingService->getAll()]
        );
    }

    /**
     * @param Listing $listing
     * @return Response
     */
    public function show(Listing $listing): Response
    {
        return $this->render(
            '@Listing/show.html.twig',
            ['listing' => $this->listingService->get($listing->getId())]
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $listing = new Listing();
        $form = $this->createForm(ListingType::class, $listing);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->listingService->post($listing);
            return $this->redirectToRoute('listing_index');
        }

        return $this->render(
            '@Listing/form.html.twig',
            ['create_form' => $form->createView()]
        );
    }

    /**
     * @param Request $request
     * @param Listing $listing
     * @return Response
     */
    public function edit(Request $request, Listing $listing): Response
    {
        $form = $this->createForm(ListingType::class, $listing);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->listingService->post($listing);
            return $this->redirectToRoute('listing_index');
        }

        return $this->render(
            '@Listing/form.html.twig',
            ['create_form' => $form->createView()]
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
