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

    //useless
    public function index(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderIndexView.php');
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

    public function showDelete(Request $request, Response $response, array $args): Response {
        $user_id = $args['id'];

        $user = $this->userModel->getUserById($user_id);

        $data = [
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_user_delete' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['user_to_delete' => $user,]),
            ];
        return $this->render($response, 'admin/databaseView.php', $data);
    }

    public function search(Request $request, Response $response, array $args): Response
    {
        $data = $request->getQueryParams();
        $q = $data['q'] ?? "";
        $role = $data['user_role'] ?? null;
        $status = $data['user_status'] ?? null;

        if (strlen($q) > 100){
            $q = substr($q, 100);
        }

        $users = $this->userModel->search($q, $role, $status);

        $data = [
            'success' => true,
            'count' => count($users),
            'query' => $q,
            'users' => $users,
        ];

        $payload = json_encode($data, JSON_UNESCAPED_UNICODE);

        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}

?>
