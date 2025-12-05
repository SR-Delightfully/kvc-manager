<?php

declare(strict_types=1);

/**
 * Web Routes
 */

//middlewares
use App\Middleware\AdminAuthMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestAuthMiddleware;

use App\Helpers\DateTimeHelper;

// Admin Controller Imports
use App\Controllers\admin\ColourController;
use App\Controllers\admin\PalletController;
use App\Controllers\admin\ProductController;
use App\Controllers\admin\ProductTypeController;
use App\Controllers\admin\ProductVariantController;
use App\Controllers\admin\ShiftController;
use App\Controllers\admin\UsersController;
use App\Controllers\admin\AdminDashboardController;

// General Controller Imports
use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\ReportsController;
use App\Controllers\ScheduleController;
use App\Controllers\SettingsController;
use App\Controllers\WorkController;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return static function (App $app): void {

    // Authentication Routes:
    $app->group('', function ($auth) {
        $auth->get('/register', [AuthController::class, 'showRegisterForm'])->setName('register.index');
        $auth->post('/register', [AuthController::class, 'register']);

        $auth->get('/login', [AuthController::class, 'showLoginForm'])->setName('login.index');
        $auth->post('/login', [AuthController::class, 'login']);

        $auth->get('/login/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->setName('login.forgot-password');
        $auth->post('/login/forgot-password', [AuthController::class, 'verifyForgotPassword']);

        $auth->get('/login/new-password', [AuthController::class, 'showNewPasswordForm'])->setName('login.new-password');
        $auth->post('/login/new-password', [AuthController::class, 'verifyNewPassword']);

        $auth->get('/login/forgot-email', [AuthController::class, 'showForgotEmail'])->setName('login.forgot-email');
        $auth->post('/login/forgot-email', [AuthController::class, 'verifyForgotEmail']);

        $auth->get('/login/new-email', [AuthController::class, 'showNewEmail'])->setName('login.new-email');
        $auth->post('/login/new-email', [AuthController::class, 'verifyNewEmail']);

        $auth->get('/login/2fa', [AuthController::class, 'showTwoFactorForm'])->setName('auth.2fa');
        $auth->post('/login/2fa', [AuthController::class, 'verifyTwoFactor']);

        $auth->get('/logout', [AuthController::class, 'logout'])->setName('auth.logout');
    });

    // General / Employee Routes:
    $app->group('', function ($app) {

        // Dashboard
        $app->get('/', [HomeController::class, 'index'])->setName('dashboard.index');
        $app->get('/home', [HomeController::class, 'index']);

        // Work
        $app->group('/work', function ($work) {
            $work->get('', [WorkController::class, 'index'])->setName('work.index');
            $work->get('/create', [WorkController::class, 'create'])->setName('work.create');
            $work->post('', [WorkController::class, 'store'])->setName('work.store');
            $work->get('/{id}/edit', [WorkController::class, 'edit'])->setName('work.edit');
            $work->post('/{id}', [WorkController::class, 'update'])->setName('work.update');
            $work->get('/{id}/delete', [WorkController::class, 'delete'])->setName('work.delete');
        });

        // Schedule
        $app->group('/schedule', function ($schedule) {
            $schedule->get('', [ScheduleController::class, 'index'])->setName('schedule.index');
            $schedule->get('/data', [ScheduleController::class, 'fetchForDate'])->setName('schedule.data');
            $schedule->post('', [ScheduleController::class, 'store']);
            $schedule->get('/message', [ScheduleController::class, 'message'])->setName('schedule.message');
            $schedule->post('/message', [ScheduleController::class, 'sendSMS']);
        });

        // Reports
        $app->group('/reports', function ($reports) {
            $reports->get('', [ReportsController::class, 'index'])->setName('reports.index');
            $reports->get('/today', [ReportsController::class, 'today'])->setName('reports.today');
            $reports->get('/all-time', [ReportsController::class, 'allTime'])->setName('reports.allTime');
        });

        // Settings
        $app->group('/settings', function ($settings) {
            $settings->get('', [SettingsController::class, 'index'])->setName('settings.index');
            $settings->post('', [SettingsController::class, 'store']);
            $settings->get('/edit', [SettingsController::class, 'edit'])->setName('settings.edit');
            $settings->post('/edit', [SettingsController::class, 'update']);
        });
    });

    // Admin Routes:
    $app->group('/admin', function ($admin) {
        //temp route
$admin->get('/temp-db', function ($request, $response) {
    // Path to your view file
    require APP_VIEWS_PATH . '/admin/databaseView.php';
    return $response;
});
//temp route
$admin->get('/temp-dash', function ($request, $response) {
    // Path to your view file
    require APP_VIEWS_PATH . '/admin/dashboardView.php';
    return $response;
});

$admin->get('/temp-settings', function ($request, $response) {
    // Path to your view file
    require APP_VIEWS_PATH . '/admin/settingsView.php';
    return $response;
});
$admin->get('/temp-reports', function ($request, $response) {
    // Path to your view file
    require APP_VIEWS_PATH . '/admin/reportsView.php';
    return $response;
});
$admin->get('/temp-reports2', function ($request, $response) {
    // Path to your view file
    require APP_VIEWS_PATH . '/admin/allTimeReportsView.php';
    return $response;
});

        $admin->get('', [AdminController::class, 'index'])->setName('admin.index');


        // Products
        $admin->group('/product', function ($product) {
            $product->get('', [ProductController::class, 'index'])->setName('admin.product.index');
            $product->post('', [ProductController::class, 'store'])->setName('admin.product.store');
            $product->get('{id}/edit', [ProductController::class, 'edit'])->setName('admin.product.edit');
            $product->get('{id}/delete', [ProductController::class, 'delete'])->setName('admin.product.delete');
            $product->post('{id}', [ProductController::class, 'update'])->setName('admin.product.update');
        });

        // Variants
        $admin->group('/variant', function ($variant) {
            $variant->get('', [ProductVariantController::class, 'index'])->setName('admin.variant.index');
            $variant->post('', [ProductVariantController::class, 'store'])->setName('admin.variant.store');
            $variant->get('{id}/edit', [ProductVariantController::class, 'edit'])->setName('admin.variant.edit');
            $variant->get('{id}/delete', [ProductVariantController::class, 'delete'])->setName('admin.variant.delete');
            $variant->post('{id}', [ProductVariantController::class, 'update'])->setName('admin.variant.update');
        });

        // Colours
        $admin->group('/colour', function ($colour) {
            $colour->get('', [ColourController::class, 'index'])->setName('admin.colour.index');
            $colour->post('', [ColourController::class, 'store'])->setName('admin.colour.store');
            $colour->get('{id}/edit', [ColourController::class, 'edit'])->setName('admin.colour.edit');
            $colour->get('{id}/delete', [ColourController::class, 'delete'])->setName('admin.colour.delete');
            $colour->post('{id}', [ColourController::class, 'update'])->setName('admin.colour.update');
        });

        // Users
        $admin->group('/users', function ($users) {
            $users->get('', [UsersController::class, 'index'])->setName('admin.users.index');
            $users->post('', [UsersController::class, 'store'])->setName('admin.users.store');
            $users->get('{id}', [UsersController::class, 'show'])->setName('admin.users.show');
            $users->get('{id}/edit', [UsersController::class, 'edit'])->setName('admin.users.edit');
            $users->get('{id}/delete', [UsersController::class, 'delete'])->setName('admin.users.delete');
            $users->post('{id}', [UsersController::class, 'update'])->setName('admin.users.update');
        });

        // Types
        $admin->group('/type', function ($type) {
            $type->get('', [ProductTypeController::class, 'index'])->setName('admin.type.index');
            $type->post('', [ProductTypeController::class, 'store'])->setName('admin.type.store');
            $type->get('{id}/edit', [ProductTypeController::class, 'edit'])->setName('admin.type.edit');
            $type->get('{id}/delete', [ProductTypeController::class, 'delete'])->setName('admin.type.delete');
            $type->post('{id}', [ProductTypeController::class, 'update'])->setName('admin.type.update');
        });

        // Pallets
        $admin->group('/pallet', function ($pallet) {
            $pallet->get('', [PalletController::class, 'index'])->setName('admin.pallet.index');
            $pallet->post('', [PalletController::class, 'store'])->setName('admin.pallet.store');
            $pallet->get('{id}/edit', [PalletController::class, 'edit'])->setName('admin.pallet.edit');
            $pallet->get('{id}/delete', [PalletController::class, 'delete'])->setName('admin.pallet.delete');
            $pallet->post('{id}', [PalletController::class, 'update'])->setName('admin.pallet.update');
        });

        // Shifts
        $admin->group('/shift', function ($shift) {
            $shift->get('', [ShiftController::class, 'index'])->setName('admin.shift.index');
            $shift->post('', [ShiftController::class, 'store'])->setName('admin.shift.store');
            $shift->get('{id}/edit', [ShiftController::class, 'edit'])->setName('admin.shift.edit');
            $shift->get('{id}/delete', [ShiftController::class, 'delete'])->setName('admin.shift.delete');
            $shift->post('{id}', [ShiftController::class, 'update'])->setName('admin.shift.update');
        });
    });

    // Ping Route
    $app->get('/ping', function (Request $request, Response $response, $args) {
        $payload = [
            "greetings" => "Reporting! Hello there!",
            "now" => DateTimeHelper::now(DateTimeHelper::Y_M_D_H_M),
        ];
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR));
        return $response->withHeader('Content-Type', 'application/json');
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Error Route
    $app->get('/error', function (Request $request, Response $response, $args) {
        throw new \Slim\Exception\HttpNotFoundException($request, "Something went wrong");
    });
};
