<?php

declare(strict_types=1);

namespace App\UserInterface\Website\UseCase\Listing;

use App\Core\Listing\Entity\Listing;
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
     * ListingController constructor.
     * @param HandlerFactoryInterface $handlerFactory
     */
    public function __construct(HandlerFactoryInterface $handlerFactory)
    {
        $this->handlerFactory = $handlerFactory;
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
}
