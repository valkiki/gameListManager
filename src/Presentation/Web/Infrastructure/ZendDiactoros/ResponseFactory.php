<?php

declare(strict_types=1);

namespace App\Presentation\Web\Infrastructure\ZendDiactoros;

use App\Core\Port\Response\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class ResponseFactory
 * @package App\Presentation\Web\Infrastructure\ZendDiactoros
 */
final class ResponseFactory implements ResponseFactoryInterface
{
    /**
     * @var HttpMessageFactoryInterface
     */
    private $httpMessageFactory;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * ResponseFactory constructor.
     * @param HttpMessageFactoryInterface $httpMessageFactory
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        HttpMessageFactoryInterface $httpMessageFactory,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->httpMessageFactory = $httpMessageFactory;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param string $url
     * @param int $status
     * @return ResponseInterface
     */
    public function redirectToUrl(string $url, int $status = 302): ResponseInterface
    {
        return $this->httpMessageFactory->createResponse(
            new RedirectResponse($url, $status)
        );
    }

    /**
     * @param string $route
     * @param array $parameters
     * @param int $status
     * @return ResponseInterface
     */
    public function redirectToRoute(string $route, array $parameters = [], int $status = 302): ResponseInterface
    {
        return $this->httpMessageFactory->createResponse(
            new RedirectResponse($this->urlGenerator->generate($route, $parameters, UrlGeneratorInterface::ABSOLUTE_URL), $status)
        );
    }
}
