<?php

declare(strict_types=1);

/**
 * This file contains the routes for the web application.
 */

use App\Helpers\DateTimeHelper;
use App\Controllers\admin\ProgressController;
use App\Controllers\admin\UsersController;
use App\Controllers\admin\ColourController;
use App\Controllers\admin\ProductVariantController;
use App\Controllers\admin\AdminDashboardController;
use App\Controllers\AuthController;
use App\Controllers\admin\ProductController;
use App\Controllers\WorkLogController;
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

    //* NOTE: Route naming pattern: [controller_name].[method_name]
    $app->get('/', [HomeController::class, 'index'])->setName('home.index');
    //  $app->get('/', [AboutController::class, 'handleAboutWebService']); // From Aya's version

    /** ⬆ SEE ABOVE ⬆*/
    $app->get('/home', [HomeController::class, 'index'])->setName('home.index');

    // 'Login'/'Signup' routes:
    /** This route uses the LoginController to display the loginView. This page is used for existing users to login and access the web application.*/
    $app->get('/login', [LoginController::class, 'index'])->setName('login.index');
    $app->post('/login', [AuthController::class, 'login']);

    /** This route uses the RegisterController to display the registerView. This page is used to display the form in which a user can use to sign up to the web application */
    $app->get('/register', [RegisterController::class, 'index'])->setName('register.index');
    $app->post('/register', [AuthController::class, 'register']);

    /** Routing for 2FA and logout */
    $app->get('/2fa', [AuthController::class, 'showTwoFactorForm'])->setName('auth.2fa');
    $app->post('/2fa', [AuthController::class, 'verifyTwoFactor']);
    $app->get('/logout', [AuthController::class, 'logout'])->setName('auth.logout');

    // 'Work Log' routes:
    /** This route s used to display components necessary for the employee to input their data. */
    $app->group('/work', function($work){
        $work->get('', [WorkController::class, 'index'])->setName('work.index');
        $work->post('', [WorkController::class, 'store']);
        $work->get('{id}', [WorkController::class, 'edit'])->setName('work.edit');
        $work->post('{id}', [WorkController::class, 'update']);
    });

    // 'Data & Progress' routes:
    /** This route uses the ProgressController to display the dataView. This page is used to display various widgets to show various data visually. */
    $app->get('/progress', [ProgressController::class, 'today'])->setName('data.index');
    $app->get('/progress/all-time', [ProgressController::class, 'allTime'])->setName('admin.db.progress.allTime');

    // 'Time & Attendance' routes:
    /** This route uses the TimeController to display the TimeView. This page is used to keep track of the employees scheduling.*/
    $app->get('/time', [TimeController::class, 'index'])->setName('time.index');

    // 'Settings' routes:
    /** This route uses the SettingsController to display the SettingsView. This page will offer various settings for the user to customize their experience. */
    $app->group('/settings', function ($settings) {
        $settings->get('', [SettingsController::class, 'index'])->setName('settings.index');
        $settings->post('', [SettingsController::class, 'store']);
        $settings->get('/edit', [SettingsController::class, 'edit'])->setName('settings.edit');
        $settings->post('/edit', [SettingsController::class, 'update']);
    });

    /** This route uses the AdmimnController to display the adminView.
     * This view consists of the admin panel, where oly users with the admin role can go to interact with the database and manage their employees.  */
    $app->group('/admin', function ($admin) {
        $admin->get('', [AdminController::class, 'index'])->setName('admin.index');

            $admin->group('/product', function ($product) {
                $product->get('', [ProductController::class, 'index'])->setName('admin.db.product.index');
                $product->get('/create', [ProductController::class, 'create'])->setName('admin.db.product.create');
                $product->post('', [ProductController::class, 'store'])->setName('admin.db.product.store');
                $product->get('{id}', [ProductController::class, 'show'])->setName('admin.db.product.show');
                $product->get('{id}/edit', [ProductController::class, 'edit'])->setName('admin.db.product.edit');
                $product->get('{id}/delete', [ProductController::class, 'delete'])->setName('admin.db.product.delete');
                $product->post('{id}', [ProductController::class, 'update'])->setName('admin.db.product.update');
            });

            $admin->group('/variant', function ($variant) {
                $variant->get('', [ProductVariantController::class, 'index'])->setName('admin.db.variant.index');
                $variant->get('/create', [ProductVariantController::class, 'create'])->setName('admin.db.variant.create');
                $variant->post('', [ProductVariantController::class, 'store'])->setName('admin.db.variant.store');
                $variant->get('{id}', [ProductVariantController::class, 'show'])->setName('admin.db.variant.show');
                $variant->get('{id}/edit', [ProductVariantController::class, 'edit'])->setName('admin.db.variant.edit');
                $variant->get('{id}/delete', [ProductVariantController::class, 'delete'])->setName('admin.db.variant.delete');
                $variant->post('{id}', [ProductVariantController::class, 'update'])->setName('admin.db.variant.update');
            });

            $admin->group('/colour', function($colour) {
                $colour->get('', [ColourController::class, 'index'])->setName('admin.db.colour.index');
                $colour->get('/create', [ColourController::class, 'create'])->setName('admin.db.colour.create');
                $colour->post('', [ColourController::class, 'store'])->setName('admin.db.colour.store');
                $colour->get('{id}', [ColourController::class, 'show'])->setName('admin.db.colour.show');
                $colour->get('{id}/edit', [ColourController::class, 'edit'])->setName('admin.db.colour.edit');
                $colour->get('{id}/delete', [ColourController::class, 'delete'])->setName('admin.db.colour.delete');
                $colour->post('{id}', [ColourController::class, 'update'])->setName('admin.db.colour.update');
            });

            $admin->group('/users', function($users) {
                $users->get('', [UsersController::class, 'index'])->setName('admin.db.users.index');
                $users->get('/create', [UsersController::class, 'create'])->setName('admin.db.users.create');
                $users->post('', [UsersController::class, 'store'])->setName('admin.db.users.store');
                $users->get('{id}', [UsersController::class, 'show'])->setName('admin.db.users.show');
                $users->get('{id}/edit', [UsersController::class, 'edit'])->setName('admin.db.users.edit');
                $users->get('{id}/delete', [UsersController::class, 'delete'])->setName('admin.db.users.delete');
                $users->post('{id}', [UsersController::class, 'update'])->setName('admin.db.users.update');
            });
    });

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
