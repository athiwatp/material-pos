<?php

namespace app\routing\middleware;

use Closure;

use mako\http\Request;
use mako\http\Response;
use mako\http\routing\middleware\MiddlewareInterface;
use mako\auth\Gatekeeper;

class PassthroughMiddleware implements MiddlewareInterface
{
    protected $gatekeeper;

    public function __construct(Gatekeeper $gatekeeper)
    {
        $this->gatekeeper = $gatekeeper;
    }

    public function execute(Request $request, Response $response, Closure $next): Response
    {
        return $next($request, $response);
    }
}