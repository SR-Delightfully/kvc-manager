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

class AdminAuthMiddleware implements MiddlewareInterface
{
    /**
     * Process the request - check if user is authenticated AND is an admin.
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $authenticated = UserContext::isLoggedIn();
        $role = UserContext::getRole();

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

        if (!$authenticated) {
            FlashMessage::error("Please log in to access the admin panel.");
            $url = $routeParser->urlFor('login.index');
            return $psr17Factory->createResponse(302)->withHeader('Location', $url);
        }

        if ($role !== 'admin') {
            FlashMessage::error("Access denied. Admin privileges required.");
            $url = $routeParser->urlFor('dashboard');
            return $psr17Factory->createResponse(302)->withHeader('Location', $url);
        }

        return $handler->handle($request);
    }
}
