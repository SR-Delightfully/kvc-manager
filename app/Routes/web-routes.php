<?php

declare(strict_types=1);

/**
 * This file contains the routes for the web application.
 */

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\WorkController;
use App\Controllers\DataController;
use App\Controllers\TimeController;
use App\Controllers\SettingsController;
use App\Controllers\AdminController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


return static function (Slim\App $app): void {
    // Author: Sabrina
    // Routes________________________________//
    // 'Home' routes:
    /** This route uses the HomeController to display the homeView. This page is used to display a dashboard of widgets that will lead to other pages in the application. */
    $app->get('/', [HomeController::class, 'index'])
        ->setName('home.index');
    //  $app->get('/', [AboutController::class, 'handleAboutWebService']); // From Aya's version

    /** ⬆ SEE ABOVE ⬆*/
    $app->get('/home', [HomeController::class, 'index'])
        ->setName('home.index');
  $app->get('/auth', function ($request, $response, $args) {
    include __DIR__ . '/../Views/auth/registrationView.php';
    return $response;
});

    // 'Login'/'Signup' routes:
    /** This route uses the LoginController to display the loginView. This page is used for existing users to login and access the web application.*/
    $app->get('/login', [LoginController::class, 'index'])
        ->setName('login.index');
   
    /** This route uses the RegisterController to display the registerView. This page is used to display the form in which a user can use to sign up to the web application */
    $app->get('/register', [RegisterController::class, 'index'])
        ->setName('register.index');

    // 'Work Log' routes:
    /** This route uses the WorkController to display the workView. This page is used to display components necessary for the employee to input their data. */
    $app->get('/work', [WorkController::class, 'index'])
        ->setName('work.index');

    // 'Data & Progress' routes:
    /** This route uses the DataController to display the dataView. This page is used to display various widgets to show various data visually. */
    $app->get('/progress', [DataController::class, 'index'])
        ->setName('data.index');

    // 'Time & Attendance' routes:
    /** This route uses the TimeController to display the TimeView. This page is used to keep track of the employes scheduling.*/
    $app->get('/time', [TimeController::class, 'index'])
        ->setName('time.index');
        
    // 'Settings' routes:
    /** This route uses the SettingsController to display the SettingsView. This page will offer various settings for the user to customize their experience. */
     $app->get('/settings', [SettingsController::class, 'index'])
        ->setName('settings.index');

    /** This route uses the AdmimnController to display the adminView. 
     * This view consists of the admin panel, where oly users with the admin role can go to interact with the database and manage their employees.  */
    $app->get('/admin', [AdminController::class, 'index'])
        ->setName('admin.index');

    // /** This route is used to display error messages if the user goes to the wrong sub-directory.*/
    // $app->get('/error', function (Request $request, Response $response, $args) {
    //     throw new \Slim\Exception\HttpNotFoundException($request, "Something went wrong");
    // });

    // Author: Aya
     //* ROUTE: GET /ping
    $app->get('/ping', function (Request $request, Response $response, $args) {

        $payload = [
            "greetings" => "Reporting! Hello there!",
            "now" => DateTimeHelper::now(DateTimeHelper::Y_M_D_H_M),
        ];
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR));
        return $response;
    });
    // Example route to test error handling.
    $app->get('/error', function (Request $request, Response $response, $args) {
        throw new \Slim\Exception\HttpNotFoundException($request, "Something went wrong");
    });
};
