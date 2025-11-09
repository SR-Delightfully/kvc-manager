<?php

declare(strict_types=1);

/**
 * This file contains the routes for the web application.
 */

use App\Controllers\admin\ProgressController;
use App\Controllers\admin\UsersController;
use App\Controllers\admin\ColourController;
use App\Controllers\admin\ProductVariantController;
use App\Controllers\admin\AdminDashboardController;
use App\Controllers\AuthController;
use App\Controllers\admin\ProductController;
use App\Controllers\WorkLogController;
use App\Controllers\HomeController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


return static function (Slim\App $app): void {

    $app->group('/auth', function ($auth) {
        $auth->get('/login', [AuthController::class, 'showLoginForm'])->setName('auth.login');
        $auth->post('/login', [AuthController::class, 'login']);
        $auth->get('/register', [AuthController::class, 'showRegisterForm'])->setName('auth.register');
        $auth->post('/register', [AuthController::class, 'register']);
        $auth->get('/2fa', [AuthController::class, 'showTwoFactorForm'])->setName('auth.2fa');
        $auth->post('/2fa', [AuthController::class, 'verifyTwoFactor']);
        $auth->get('/logout', [AuthController::class, 'logout'])->setName('auth.logout');
    });

    $app->group('/admin', function ($admin) {
        $admin->get('/dashboard', [AdminDashboardController::class, 'index'])->setName("adminDashboard.index");

        $admin->group('/progress', function ($progress) {
            $progress->get('', [ProgressController::class, 'today'])->setName('admin.db.progress.today');
            $progress->get('all-time', [ProgressController::class, 'allTime'])->setName('admin.db.progress.allTime');
        });


        $admin->group('/database', function ($database) {
            $database->get('', [ProductController::class, 'index'])->setName('admin.db.index');

            $database->group('/product', function ($product) {
                $product->get('', [ProductController::class, 'index'])->setName('admin.db.product.index');
                $product->get('/create', [ProductController::class, 'create'])->setName('admin.db.product.create');
                $product->post('', [ProductController::class, 'store'])->setName('admin.db.product.store');
                $product->get('{id}', [ProductController::class, 'show'])->setName('admin.db.product.show');
                $product->get('{id}/edit', [ProductController::class, 'edit'])->setName('admin.db.product.edit');
                $product->get('{id}/delete', [ProductController::class, 'delete'])->setName('admin.db.product.delete');
                $product->post('{id}', [ProductController::class, 'update'])->setName('admin.db.product.update');
            });

            $database->group('/variant', function ($variant) {
                $variant->get('', [ProductVariantController::class, 'index'])->setName('admin.db.variant.index');
                $variant->get('/create', [ProductVariantController::class, 'create'])->setName('admin.db.variant.create');
                $variant->post('', [ProductVariantController::class, 'store'])->setName('admin.db.variant.store');
                $variant->get('{id}', [ProductVariantController::class, 'show'])->setName('admin.db.variant.show');
                $variant->get('{id}/edit', [ProductVariantController::class, 'edit'])->setName('admin.db.variant.edit');
                $variant->get('{id}/delete', [ProductVariantController::class, 'delete'])->setName('admin.db.variant.delete');
                $variant->post('{id}', [ProductVariantController::class, 'update'])->setName('admin.db.variant.update');
            });

            $database->group('/colour', function($colour) {
                $colour->get('', [ColourController::class, 'index'])->setName('admin.db.colour.index');
                $colour->get('/create', [ColourController::class, 'create'])->setName('admin.db.colour.create');
                $colour->post('', [ColourController::class, 'store'])->setName('admin.db.colour.store');
                $colour->get('{id}', [ColourController::class, 'show'])->setName('admin.db.colour.show');
                $colour->get('{id}/edit', [ColourController::class, 'edit'])->setName('admin.db.colour.edit');
                $colour->get('{id}/delete', [ColourController::class, 'delete'])->setName('admin.db.colour.delete');
                $colour->post('{id}', [ColourController::class, 'update'])->setName('admin.db.colour.update');
            });

            $database->group('/users', function($users) {
                $users->get('', [UsersController::class, 'index'])->setName('admin.db.users.index');
                $users->get('/create', [UsersController::class, 'create'])->setName('admin.db.users.create');
                $users->post('', [UsersController::class, 'store'])->setName('admin.db.users.store');
                $users->get('{id}', [UsersController::class, 'show'])->setName('admin.db.users.show');
                $users->get('{id}/edit', [UsersController::class, 'edit'])->setName('admin.db.users.edit');
                $users->get('{id}/delete', [UsersController::class, 'delete'])->setName('admin.db.users.delete');
                $users->post('{id}', [UsersController::class, 'update'])->setName('admin.db.users.update');
            });
        });
    });


    $app->group('/employee', function ($employee) {
        $employee->get('/dashboard', [AdminDashboardController::class, 'index'])->setName("employeeDashboard.index");

        $employee->group('/work-log', function ($workLog) {
            $workLog->get('/', [WorkLogController::class, 'index'])->setName("employee.workLog.index");
            $workLog->get('{id}/edit', [WorkLogController::class, 'edit'])->setName("employee.workLog.edit");
            $workLog->post('{id}', [WorkLogController::class, 'update']);
            $workLog->post('', [WorkLogController::class, 'store']);
        });
    });


    //* NOTE: Route naming pattern: [controller_name].[method_name]
    $app->get('/', [HomeController::class, 'index'])
        ->setName('home.index');

    $app->get('/home', [HomeController::class, 'index'])
        ->setName('home.index');



    // A route to test runtime error handling and custom exceptions.
    $app->get('/error', function (Request $request, Response $response, $args) {
        throw new \Slim\Exception\HttpNotFoundException($request, "Something went wrong");
    });
};
