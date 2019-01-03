<?php

declare(strict_types=1);

namespace App\Core\Port\Response;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

interface ResponseFactoryInterface
{
    public function redirectToUrl(string $url, int $status = 302): ResponseInterface;

    public function redirectToRoute(string $route, array $parameters = [], int $status = 302) : ResponseInterface;
}
