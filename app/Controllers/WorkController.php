<?php
declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\PalletModel;
use App\Domain\Models\ProductModel;
use App\Helpers\UserContext;
use App\Domain\Models\WorkLogModel;
use App\Domain\Models\TeamModel;
use App\Domain\Models\StationModel;
use App\Domain\Models\ProductVariantModel;
use App\Helpers\FlashMessage;
use App\Domain\Models\ToteModel;

class WorkController extends BaseController {
    public function __construct( Container $container, private PalletModel $palletModel, private WorkLogModel $workLogModel, private TeamModel $teamModel, private StationModel $stationModel, private ProductVariantModel $productVariantModel, private ToteModel $toteModel) {
        parent::__construct($container);
        }

    public function index(Request $request, Response $response, array $args): Response
    {
        $currentUser = UserContext::getCurrentUser();

        if (UserContext::isAdmin()) {
            $stations = $this->stationModel->getAllStations();
            $station_id = (int)($request->getQueryParams()['station_id'] ?? 1);
            $station = $this->stationModel->getStationById($station_id);
            $pallets = $this->workLogModel->getSelectedWorkLogs($station_id);

            if (!$station) {
                FlashMessage::error('Invalid station selected');
                $station_id = 1;
                $station = $this->stationModel->getStationById(1);
            }

            // determine break state (same logic as employee)
            $show_break_continue = false;
            if (!empty($pallets)) {
                $latest = end($pallets);
                reset($pallets);

                if (!empty($latest['session_id']) &&
                    $this->workLogModel->isOnBreak($latest['session_id'])) {
                    $show_break_continue = true;
                }
            }

            // determine if an open pallet exists
            $show_form_end = false;
            foreach ($pallets as $p) {
                if (empty($p['end_time'])) {
                    $show_form_end = true;
                    break;
                }
            }

            return $this->render($response, 'pages/workView.php', [
                'pallets'            => $pallets,
                'stations'           => $stations,
                'station'            => $station,
                'selectedStationId'  => $station_id,
                'isAdmin'            => true,
                'show_form_end'      => $show_form_end,
                'show_break_continue'=> $show_break_continue,
                'team_members'       => $this->teamModel->getTodayTeamMembersForStation($station_id),
            ]);
        }

        if (UserContext::isEmployee()) {
            $pallets = $this->workLogModel->getCurrentWorkLogs($currentUser['user_id']);
            $team_members = $this->teamModel->getTodayTeamMembersForUser($currentUser['user_id']);
            $station = $this->stationModel->getStationByUserId($currentUser['user_id']);
            $partial = $this->workLogModel->checkPalletizeComplete($currentUser['user_id']);

            $show_break_continue = false;
            if (!empty($pallets)) {
                // get most recent session (getCurrentWorkLogs orders ASC so last item is newest)
                $mostRecent = end($pallets);
                $sessionId = $mostRecent['session_id'] ?? null;
                if ($sessionId && $this->workLogModel->isOnBreak($sessionId)) {
                    $show_break_continue = true;
                }
                // reset internal pointer just in case
                reset($pallets);
            }

            if ($partial) {
                $show_form_end = true;
            } else{
                $show_form_end = false;
            }

            return $this->render($response, 'pages/workView.php', [
                'pallets' => $pallets,
                'team_members' => $team_members,
                'show_form_end' => $show_form_end,
                'station' => $station,
                'isAdmin' => false,
                'show_break_continue' => $show_break_continue,
            ]);
        }


        $data = [
            'page_title' => 'Welcome to KVC Manager',
            'contentView' => APP_VIEWS_PATH . '/pages/workView.php',
            'isSideBarShown' => true,
            'isAdmin' => UserContext::isAdmin(),
            'data' => [
                'title' => 'Work',
                'message' => 'Work Page',
            ],
        ];

        return $this->render($response, 'common/layout.php', $data);
    }

