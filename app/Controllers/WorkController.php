<?php 
declare(strict_types=1); 

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\PalletModel;
use App\Domain\Models\ProductModel;
use App\Helpers\UserContext;

class WorkController extends BaseController {
    public function __construct( Container $container, private PalletModel $palletModel) {
        parent::__construct($container);
        }

    public function index(Request $request, Response $response, array $args): Response
    {
        // $currentUser = UserContext::getCurrentUser();
        // if (!$currentUser) {
        // return $response->withHeader('Location', '/login')->withStatus(302);
        // }
        $currentUser = UserContext::getCurrentUser();
        $userId = $currentUser['id'] ?? null;

        $logs = UserContext::isAdmin()
            ? $this->palletModel->getAll()
            : $this->palletModel->getByUser($userId);

        $data = [
            'page_title' => 'Welcome to KVC Manager',
            'contentView' => APP_VIEWS_PATH . '/pages/workView.php',
            'isSideBarShown' => true,
            'isAdmin' => UserContext::isAdmin(),
            'logs' => $logs,
            'data' => [
                'title' => 'Work',
                'message' => 'Work Page',
            ],
        ];

        return $this->render($response, 'common/layout.php', $data);
    }

    public function edit(Request $request, Response $response, array $args): Response
    {
        $currentUser = UserContext::getCurrentUser();
        $userId = $currentUser['id'] ?? null;

        $log = $this->palletModel->find($args['id']);

        if (!$log) {
            throw new \Slim\Exception\HttpNotFoundException($request, "Log not found");
        }

        if (!UserContext::isAdmin() && $log->user_id !== $userId->id) {
            return $response->withStatus(403, 'Forbidden');
        }

        return $this->render($response, 'admin/orderShowView.php', [
            'log' => $log,
            'isAdmin' => UserContext::isAdmin(),
        ]);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $currentUser = UserContext::getCurrentUser();
        $userId = $currentUser['id'] ?? null;

        $id = $args['id'] ?? null;
        $data = (array)$request->getParsedBody();

        if ($id) {
            $log = $this->palletModel->find($id);

            if (!UserContext::isAdmin() && $log->user_id !== $userId) {
                return $response->withStatus(403, 'Forbidden');
            }

            $this->palletModel->update($id, $data);
        } else {
            $data['user_id'] = $userId;
            $this->palletModel->create($data);
        }

        return $response->withHeader('Location', '/work')->withStatus(302);
    }

    public function store(Request $request, Response $response, array $args): Response
    {
        $data = [
            'log' => null,
            'isAdmin' => UserContext::isAdmin(),
        ];

        return $this->render($response, 'worklog/form.php', $data);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        if (!UserContext::isAdmin()) {
            return $response->withStatus(403, 'Forbidden');
        }

        $id = $args['id'];
        $this->palletModel->delete($id);

        return $response->withHeader('Location', '/work')->withStatus(302);
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'errorView.php');
    }
}
