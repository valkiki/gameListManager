<?php

declare(strict_types=1);

namespace App\UserInterface\Website\Listing;

use App\Core\Listing\Entity\Listing;
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
        return $this->render(
            '@Listing/index.html.twig'
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $listing = new Listing();

        $form = $this->createFormBuilder($listing)
            ->add('name', TextType::class)
            ->add('Enregistrer', SubmitType::class, array('label' => 'Create Listing'))
            ->getForm();

        return $this->render(
            '@Listing/create.html.twig',
            [
                'create_form' => $form->createView()
            ]
        );
    }
}