    public function edit(Request $request, Response $response, array $args): Response
    {
        $pallet_id = $args['id'];
        $currentUser = UserContext::getCurrentUser();

        $totes = $this->toteModel->getAllTotes();
        $stations = $this->stationModel->getAllStations();

        $pallet = $this->palletModel->getPalletCompleteById($pallet_id);

        if (UserContext::isAdmin()) {
            $station_id = (int)($request->getQueryParams()['station_id'] ?? 1);

            $pallets = $this->workLogModel->getSelectedWorkLogs($station_id);
            $stations = $this->stationModel->getAllStations();

            return $this->render($response, 'pages/workView.php', [
                'pallets' => $pallets,
                'stations' => $stations,
                'pallet' => $pallet,
                'totes' => $totes,
                'show_pallet_edit' => true,
                'selectedStationId' => $station_id,
                'isAdmin' => true,
            ]);
        }

        if (UserContext::isEmployee()) {
            $pallets = $this->workLogModel->getCurrentWorkLogs($currentUser['user_id']);
            $team_members = $this->teamModel->getTodayTeamMembersForUser($currentUser['user_id']);
            $station = $this->stationModel->getStationByUserId($currentUser['user_id']);
            $partial = $this->workLogModel->checkPalletizeComplete($currentUser['user_id']);


            if ($partial) {
                $show_form_end = true;
            } else{
                $show_form_end = false;
            }

            return $this->render($response, 'pages/workView.php', [
                'pallets' => $pallets,
                'team_members' => $team_members,
                'show_form_end' => $show_form_end,
                'totes' => $totes,
                'stations' => $stations,
                'show_pallet_edit' => true,
                'pallet' => $pallet,
                'station' => $station,
                'isAdmin' => false,
            ]);
        }


        $data = [
            'page_title' => 'Welcome to KVC Manager',
            'contentView' => APP_VIEWS_PATH . '/pages/workView.php',
            'isSideBarShown' => true,
            'isAdmin' => UserContext::isAdmin(),
            'data' => [
                'title' => 'Work',
                'message' => 'Work Page',
            ],
        ];

        return $this->render($response, 'pages/workView.php', $data);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $currentUser = UserContext::getCurrentUser();
        $userId = $currentUser['id'] ?? null;

        $id = $args['id'] ?? null;
        $data = (array)$request->getParsedBody();

        if ($id) {
            $log = $this->palletModel->find($id);

            if (!UserContext::isAdmin() && $log['user_id'] !== $userId) {
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
        $data = $request->getParsedBody();
        $errors = [];




        return $this->redirect($request, $response, 'work.index');
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

    public function search(Request $request, Response $response, array $args): Response
    {
        $currentUser = UserContext::getCurrentUser();
        $user_role = $currentUser['user_role'] ?? null;
        $variants = $this->productVariantModel->getAllVariantsClean();

        if (UserContext::isAdmin()) {
            $station_id = (int)($request->getQueryParams()['station_id'] ?? 1);

            $pallets = $this->workLogModel->getSelectedWorkLogs($station_id);
            $stations = $this->stationModel->getAllStations();

            return $this->render($response, 'pages/workView.php', [
                'pallets' => $pallets,
                'stations' => $stations,
                'selectedStationId' => $station_id,
                'variants' => $variants,
                'show_variant_search' => true,
                'isAdmin' => true,
            ]);
        }

        if (UserContext::isEmployee()) {
            $pallets = $this->workLogModel->getCurrentWorkLogs($currentUser['user_id']);
            $team_members = $this->teamModel->getTodayTeamMembersForUser($currentUser['user_id']);
            $station = $this->stationModel->getStationByUserId($currentUser['user_id']);

            return $this->render($response, 'pages/workView.php', [
                'pallets' => $pallets,
                'team_members' => $team_members,
                'variants' => $variants,
                'station' => $station,
                'show_variant_search' => true,
                'isAdmin' => false,
            ]);
        }


        $data = [
            'page_title' => 'Welcome to KVC Manager',
            'contentView' => APP_VIEWS_PATH . '/pages/workView.php',
            'isSideBarShown' => true,
            'isAdmin' => UserContext::isAdmin(),
            'data' => [
                'title' => 'Work',
                'message' => 'Work Page',
            ],
        ];

        return $this->render($response, 'pages/workView.php', $data);
    }

    public function startSession(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $variant_id = $data['variant_id'] ?? null;
        $batch_number = $data['batch_number'] ?? null;
        $station_id = $data['station_id'] ?? null;
        $errors = [];


        //dd($data);
        if (is_null($variant_id)) {
            FlashMessage::error("Please select a product variant");
            return $this->redirect($request, $response, 'work.index');
        }

        if (is_null($variant_id) || is_null($batch_number) || is_null($station_id)) {
            $errors[] = "Variant, Batch Number, and Station ID must be provided";
        }

        if (strlen($batch_number) !== 5) {
            $errors[] = "Batch Number must be exactly 5 characters long";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'work.index');
        }

        //check if there is already a started pallet
        $user = UserContext::getCurrentUser();
        $bool = $this->workLogModel->checkPalletizeComplete($user['user_id']);

        $user = UserContext::getCurrentUser();

        if (!UserContext::isAdmin()) {
            $bool = $this->workLogModel->checkPalletizeComplete($user['user_id']);

            if ($bool) {
                FlashMessage::error("You have an ongoing session.");
                return $this->redirect($request, $response, 'work.index');
            }
        }

        $result = $this->workLogModel->initialInsertPallet($data);

        if (!$result) {
            FlashMessage::error("Failed to start session");
            return $this->redirect($request, $response, 'work.index');
        }

        FlashMessage::success("Session started successfully");
        return $this->redirect($request, $response, 'work.index');
    }

    public function endSession(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $action = $data['action'] ?? null;
        $units = (int)$data['units'] ?? null;
        $mess = isset($data['mess']) ? 1 : 0;
        $notes = $data['notes'] ?? null;
        $errors = [];

        //user pressed break
        if ($action === 'break') {
            $sessionId = $data['session_id'] ?? null;
            if (is_null($sessionId)) {
                FlashMessage::error("Session ID must be provided to toggle break.");
                return $this->redirect($request, $response, 'work.index');
            }

            // if not currently on break -> start break, else end break and accumulate break_time
            if (!$this->workLogModel->isOnBreak($sessionId)) {
                $this->workLogModel->startBreak(['session_id' => $sessionId]);
                FlashMessage::success("Break started successfully");
            } else {
                $this->workLogModel->endBreak(['session_id' => $sessionId]);
                FlashMessage::success("Break ended successfully");
            }

            return $this->redirect($request, $response, 'work.index');
        }


        //dd($data);
        if (is_null($units)  || is_null($mess)) {
            $errors[] = "Units, Breaks, and Mess must be provided";
        }

        if (!is_numeric($units)) {
            $errors[] = "Units must be a numeric value";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'work.index');
        }

        $pallet = [
            'session_id' => $data['session_id'],
            'units' => $units,
            'mess' => $mess,
            'notes' => $notes,
        ];

        $ok = $this->workLogModel->completePalletizeSession($pallet);

        if (!$ok) {
            FlashMessage::error("Failed to end session");
            return $this->redirect($request, $response, 'work.index');
        }

        FlashMessage::success("Session ended successfully");
        return $this->redirect($request, $response, 'work.index');
    }

    public function startBreak(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $session_id = $data['session_id'] ?? null;

        if (is_null($session_id)) {
            FlashMessage::error("Session ID must be provided");
            return $this->redirect($request, $response, 'work.index');
        }

        $breakData = [
            'session_id' => $session_id,
        ];

        $this->workLogModel->startBreak($breakData);

        FlashMessage::success("Break started successfully");
        return $this->redirect($request, $response, 'work.index');
    }

    public function endBreak(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $session_id = $data['session_id'] ?? null;

        if (is_null($session_id)) {
            FlashMessage::error("Session ID must be provided");
            return $this->redirect($request, $response, 'work.index');
        }

        $breakData = [
            'session_id' => $session_id,
        ];

        $this->workLogModel->endBreak($breakData);

        FlashMessage::success("Break ended successfully");
        return $this->redirect($request, $response, 'work.index');
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        if (!UserContext::isAdmin()) {
            return $response->withStatus(403, 'Forbidden');
        }

        $station_id = (int)($args['station_id'] ?? $args['id'] ?? 1);

        $pallets = $this->workLogModel->getSelectedWorkLogs($station_id);
        $team_members = $this->teamModel->getTodayTeamMembersForStation($station_id);
        $station = $this->stationModel->getStationById($station_id);

        $stations = $this->stationModel->getAllStations();

        $show_form_end = false;
        foreach ($pallets as $pl) {
            if (empty($pl['end_time'])) {
                $show_form_end = true;
                break;
            }
        }

        $show_break_continue = false;
        $mostRecentSessionId = null;
        if (!empty($pallets)) {
            $latestTs = null;
            foreach ($pallets as $pl) {
                if (empty($pl['start_time'])) continue;
                if ($latestTs === null || strtotime($pl['start_time']) > strtotime($latestTs)) {
                    $latestTs = $pl['start_time'];
                    $mostRecentSessionId = $pl['session_id'] ?? null;
                }
            }
            if ($mostRecentSessionId && $this->workLogModel->isOnBreak($mostRecentSessionId)) {
                $show_break_continue = true;
            }
        }

        return $this->render($response, 'pages/workView.php', [
            'pallets' => $pallets,
            'team_members' => $team_members,
            'show_form_end' => $show_form_end,
            'station' => $station,
            'stations' => $stations,
            'selectedStationId' => $station_id,
            'isAdmin' => true,
            'show_break_continue' => $show_break_continue,
        ]);
    }
}
