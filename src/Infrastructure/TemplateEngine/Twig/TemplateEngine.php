<?php

declare(strict_types=1);

namespace App\Infrastructure\TemplateEngine\Twig;

use App\Core\Port\TemplateEngine\TemplateEngineInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TemplateEngine
 * @package App\Infrastructure\TemplateEngine\Twig
 */
final class TemplateEngine implements TemplateEngineInterface
{
    /**
     * @var EngineInterface
     */
    private $engine;
    /**
     * @var HttpMessageFactoryInterface
     */
    private $responseFactory;
    /**
     * @var HttpFoundationFactoryInterface
     */
    private $httpFoundationFactory;

    /**
     * TemplateEngine constructor.
     * @param EngineInterface $engine
     * @param HttpMessageFactoryInterface $responseFactory
     * @param HttpFoundationFactoryInterface $httpFoundationFactory
     */
    public function __construct(
        EngineInterface $engine,
        HttpMessageFactoryInterface $responseFactory,
        HttpFoundationFactoryInterface $httpFoundationFactory
    ) {
        $this->engine = $engine;
        $this->responseFactory = $responseFactory;
        $this->httpFoundationFactory = $httpFoundationFactory;
    }

    /**
     * @param string $template
     * @return bool
     */
    public function exists(string $template): bool
    {
        return $this->engine->exists($template);
    }

    /**
     * @param string $template
     * @param array $parameters
     * @return Response
     */
    public function render(string $template, array $parameters): string
    {
        return $this->engine->render(
            $template,
            $parameters
        );
    }

    /**
     * @param string $template
     * @param array $parameters
     * @return ResponseInterface
     */
    public function renderResponse(
        string $template,
        array $parameters = [],
        ResponseInterface $response = null
    ): ResponseInterface {
        if ($response) {
            $response = $this->httpFoundationFactory->createResponse($response);
        }

        $response = $this->responseFactory->createResponse(
            $this->engine->renderResponse(
                $template,
                $parameters,
                $response
            )
        );

        $response->getBody()->rewind();

        return $response;
    }
}
