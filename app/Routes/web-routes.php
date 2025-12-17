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
use App\Controllers\admin\StationController;
use App\Controllers\admin\TeamController;
use App\Controllers\admin\ToteController;

// General Controller Imports
use App\Controllers\admin\AdminController;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\ReportsController;
use App\Controllers\ScheduleController;
use App\Controllers\SettingsController;
use App\Controllers\WorkController;
use App\Controllers\admin\TeamMemberController;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return static function (App $app): void {

    $app->get("/registration-code", [AuthController::class, 'registrationCode']);
    // Authentication Routes:
    $app->group('', function ($auth) {

        $auth->get('/register', [AuthController::class, 'showRegisterForm'])->setName('register.index');
        $auth->post('/register', [AuthController::class, 'register']);

        $auth->get('/login', [AuthController::class, 'showLoginForm'])->setName('login.index');
        $auth->post('/login', [AuthController::class, 'login']);

        $auth->get('/login/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->setName('login.forgot-password');
        $auth->post('/login/forgot-password', [AuthController::class, 'sendForgotPassword']);
        $auth->post('/login/forgot-password/verify', [AuthController::class, 'verifyForgotPassword']);

        $auth->get('/login/new-password', [AuthController::class, 'showNewPasswordForm'])->setName('login.new-password');
        $auth->post('/login/new-password', [AuthController::class, 'verifyNewPassword']);

        $auth->get('/login/forgot-email', [AuthController::class, 'showForgotEmail'])->setName('login.forgot-email');
        $auth->post('/login/forgot-email', [AuthController::class, 'sendForgotEmail']);

        $auth->get('/login/forgot-email-2fa', [AuthController::class, 'showForgotEmail2fa'])->setName('login.forgot-email.2fa');
        $auth->post('/login/forgot-email-2fa', [AuthController::class, 'verifyForgotEmail']);

        $auth->get('/login/new-email', [AuthController::class, 'showNewEmail'])->setName('login.new-email');
        $auth->post('/login/new-email', [AuthController::class, 'verifyNewEmail']);

        $auth->get('/login/2fa', [AuthController::class, 'showTwoFactorForm'])->setName('auth.2fa');
        $auth->post('/login/2fa', [AuthController::class, 'verifyTwoFactor']);
    }) //->add(GuestAuthMiddleware::class)
    ;

    $app->get('/logout', [AuthController::class, 'logout'])->setName('auth.logout');

    // General / Employee Routes:
    $app->group('', function ($app) {

        // Dashboard
        $app->get('/', [HomeController::class, 'index'])->setName('dashboard.index');
        $app->get('/home', [HomeController::class, 'index'])->setName('dashboard.load');

        //SEARCHING_ROUTES_FOR_ADMIN_PAGE
        $app->get('/api/variants/search', [ProductVariantController::class, 'search'])->setName('api.variants.search');
        $app->get('/api/users/search', [UsersController::class, 'search'])->setName('api.users.search');
        $app->get('/api/products/search', [ProductController::class, 'search'])->setName('api.products.search');
        $app->get('/api/colours/search', [ColourController::class, 'search'])->setName('api.colours.search');

        // Work
        $app->group('/work', function ($work) {
            $work->get('', [WorkController::class, 'index'])->setName('work.index');
            $work->get('/create', [WorkController::class, 'create'])->setName('work.create');
            $work->post('/start', [WorkController::class, 'startSession'])->setName('work.start');
            $work->post('/end', [WorkController::class, 'endSession'])->setName('work.end');
            $work->post('/break/start', [WorkController::class, 'startBreak'])->setName('work.break.start');
            $work->post('/break/end', [WorkController::class, 'endBreak'])->setName('work.break.end');
            $work->get('/search', [WorkController::class, 'search'])->setName('work.search');
            $work->get('/{id}', [WorkController::class, 'show'])->setName('work.show');
            $work->get('/edit/{id}', [WorkController::class, 'edit'])->setName('work.edit');
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
            // $settings->post('/edit', [SettingsController::class, 'updateGeneralInfo'])->setName('user.update');
            $settings->post('/edit', [SettingsController::class, 'updateGeneralInfo'])->setName('settings.update');
        });
    }) //->add(AuthMiddleware::class)
    ;

    // Admin Routes:
    $app->group('/admin', function ($admin) {
        //temp route
        $admin->get('/temp-db', function ($request, $response) {
            // Path to your view file
            // require APP_VIEWS_PATH . '/admin/databaseView.php';
            require APP_VIEWS_PATH . '/pages/adminview.php';
            return $response;
        });
        //temp route
        $admin->get('/temp-dash', function ($request, $response) {
            // Path to your view file
            require APP_VIEWS_PATH . '/admin/dashboardView.php';
            return $response;
        });
        //temp route
        $admin->get('/temp-work', function ($request, $response) {
            // Path to your view file
            require APP_VIEWS_PATH . '/admin/workLogView.php';
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
            $product->get('/edit/{id}', [ProductController::class, 'edit'])->setName('admin.product.edit');
            $product->get('/delete/{id}', [ProductController::class, 'showDelete'])->setName('admin.product.delete.show');
            $product->get('/delete/{id}/do', [ProductController::class, 'delete'])->setName('admin.product.delete');
            $product->post('/edit/{id}', [ProductController::class, 'update'])->setName('admin.product.update');
        });

        // Variants
        $admin->group('/variant', function ($variant) {
            $variant->get('', [ProductVariantController::class, 'index'])->setName('admin.variant.index');
            $variant->post('', [ProductVariantController::class, 'store'])->setName('admin.variant.store');
            $variant->get('/edit/{id}', [ProductVariantController::class, 'edit'])->setName('admin.variant.edit');
            $variant->get('/delete/{id}', [ProductVariantController::class, 'showDelete'])->setName('admin.variant.delete.show');
            $variant->get('/delete/{id}/do', [ProductVariantController::class, 'delete'])->setName('admin.variant.delete');
            $variant->post('/edit/{id}', [ProductVariantController::class, 'update'])->setName('admin.variant.update');
        });

        // Colours
        $admin->group('/colour', function ($colour) {
            $colour->get('', [ColourController::class, 'index'])->setName('admin.colour.index');
            $colour->post('', [ColourController::class, 'store'])->setName('admin.colour.store');
            $colour->get('/edit/{id}', [ColourController::class, 'edit'])->setName('admin.colour.edit');
            $colour->get('/delete/{id}', [ColourController::class, 'showDelete'])->setName('admin.colour.delete.show');
            $colour->get('/delete/{id}/do', [ColourController::class, 'delete'])->setName('admin.colour.delete');
            $colour->post('/edit/{id}', [ColourController::class, 'update'])->setName('admin.colour.update');
        });

        // Users
        $admin->group('/users', function ($users) {
            $users->get('', [UsersController::class, 'index'])->setName('admin.users.index');
            $users->post('', [UsersController::class, 'store'])->setName('admin.users.store');
            $users->get('{id}', [UsersController::class, 'show'])->setName('admin.users.show');
            $users->get('/edit/{id}', [UsersController::class, 'edit'])->setName('admin.users.edit');
            $users->get('/delete/{id}', [UsersController::class, 'showDelete'])->setName('admin.users.delete.show');
            $users->get('/delete/{id}/do', [UsersController::class, 'delete'])->setName('admin.users.delete');
            $users->post('/edit/{id}', [UsersController::class, 'update'])->setName('admin.users.update');
        });

        // Types
        $admin->group('/type', function ($type) {
            $type->get('', [ProductTypeController::class, 'index'])->setName('admin.type.index');
            $type->post('', [ProductTypeController::class, 'store'])->setName('admin.type.store');
            $type->get('/edit/{id}', [ProductTypeController::class, 'edit'])->setName('admin.type.edit');
            $type->get('/delete/{id}', [ProductTypeController::class, 'showDelete'])->setName('admin.type.delete.show');
            $type->get('/delete/{id}/do', [ProductTypeController::class, 'delete'])->setName('admin.type.delete');
            $type->post('/edit/{id}', [ProductTypeController::class, 'update'])->setName('admin.type.update');
        });

        // Pallets
        $admin->group('/pallet', function ($pallet) {
            $pallet->get('', [PalletController::class, 'index'])->setName('admin.pallet.index');
            $pallet->post('', [PalletController::class, 'store'])->setName('admin.pallet.store');
            $pallet->get('/edit/{id}', [PalletController::class, 'edit'])->setName('admin.pallet.edit');
            $pallet->get('/delete/{id}', [PalletController::class, 'showDelete'])->setName('admin.pallet.delete.show');
            $pallet->get('/delete/{id}/do', [PalletController::class, 'delete'])->setName('admin.pallet.delete');
            $pallet->post('/edit/{id}', [PalletController::class, 'update'])->setName('admin.pallet.update');
        });

        $admin->group('/tote', function ($tote) {
            $tote->get('', [ToteController::class, 'index'])->setName('admin.tote.index');
            $tote->post('', [ToteController::class, 'store'])->setName('admin.tote.store');
            $tote->get('/edit/{id}', [ToteController::class, 'edit'])->setName('admin.tote.edit');
            $tote->get('/delete/{id}', [ToteController::class, 'showDelete'])->setName('admin.tote.delete.show');
            $tote->get('/delete/{id}/do', [ToteController::class, 'delete'])->setName('admin.tote.delete');
            $tote->post('/edit/{id}', [ToteController::class, 'update'])->setName('admin.tote.update');
        });

        // TODO MAKE_TEAM_MODEL_AND_CONTROLLERS
        $admin->group('/member', function ($member) {
            $member->get('', [TeamMemberController::class, 'index'])->setName('admin.member.index');
            $member->post('', [TeamMemberController::class, 'store'])->setName('admin.member.store');
            $member->get('/edit/{user_id}/{team_id}', [TeamMemberController::class, 'edit'])->setName('admin.member.edit');
            $member->get('/delete/{user_id}/{team_id}', [TeamMemberController::class, 'showDelete'])->setName('admin.member.delete.show');
            $member->get('/delete/{user_id}/{team_id}/do', [TeamMemberController::class, 'delete'])->setName('admin.member.delete');
            $member->post('/edit/{user_id}/{team_id}', [TeamMemberController::class, 'update'])->setName('admin.member.update');
        });

        $admin->group('/team', function ($team) {
            $team->get('', [TeamController::class, 'index'])->setName('admin.team.index');
            $team->post('', [TeamController::class, 'store'])->setName('admin.team.store');
            $team->get('/edit/{id}', [TeamController::class, 'edit'])->setName('admin.team.edit');
            $team->get('/delete/{id}', [TeamController::class, 'showDelete'])->setName('admin.team.delete.show');
            $team->get('/delete/{id}/do', [TeamController::class, 'delete'])->setName('admin.team.delete');
            $team->post('/edit/{id}', [TeamController::class, 'update'])->setName('admin.team.update');
        });

        //TODO MAKE_STATION_MODEL_AND_CONTROLLERS
        $admin->group('/station', function ($station) {
            $station->get('', [StationController::class, 'index'])->setName('admin.station.index');
            $station->post('', [StationController::class, 'store'])->setName('admin.station.store');
            $station->get('/edit/{id}', [StationController::class, 'edit'])->setName('admin.station.edit');
            $station->get('/delete/{id}', [StationController::class, 'showDelete'])->setName('admin.station.delete.show');
            $station->get('/delete/{id}/do', [StationController::class, 'delete'])->setName('admin.station.delete');
            $station->post('/edit/{id}', [StationController::class, 'update'])->setName('admin.station.update');
        });

        // Shifts
        $admin->group('/shift', function ($shift) {
            $shift->get('', [ShiftController::class, 'index'])->setName('admin.shift.index');
            $shift->post('', [ShiftController::class, 'store'])->setName('admin.shift.store');
            $shift->get('/edit/{id}', [ShiftController::class, 'edit'])->setName('admin.shift.edit');
            $shift->get('/delete/{id}', [ShiftController::class, 'showDelete'])->setName('admin.shift.delete.show');
            $shift->get('/delete/{id}/do', [ShiftController::class, 'delete'])->setName('admin.shift.delete');
            $shift->post('/edit/{id}', [ShiftController::class, 'update'])->setName('admin.shift.update');
        });
    }) //->add(AdminAuthMiddleware::class)
    ;

    // Ping Route
    $app->get('/ping', function (Request $request, Response $response, $args) {
        $payload = [
            "greetings" => "Reporting! Hello there!",
            "now" => DateTimeHelper::now(DateTimeHelper::Y_M_D_H_M),
        ];
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Error Route
    $app->get('/error', function (Request $request, Response $response, $args) {
        throw new \Slim\Exception\HttpNotFoundException($request, "Something went wrong");
    });
};
