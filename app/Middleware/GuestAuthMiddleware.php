<?php

namespace App\Middleware;

use App\Helpers\SessionManager;
use App\Helpers\FlashMessage;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;
use App\Helpers\UserContext;

class GuestAuthMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $isAuthenticated = UserContext::isLoggedIn();

        if ($isAuthenticated) {
            FlashMessage::success("You are already logged in.");

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $dashboardUrl = $routeParser->urlFor('dashboard.load');

            $psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
            return $psr17Factory->createResponse(302)
                                ->withHeader('Location', $dashboardUrl);
        }

        return $handler->handle($request);
    }
}
