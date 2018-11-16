<?php

declare(strict_types=1);

namespace App\UserInterface\Website\UseCase\Listing;

use App\Core\Listing\Entity\Listing;
use App\UserInterface\Website\Form\Type\ListingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ListingController
 * @package App\UserInterface\Listing
 */
class ListingController extends AbstractController
{
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
        $this->createForm(
            ListingType::class,
            new Listing()
        );

        $form = $this->createFormBuilder($listing)
            ->add('name', TextType::class)
            ->add('Enregistrer', SubmitType::class, array('label' => 'Create Listing'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            $this->redirectToRoute('listing_index');

        }

        return $this->render(
            '@Listing/create.html.twig',
            [
                'create_form' => $form->createView()
            ]
        );
    }
}