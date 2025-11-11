<?php

declare(strict_types=1);

namespace App\Controllers\admin;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\ProductModel;
use App\Domain\Models\ScheduleModel;
use App\Controllers\BaseController;

class ProgressController extends BaseController
{
    public function __construct(
        Container $container,
    private ScheduleModel $scheduleModel)
    {
        parent:: __construct($container);
    }

    public function today(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderIndexView.php');
    }

    public function allTime(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderShowView.php');
    }
}

?>
