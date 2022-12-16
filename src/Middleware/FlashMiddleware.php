<?php

namespace Neoflow\Flash\Middleware;

use Neoflow\Flash\Exception\FlashException;
use Neoflow\Flash\FlashAwareInterface;
use Neoflow\Flash\FlashAwareTrait;
use Neoflow\Flash\FlashInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class FlashMiddleware implements MiddlewareInterface, FlashAwareInterface
{
    use FlashAwareTrait;

    /**
     * Constructor.
     *
     * @param FlashInterface $flash Flash service
     */
    public function __construct(FlashInterface $flash)
    {
        $this->flash = $flash;
    }

    /**
     * {@inheritDoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!isset($_SESSION)) {
            throw new FlashException('Load values from session not possible. Session not started yet.');
        }
        $this->flash->load($_SESSION);

        return $handler->handle($request);
    }
}
