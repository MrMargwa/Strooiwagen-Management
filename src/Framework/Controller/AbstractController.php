<?php

declare(strict_types=1);

namespace Framework\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Framework\Template\RendererInterface;
use DI\Attribute\Inject;
use Psr\Http\Message\StreamFactoryInterface;

abstract class AbstractController
{
    #[Inject]
    private ResponseFactoryInterface $factory;

    #[Inject]
    private StreamFactoryInterface $streamFactory;

    #[Inject]
    private RendererInterface $renderer;

    protected function render(string $template, array $data = []): ResponseInterface
    {
        $contents = $this->renderer->render($template, $data);

        $stream = $this->streamFactory->createStream($contents);

        $response = $this->factory->createResponse();

        $response = $response->withBody($stream);

        return $response;
    }

    protected function redirect(string $path): ResponseInterface
    {
        $response = $this->factory->createResponse(302);

        $response = $response->withHeader("Location", $path);

        return $response;
    }
}