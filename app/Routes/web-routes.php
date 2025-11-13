<?php
declare(strict_types=1);

/**
 * This file contains the routes for the web application.
 */

// Controller Imports:
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\AuthController;
use App\Controllers\RegisterController;
use App\Controllers\WorkController;
use App\Controllers\ScheduleController;
use App\Controllers\ReportsController;
use App\Controllers\SettingsController;
use App\Controllers\ProductController;
use App\Controllers\ProductVariantController;
use App\Controllers\ColourController;
use App\Controllers\UsersController;
use App\Helpers\DateTimeHelper;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return static function (Slim\App $app): void {

    // Authentication Routes:
    $app->group('/auth', function ($auth) {
        // Login/Logout:
        /** This route uses the LoginController to display the loginView. This page is used for existing users to login and access the web application.*/
        $auth->get('/login', [LoginController::class, 'index'])->setName('auth.login');
        $auth->post('/login', [AuthController::class, 'login']);

        /** This route uses the LogoutController to sign out a user, removing their access from the applications general routes and admin routes.*/
        $auth->get('/logout', [AuthController::class, 'logout'])->setName('auth.logout');

        // Registration:
        /** This route uses the RegisterController to display the registerView. This page is used to display the form in which a user can use to sign up to the web application */
        $auth->get('/register', [RegisterController::class, 'index'])->setName('auth.register');
        $auth->post('/register', [AuthController::class, 'register']);

        // 2FA:
        $auth->get('/2fa', [AuthController::class, 'showTwoFactorForm'])->setName('auth.2fa');
        $auth->post('/2fa', [AuthController::class, 'verifyTwoFactor']);
    });
   
    // General Routes / Employee View:
    $app->group('/', function ($app) {
        
        /** These routes use the HomeController to display the homeView. This page displays a dashboard that consistes of many widgets that will help the user navigate to other pages in the application. */
        $app->get('', [HomeController::class, 'index'])->setName('dashboard.index');

        $app->get('home', [HomeController::class, 'index']);

        /** This route uses the WorkController to display the workView. This page is used to display components necessary for the employee to interact with the database indirectly. */
        $app->get('work', [WorkController::class, 'index']);
        $app->get('work/create', [WorkController::class, 'store']);  
        $app->post('work/update[/{id}]', [WorkController::class, 'update']); 
        $app->get('work/{id}/edit', [WorkController::class, 'edit']); 
        $app->get('work/{id}/delete', [WorkController::class, 'delete']); 


        /** This route uses the ScheduleController to display the scheduleView. This page is used to keep track of the employes shifts and teams.*/
        $app->get('schedule', [ScheduleController::class, 'index'])->setName('schedule.index');

        /** This route uses the ReportsController to display the reportsView. This page is used to display various widgets to show various data visually. */
        $app->get('reports', [ReportsController::class, 'index'])->setName('reports.index');

        /** This route uses the SettingsController to display the SettingsView. This page will offer various settings for the user to customize their experience. */
        $app->get('settings', [SettingsController::class, 'index'])->setName('settings.index');
    });

    // Admin Routes (User must be signed in, and have an admin role to access these routes):
    /** These routes are used to interact dierctly with the database from the Admin Panel */
    $app->group('/admin', function ($api) {
        $api->group('/products', function ($product) {
            $product->get('', [ProductController::class, 'index'])->setName('admin.db.product.index');
            $product->get('/create', [ProductController::class, 'create'])->setName('admin.db.product.create');
            $product->post('', [ProductController::class, 'store'])->setName('admin.db.product.store');
            $product->get('/{id}', [ProductController::class, 'show'])->setName('admin.db.product.show');
            $product->get('/{id}/edit', [ProductController::class, 'edit'])->setName('admin.db.product.edit');
            $product->get('/{id}/delete', [ProductController::class, 'delete'])->setName('admin.db.product.delete');
            $product->post('/{id}', [ProductController::class, 'update'])->setName('admin.db.product.update');
        });

        $api->group('/variants', function ($variant) {
            $variant->get('', [ProductVariantController::class, 'index'])->setName('admin.db.variant.index');
            $variant->get('/create', [ProductVariantController::class, 'create'])->setName('admin.db.variant.create');
            $variant->post('', [ProductVariantController::class, 'store'])->setName('admin.db.variant.store');
            $variant->get('/{id}', [ProductVariantController::class, 'show'])->setName('admin.db.variant.show');
            $variant->get('/{id}/edit', [ProductVariantController::class, 'edit'])->setName('admin.db.variant.edit');
            $variant->get('/{id}/delete', [ProductVariantController::class, 'delete'])->setName('admin.db.variant.delete');
            $variant->post('/{id}', [ProductVariantController::class, 'update'])->setName('admin.db.variant.update');
        });

        $api->group('/colours', function ($colour) {
            $colour->get('', [ColourController::class, 'index'])->setName('admin.db.colour.index');
            $colour->get('/create', [ColourController::class, 'create'])->setName('admin.db.colour.create');
            $colour->post('', [ColourController::class, 'store'])->setName('admin.db.colour.store');
            $colour->get('/{id}', [ColourController::class, 'show'])->setName('admin.db.colour.show');
            $colour->get('/{id}/edit', [ColourController::class, 'edit'])->setName('admin.db.colour.edit');
            $colour->get('/{id}/delete', [ColourController::class, 'delete'])->setName('admin.db.colour.delete');
            $colour->post('/{id}', [ColourController::class, 'update'])->setName('admin.db.colour.update');
        });

        $api->group('/users', function ($user) {
            $user->get('', [UsersController::class, 'index'])->setName('admin.db.users.index');
            $user->get('/create', [UsersController::class, 'create'])->setName('admin.db.users.create');
            $user->post('', [UsersController::class, 'store'])->setName('admin.db.users.store');
            $user->get('/{id}', [UsersController::class, 'show'])->setName('admin.db.users.show');
            $user->get('/{id}/edit', [UsersController::class, 'edit'])->setName('admin.db.users.edit');
            $user->get('/{id}/delete', [UsersController::class, 'delete'])->setName('admin.db.users.delete');
            $user->post('/{id}', [UsersController::class, 'update'])->setName('admin.db.users.update');
        });
    });

    // Ping Route:
      $app->get('/ping', function (Request $request, Response $response, $args) {

        $payload = [
            "greetings" => "Reporting! Hello there!",
            "now" => DateTimeHelper::now(DateTimeHelper::Y_M_D_H_M),
        ];
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR));
        return $response->withHeader('Content-Type');
    });
   
    // Error Route: 
    /** This route is used to display error messages if the user goes to the wrong sub-directory.*/
     $app->get('/error', function (Request $request, Response $response, $args) {
        throw new \Slim\Exception\HttpNotFoundException($request, "Something went wrong");
    });
};
