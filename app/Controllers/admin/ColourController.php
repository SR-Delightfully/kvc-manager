<?php

declare(strict_types=1);

namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Domain\Models\ColourModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\ProductModel;
use App\Helpers\UserContext;
use App\Helpers\FlashMessage;
use App\Helpers\AdminDataHelper;


class ColourController extends BaseController
{
    public function __construct(
        Container $container,
        private AdminDataHelper $adminDataHelper,
    private ColourModel $colourModel)
    {
        parent:: __construct($container);
    }

    //probably useless
    public function index(Request $request, Response $response, array $args): Response {
        $colours = $this->colourModel->getAllColours();

        $data = [
                'page_title' => 'Welcome to KVC Manager',
                'contentView' => APP_VIEWS_PATH . '/pages/admin/colours.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'data' => [
                    'title' => 'Admin Colours',
                    'colours' => $colours,
                ]
            ];
        return $this->render($response, 'pages/adminView.php', $data);
    }

    //useless for now
    public function show(Request $request, Response $response, array $args): Response {
        $colour_id = $args['id'];
        $colour = $this->colourModel->getColourById($colour_id);

        $data = [
                'page_title' => 'Welcome to KVC Manager',
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_colour_show' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['colour_to_show' => $colour]),
            ];
        return $this->render($response, 'pages/adminView.php', $data);
    }

    //useless
    public function create(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'pages/adminView.php');
    }

    //post method to add a new colour
    public function store(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $errors = [];

        if (empty($data['colour_name'] || $data['colour_code'])) {
            $errors[] = "Fill out All fields";
        }

        if (!is_numeric($data['colour_code'])) {
            $errors[] = "Colour Code must be a number";
        }

        if (strlen($data['colour_code']) !== 3) {
            $errors[] = "Colour Code must be 3 digits long";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'admin.index');
        }
        try {
            $this->colourModel->createColour($data);
            FlashMessage::success("Successfully created colour");
            return $this->redirect($request, $response, 'admin.index');
        } catch (\Throwable $th) {
            FlashMessage::error("Insert failed. Please try again");
            return $this->render($response, 'admin/databaseView.php');
        }
    }

    //gets product's information, render page again but displays edit popup
    public function edit(Request $request, Response $response, array $args): Response {
        $colour_id = $args['id'];

        $colour = $this->colourModel->getColourById($colour_id);

        $data = [
                'page_title' => 'Welcome to KVC Manager',
                'contentView' => APP_VIEWS_PATH . '/pages/admin/colours.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_colour_edit' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['colour_to_edit' => $colour]),
            ];
        return $this->render($response, 'admin/databaseView.php', $data);
    }

    //post method for updating specified product
    public function update(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $errors = [];

        if (empty($data['colour_name'] || $data['colour_code'])) {
            $errors[] = "Fill out All fields";
        }

        if (!is_numeric($data['colour_code'])) {
            $errors[] = "Colour Code must be a number";
        }

        if (strlen($data['colour_code']) !== 3) {
            $errors[] = "Colour Code must be 3 digits long";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'admin.index');
        }
        try {
            $this->colourModel->updateColour($data['colour_id'], $data);
            FlashMessage::success("Successfully updated colour");
            return $this->redirect($request, $response, 'admin.index');
        } catch (\Throwable $th) {
            FlashMessage::error("Insert failed. Please try again");
            return $this->render($response, 'pages/adminView.php');
        }
    }

    //get method for deleting specified product
    public function delete(Request $request, Response $response, array $args): Response {
        $id = $args['id'];

        $this->colourModel->deleteColour($id);
        FlashMessage::success("Successfully Deleted Colour With ID: $id");

        return $this->redirect($request, $response, 'admin.index');
    }

    public function showDelete(Request $request, Response $response, array $args): Response {
        $colour_id = $args['id'];

        $variant = $this->colourModel->getColourById($colour_id);

        $data = [
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_colour_delete' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['colour_to_delete' => $variant,]),
            ];
        return $this->render($response, 'admin/databaseView.php', $data);
    }
}

?>
