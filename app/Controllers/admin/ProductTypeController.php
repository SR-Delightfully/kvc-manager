<?php

declare(strict_types=1);

namespace App\Controllers\admin;
use App\Controllers\BaseController;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\ProductModel;
use App\Helpers\UserContext;
use App\Helpers\FlashMessage;

class ProductTypeController extends BaseController
{
    public function __construct(
        Container $container,
    private ProductModel $productModel)
    {
        parent:: __construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response {
        $types = $this->productModel->getAllProductTypes();

        $data = [
                'page_title' => 'Welcome to KVC Manager',
                'contentView' => APP_VIEWS_PATH . '/pages/admin/productTypes.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'data' => [
                    'title' => 'Admin Product Types',
                    'types' => $types,
                ]
            ];
        return $this->render($response, 'admin/productTypesIndexView.php', $data);
    }

    //probably useless
    public function show(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderShowView.php');
    }
    public function create(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryCreateView.php');
    }

    //crud operations are weird with enums in sql i might change the enum to another table
    public function store(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $isValid = true;

        if (empty($data['type'])) {
            FlashMessage::error("Fill out All fields");
            $isValid = false;
        }

        if ($isValid) {
            $this->productModel->createProductType($data);
            FlashMessage::success("Successfully Created Product!");
        }
        return $this->redirect($request, $response, 'admin/productIndexView.php');
    }

    public function edit(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryEditView.php');
    }

    public function update(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryEditView.php');
    }

    public function delete(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryIndexView.php');
    }
}

?>
