<?php

declare(strict_types=1);

namespace App\Infrastructure\TemplateEngine\Twig;

use App\Core\Port\TemplateEngine\TemplateEngineInterface;
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
     * TemplateEngine constructor.
     * @param EngineInterface $engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
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
     * @return Response
     */
    public function renderResponse(string $template, array $parameters): Response
    {
        return $this->engine->renderResponse(
            $template,
            $parameters
        );
    }
}
