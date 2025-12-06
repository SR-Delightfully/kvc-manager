<?php

declare(strict_types=1);

namespace App\Controllers\admin;
use App\Controllers\BaseController;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\ProductModel;
use App\Domain\Models\TeamModel;
use App\Helpers\UserContext;
use App\Helpers\AdminDataHelper;
use App\Helpers\FlashMessage;

class TeamMemberController extends BaseController
{
    public function __construct(
        Container $container,
    private TeamModel $teamModel, private AdminDataHelper $adminDataHelper)
    {
        parent:: __construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderIndexView.php');
    }

    public function show(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderShowView.php');
    }

    public function create(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryCreateView.php');
    }

    public function store(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryCreateView.php');
    }

    public function edit(Request $request, Response $response, array $args): Response {
        $user_id = $args['user_id'];
        $team_id = $args['team_id'];

        $product = $this->teamModel->getTeamMemberByTeamUser($team_id, $user_id);

        $data = [
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_team_member_edit' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['team_to_edit' => $product]),
            ];
        return $this->render($response, 'admin/databaseView.php', $data);
    }

    public function update(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryEditView.php');
    }

    public function delete(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryIndexView.php');
    }
}

?>
