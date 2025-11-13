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

class ProductController extends BaseController
{
    public function __construct(
        Container $container,
    private ProductModel $productModel)
    {
        parent:: __construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response {

        $products = $this->productModel->getAllProducts();
        $types = $this->productModel->getAllProductTypes();

        $data = [
                'page_title' => 'Welcome to KVC Manager',
                'contentView' => APP_VIEWS_PATH . '/pages/admin/products.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'data' => [
                    'title' => 'Admin Products',
                    'products' => $products,
                    'types' => $types,
                ]
            ];
        return $this->render($response, 'admin/productIndexView.php', $data);
    }

    public function show(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderShowView.php');
    }

    public function create(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryCreateView.php');
    }

    public function store(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $isValid = true;

        if (empty($data['code'] || $data['type'] || $data['name'])) {
            FlashMessage::error("Fill out All fields");
            $isValid = false;
        }

        if ($isValid) {
            $this->productModel->createProduct($data);
            FlashMessage::success("Successfully Created Product!");
        }
        return $this->redirect($request, $response, 'admin/productIndexView.php');
    }

    public function edit(Request $request, Response $response, array $args): Response {
        $product_id = $args['id'];

        $product = $this->productModel->getProductById($product_id);
        $types = $this->productModel->getAllProductTypes();

        $data = [
                'page_title' => 'Welcome to KVC Manager',
                'contentView' => APP_VIEWS_PATH . '/pages/admin/products.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'data' => [
                    'title' => 'Admin Products',
                    'product' => $product,
                    'product_types' => $types,
                ]
            ];
        return $this->render($response, 'admin/ProductEditView.php', $data);
    }

    public function update(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $isValid = true;

        if (empty($data['code'] || $data['type'] || $data['name'])) {
            FlashMessage::error("Fill out All fields");
            $isValid = false;
        }

        if ($isValid) {
            $this->productModel->updateProduct($data['id'], $data);
            FlashMessage::success("Successfully Created Product!");
        }
        return $this->redirect($request, $response, 'admin/productIndexView.php');
    }

    public function delete(Request $request, Response $response, array $args): Response {
        $id = $args['id'];

        $this->productModel->deleteProduct($id);
        FlashMessage::success("Successfully Deleted Product With ID: $id");

        return $this->redirect($request, $response, 'admin/productIndexView.php');
    }
}

?>
