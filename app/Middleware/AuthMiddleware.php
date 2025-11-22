<?php

namespace App\Middleware;

use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;
use App\Helpers\UserContext;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * Process the request - check if user is authenticated.
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $isAuthenticated = UserContext::isLoggedIn();

        if (!$isAuthenticated) {
            FlashMessage::error("Login to access this page");

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $loginUrl = $routeParser->urlFor('login.index');

            $psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
            return $psr17Factory->createResponse(302)->withHeader('Location', $loginUrl);
        }

        return $handler->handle($request);
    }
}
