<?php

declare(strict_types=1);

namespace App\UserInterface\Website\Listing;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ListingController
 * @package App\UserInterface\Listing
 */
class ListingController extends  AbstractController
{
    /**
     * @return Response
     */
    public function index() : Response
    {
        return $this->render(
            '@Listing/index.html.twig'
        );
    }
}