<?php

declare(strict_types=1);

/**
 * This file contains the routes for the web application.
 */

use App\Controllers\admin\ProductTypeController;
use App\Helpers\DateTimeHelper;
use App\Controllers\admin\UsersController;
use App\Controllers\admin\ColourController;
use App\Controllers\admin\ProductVariantController;
use App\Controllers\AuthController;
use App\Controllers\admin\ProductController;
use App\Controllers\HomeController;
use App\Controllers\WorkController;
use App\Controllers\SettingsController;
use App\Controllers\AdminController;
use App\Controllers\ReportsController;
use App\Controllers\ScheduleController;
use App\Controllers\admin\PalletController;
use App\Controllers\admin\ShiftController;

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
    $app->get('/login', [AuthController::class, 'index'])->setName('login.index');
    $app->post('/login', [AuthController::class, 'login']);

    /** This route uses the RegisterController to display the registerView. This page is used to display the form in which a user can use to sign up to the web application */
    $app->get('/register', [AuthController::class, 'index'])->setName('register.index');
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

    // 'Reports' routes:
    /** This route uses the ProgressController to display the dataView. This page is used to display various widgets to show various data visually. */
    $app->get('/reports', [ReportsController::class, 'today'])->setName('data.index');
    $app->get('/reports/all-time', [ReportsController::class, 'allTime'])->setName('admin.db.progress.allTime');

    // 'Scheduling' routes:
    /** This route uses the ScheduleController to display the Scheduling for admins. This page is used to keep track of the employees scheduling.*/
    $app->group('/schedule', function ($schedule) {
        $schedule->get('', [ScheduleController::class, 'index'])->setName('schedule.index');
        $schedule->get('/data', [ScheduleController::class, 'fetchForDate'])->setName('schedule.data');
        $schedule->post('', [ScheduleController::class, 'store']);
        $schedule->get('/message', [ScheduleController::class, 'message'])->setName('schedule.message');
        $schedule->post('/message', [ScheduleController::class, 'sendSMS']);
    });

    $app->group('/report', function ($report) {
        $report->get('', [ReportsController::class, 'index'])->setName('reports.index');
    });

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
                $product->get('', [ProductController::class, 'index'])->setName('admin.product.index');
                $product->post('', [ProductController::class, 'store'])->setName('admin.product.store');
                $product->get('{id}/edit', [ProductController::class, 'edit'])->setName('admin.product.edit');
                $product->get('{id}/delete', [ProductController::class, 'delete'])->setName('admin.product.delete');
                $product->post('{id}', [ProductController::class, 'update'])->setName('admin.product.update');
            });

            $admin->group('/variant', function ($variant) {
                $variant->get('', [ProductVariantController::class, 'index'])->setName('admin.variant.index');
                $variant->post('', [ProductVariantController::class, 'store'])->setName('admin.variant.store');
                $variant->get('{id}/edit', [ProductVariantController::class, 'edit'])->setName('admin.variant.edit');
                $variant->get('{id}/delete', [ProductVariantController::class, 'delete'])->setName('admin.variant.delete');
                $variant->post('{id}', [ProductVariantController::class, 'update'])->setName('admin.variant.update');
            });

            $admin->group('/colour', function($colour) {
                $colour->get('', [ColourController::class, 'index'])->setName('admin.colour.index');
                $colour->post('', [ColourController::class, 'store'])->setName('admin.colour.store');
                $colour->get('{id}/edit', [ColourController::class, 'edit'])->setName('admin.colour.edit');
                $colour->get('{id}/delete', [ColourController::class, 'delete'])->setName('admin.colour.delete');
                $colour->post('{id}', [ColourController::class, 'update'])->setName('admin.colour.update');
            });

            $admin->group('/users', function($users) {
                $users->get('', [UsersController::class, 'index'])->setName('admin.users.index');
                $users->post('', [UsersController::class, 'store'])->setName('admin.users.store');
                $users->get('{id}', [UsersController::class, 'show'])->setName('admin.users.show');
                $users->get('{id}/edit', [UsersController::class, 'edit'])->setName('admin.users.edit');
                $users->get('{id}/delete', [UsersController::class, 'delete'])->setName('admin.users.delete');
                $users->post('{id}', [UsersController::class, 'update'])->setName('admin.users.update');
            });

            $admin->group('/type', function($type) {
                $type->get('', [ProductTypeController::class, 'index'])->setName('admin.type.index');
                $type->post('', [ProductTypeController::class, 'store'])->setName('admin.type.store');
                $type->get('{id}/edit', [ProductTypeController::class, 'edit'])->setName('admin.type.edit');
                $type->get('{id}/delete', [ProductTypeController::class, 'delete'])->setName('admin.type.delete');
                $type->post('{id}', [ProductTypeController::class, 'update'])->setName('admin.type.update');
            });

            $admin->group('/pallet', function($pallet) {
                $pallet->get('', [PalletController::class, 'index'])->setName('admin.pallet.index');
                $pallet->post('', [PalletController::class, 'store'])->setName('admin.pallet.store');
                $pallet->get('{id}/edit', [PalletController::class, 'edit'])->setName('admin.pallet.edit');
                $pallet->get('{id}/delete', [PalletController::class, 'delete'])->setName('admin.pallet.delete');
                $pallet->post('{id}', [PalletController::class, 'update'])->setName('admin.pallet.update');
            });

            $admin->group('/shift', function($shift) {
                $shift->get('', [ShiftController::class, 'index'])->setName('admin.shift.index');
                $shift->post('', [ShiftController::class, 'store'])->setName('admin.shift.store');
                $shift->get('{id}/edit', [ShiftController::class, 'edit'])->setName('admin.shift.edit');
                $shift->get('{id}/delete', [ShiftController::class, 'delete'])->setName('admin.shift.delete');
                $shift->post('{id}', [ShiftController::class, 'update'])->setName('admin.shift.update');
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
