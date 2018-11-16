<?php

declare(strict_types=1);

namespace App\UserInterface\Website\UseCase\Listing;

use App\Core\Listing\Entity\Listing;
use App\UserInterface\Website\Form\Handler\CreateListingFormHandler;
use App\UserInterface\Website\Form\Type\ListingType;
use Hostnet\Component\FormHandler\HandlerFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            [
                'listings' => $listings
            ]
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $handler = $this->handlerFactory->create(CreateListingFormHandler::class);

        if (($response = $handler->handle($request, new Listing())) instanceof RedirectResponse) {
            return $response;
        }

        return $this->render(
            '@Listing/create.html.twig',
            [
                'create_form' => $handler->getForm()->createView()
            ]
        );
    }
}