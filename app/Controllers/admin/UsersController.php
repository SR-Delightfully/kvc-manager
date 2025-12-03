<?php

declare(strict_types=1);

namespace App\Controllers\admin;
use App\Controllers\BaseController;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\ProductModel;
use App\Domain\Models\UserModel;
use App\Helpers\AdminDataHelper;
use App\Helpers\UserContext;
use App\Helpers\FlashMessage;

class UsersController extends BaseController
{
    public function __construct(
        Container $container,
        private AdminDataHelper $adminDataHelper,
    private UserModel $userModel)
    {
        parent:: __construct($container);
    }

   public function index(Request $request, Response $response, array $args): Response
    {
        $userCount = $this->userModel->countUsers();

        return $this->render($response, 'admin/orderIndexView.php', [
            'userCount' => $userCount
        ]);
    }

    //useless
    public function show(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderShowView.php');
    }
    //useless
    public function create(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryCreateView.php');
    }

    //useless?
    public function store(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryCreateView.php');
    }

    public function edit(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryEditView.php');
    }

    public function update(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryEditView.php');
    }

    //sets the user status to terminated
    public function delete(Request $request, Response $response, array $args): Response {
        $id = $args['id'];

        $this->userModel->terminateUser($id);
        FlashMessage::success("Successfully Terminated User With ID: $id");

        return $this->redirect($request, $response, 'admin.index');
    }
}

?>
