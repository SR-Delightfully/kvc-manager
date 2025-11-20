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


class ColourController extends BaseController
{
    public function __construct(
        Container $container,
    private ColourModel $colourModel)
    {
        parent:: __construct($container);
    }

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
        return $this->render($response, 'admin/coloursIndexView.php', $data);
    }

    //useless for now
    public function show(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderShowView.php');
    }
    public function create(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryCreateView.php');
    }

    public function store(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $isValid = true;

        if (empty($data['name'] || $data['code'])) {
            FlashMessage::error("Fill out All fields");
            $isValid = false;
        }

        if (!is_numeric($data['code'])) {
            FlashMessage::error("Colour Code must be a number");
            $isValid = false;
        }

        if (strlen($data['code']) !== 3) {
            FlashMessage::error("Colour Code must be 3 digits long");
            $isValid = false;
        }

        if ($isValid) {
            $this->colourModel->createColour($data);
            FlashMessage::success("Successfully Created Colour!");
        }
        return $this->redirect($request, $response, 'admin/ColourIndexView.php');
    }

    public function edit(Request $request, Response $response, array $args): Response {
        $colour_id = $args['id'];

        $colour = $this->colourModel->getColourById($colour_id);

        $data = [
                'page_title' => 'Welcome to KVC Manager',
                'contentView' => APP_VIEWS_PATH . '/pages/admin/colours.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'data' => [
                    'title' => 'Admin Colours',
                    'colour' => $colour,
                ]
            ];
        return $this->render($response, 'admin/ColourEditView.php', $data);
    }

    public function update(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $isValid = true;

        if (empty($data['code'] || $data['name'])) {
            FlashMessage::error("Fill out All fields");
            $isValid = false;
        }

        if (!is_numeric($data['code'])) {
            FlashMessage::error("Colour Code must be a number");
            $isValid = false;
        }

        if (strlen($data['code']) !== 3) {
            FlashMessage::error("Colour Code must be 3 digits long");
            $isValid = false;
        }

        if ($isValid) {
            $this->colourModel->updateColour($data['id'], $data);
            FlashMessage::success("Successfully Created Colour!");
        }
        return $this->redirect($request, $response, 'admin/colourIndexView.php');
    }

    public function delete(Request $request, Response $response, array $args): Response {
        $id = $args['id'];

        $this->colourModel->deleteColour($id);
        FlashMessage::success("Successfully Deleted Product With ID: $id");

        return $this->redirect($request, $response, 'admin/colourIndexView.php');
    }
}

?>
