<?php

declare(strict_types=1);

namespace App\Core\Port\TemplateEngine;

use Symfony\Component\HttpFoundation\Response;

/**
 * Interface TemplateEngineInterface
 * @package App\Core\Port\TemplateEngine
 */
interface TemplateEngineInterface
{
    public function render(string $template, array $parameters): string;

    public function renderResponse(string $template, array $parameters): Response;
}
