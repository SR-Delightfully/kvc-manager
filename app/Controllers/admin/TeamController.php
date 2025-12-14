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

class TeamController extends BaseController
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
        $team_id = $args['id'];

        $team = $this->teamModel->getTeamCleanById($team_id);

        $data = [
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_team_edit' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['team_to_edit' => $team]),
            ];
        return $this->render($response, 'common/layout.php', $data);
    }

    public function update(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $errors = [];

        if (empty($data['station_id'])) {
            $errors[] = "Station must be filled out";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'admin.index');
        }
        try {
            $this->teamModel->updateTeam($data['team_id'], $data);
            FlashMessage::success("Successfully updated station");
            return $this->redirect($request, $response, 'admin.index');
        } catch (\Throwable $th) {
            FlashMessage::error("Update failed. Please try again");
            return $this->redirect($request, $response, 'admin.index');
        }
    }

    public function delete(Request $request, Response $response, array $args): Response {
        $id = $args['id'];

        $this->teamModel->deleteTeam($id);
        FlashMessage::success("Successfully Deleted Team With ID: $id");

        return $this->redirect($request, $response, 'admin.index');
    }

    public function showDelete(Request $request, Response $response, array $args): Response {
        $team_id = $args['id'];

        $team = $this->teamModel->getTeamById($team_id);

        $data = [
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_team_delete' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['team_to_delete' => $team,]),
            ];
        return $this->render($response, 'common/layout.php', $data);
    }
}

?>
