<?php

declare(strict_types=1);

namespace App\Core\Port\TemplateEngine;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface TemplateEngineInterface
 * @package App\Core\Port\TemplateEngine
 */
interface TemplateEngineInterface
{
    public function exists(string $template): bool;

    public function render(string $template, array $parameters): string;

    public function renderResponse(string $template, array $parameters = [], ResponseInterface $response = null): ResponseInterface;
}
