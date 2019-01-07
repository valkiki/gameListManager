<?php

declare(strict_types=1);

namespace App\Presentation\Web\Core\UseCase\Listing;

use App\Core\Component\Listing\Entity\Listing;
use App\Core\Component\Listing\Service\ListingService;
use App\Core\Port\Response\ResponseFactoryInterface;
use App\Core\Port\TemplateEngine\TemplateEngineInterface;
use App\Infrastructure\TemplateEngine\Twig\TemplateEngine;
use App\Presentation\Web\Core\Form\Type\ListingType;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ListingController
 * @package App\Presentation\Listing
 */
class ListingController extends AbstractController
{
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
     * ListingController constructor.
     * @param ListingService $listingService
     * @param TemplateEngineInterface $templateEngine
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(
        ListingService $listingService,
        TemplateEngineInterface $templateEngine,
        ResponseFactoryInterface $responseFactory
    ) {
        $this->listingService = $listingService;
        $this->templateEngine = $templateEngine;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @return Response
     */
    public function index(): ResponseInterface
    {
        return $this->templateEngine->renderResponse(
            '@Listing/index.html.twig',
            ['listings' => $this->listingService->getAll()]
        );
    }

    /**
     * @param Listing $listing
     * @return Response
     */
    public function show(Listing $listing): ResponseInterface
    {
        return $this->templateEngine->renderResponse(
            '@Listing/show.html.twig',
            ['listing' => $this->listingService->get($listing->getId())]
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): ResponseInterface
    {
        $listing = new Listing();
        $form = $this->createForm(ListingType::class, $listing);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->listingService->create($listing);
            return $this->responseFactory->redirectToRoute('listing_index');
        }

        return $this->templateEngine->renderResponse(
            '@Listing/form.html.twig',
            ['create_form' => $form->createView()]
        );
    }

    /**
     * @param Request $request
     * @param Listing $listing
     * @return Response
     */
    public function edit(Request $request, Listing $listing): ResponseInterface
    {
        $form = $this->createForm(ListingType::class, $listing);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->listingService->create($listing);
            return $this->responseFactory->redirectToRoute('listing_index');
        }

        return $this->templateEngine->renderResponse(
            '@Listing/form.html.twig',
            ['create_form' => $form->createView()]
        );
    }

    /**
     * @param Listing $listing
     * @return Response
     */
    public function delete(Listing $listing): ResponseInterface
    {
        $this->listingService->delete($listing);

        return $this->responseFactory->redirectToRoute('listing_index');
    }
}
