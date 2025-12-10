<?php

declare(strict_types=1);

use App\Middleware\ExceptionMiddleware;
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

return function (App $app) {
    //TODO: Add your middleware here.

    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();

    $app->add(function (Request $request, RequestHandler $handler): Response {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $handler->handle($request);
    });
    //!NOTE: the error handling middleware MUST be added last.
    //!NOTE: You can add override the default error handler with your custom error handler.
    //* For more details, refer to Slim framework's documentation.
    // Add your middleware here.
    // Start the session at the application level.
    //$app->add(SessionStartMiddleware::class);
    $app->add(ExceptionMiddleware::class);
};
