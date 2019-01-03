<?php

declare(strict_types=1);

/*
 * This file is part of the Explicit Architecture POC,
 * which is created on top of the Symfony Demo application.
 *
 * (c) Herberto Graça <herberto.graca@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\tests\UnitTest\Infrastructure\TemplateEngine\Twig;

use App\Core\Port\TemplateEngine\TemplateEngineInterface;
use App\Infrastructure\TemplateEngine\Twig\TemplateEngine;
use DateTime;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zend\Diactoros\Response;

/**
 * @medium
 */
final class TemplateEngineIntegrationTest extends WebTestCase
{
    private const TEMPLATE_1 = '@TestCase/Infrastructure/TemplateEngine/Twig/test1.html.twig';
    private const TEMPLATE_2 = '@TestCase/Infrastructure/TemplateEngine/Twig/test2.html.twig';

    /**
     * @var TemplateEngine
     */
    private $templateEngine;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::$kernel->getContainer();
        $container = self::$container;

        $this->templateEngine = $container->get(TemplateEngineInterface::class);
    }

    public function provideTemplates(): array
    {
        return [
            [self::TEMPLATE_1, true],
            ['@TestCase/unexisting_test.html.twig', false],
        ];
    }

    /**
     * @test
     * @dataProvider provideViewModelAndExpectedResult
     *
     * @throws ReflectionException
     */
    public function render(string $template, array $parameters, string $expectedHtml): void
    {
        self::assertSame(
            $expectedHtml,
            trim($this->templateEngine->render($template, $parameters))
        );
    }

    public function provideViewModelAndExpectedResult(): array
    {
        return [
            [self::TEMPLATE_1, ['var1' => 'a', 'var2' => 'b'], 'a test template with a b'],
            [
                self::TEMPLATE_2,
                [ "array" => [0, 1], "string" => 'string', "get" => 42, "object" => new DateTime('2018-04-13')],
                'a test template with -0--1- string 42 April 13, 2018 00:00',
            ],
        ];
    }

    /**
     * @test
     *
     * @throws ReflectionException
     */
    public function renderResponse_with_a_base_response(): void
    {
        $status = 599;
        $originalResponse = (new Response())
            ->withStatus($status)
            ->withHeader('a', 'b')
            ->withHeader('c', ['d', 'e']);

        $resultResponse = $this->templateEngine->renderResponse(
            self::TEMPLATE_1,
            ['var1' => 'a', 'var2' => 'b'],
            $originalResponse
        );

        self::assertSame($status, $resultResponse->getStatusCode());
        self::assertSame(['b'], $resultResponse->getHeader('a'));
        self::assertSame(['d', 'e'], $resultResponse->getHeader('c'));
        self::assertSame('a test template with a b', trim($resultResponse->getBody()->getContents()));
    }

    /**
     * @test
     *
     * @throws ReflectionException
     */
    public function renderResponse_without_a_base_response(): void
    {
        $resultHtml = $this->templateEngine->renderResponse(self::TEMPLATE_1, ['var1' => 'a', 'var2' => 'b'])
            ->getBody()
            ->getContents();

        self::assertSame('a test template with a b', trim($resultHtml));
    }
}
