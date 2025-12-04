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
use App\Helpers\AdminDataHelper;

class ProductTypeController extends BaseController
{
    public function __construct(
        Container $container,
        private AdminDataHelper $adminDataHelper,
    private ProductModel $productModel)
    {
        parent:: __construct($container);
    }

    //probably useless
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
        return $this->render($response, 'pages/adminView.php', $data);
    }

    //probably useless
    public function show(Request $request, Response $response, array $args): Response {
        $product_id = $args['id'];
        $productType = $this->productModel->getProductTypeById($product_id);

        $data = [
                'page_title' => 'Welcome to KVC Manager',
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_product_type_show' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['product_type_to_show' => $productType]),
            ];
        return $this->render($response, 'pages/adminView.php', $data);
    }

    //useless, will have widget form
    public function create(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryCreateView.php');
    }

    //post method to create product type
    public function store(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $errors = [];

        if (empty($data['product_type_name'])) {
            $errors[] = "Product Type Name must be filled out";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'admin.index');
        }
        try {
            $this->productModel->createProductType($data);
            FlashMessage::success("Successfully created product type");
            return $this->redirect($request, $response, 'admin.index');
        } catch (\Throwable $th) {
            FlashMessage::error("Insert failed. Please try again");
            return $this->render($response, 'pages/adminView.php');
        }
    }

    public function edit(Request $request, Response $response, array $args): Response {
        $product_id = $args['id'];

        $product_type = $this->productModel->getProductTypeById($product_id);

        $data = [
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_product_type_edit' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['product_type_to_edit' => $product_type]),
            ];
        return $this->render($response, 'admin/databaseView.php', $data);
    }

    public function update(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $errors = [];

        if (empty($data['product_type_name'])) {
            $errors[] = "Product type name must be filled out";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'admin.index');
        }
        try {
            $this->productModel->updateProductType($data['product_type_id'], $data);
            FlashMessage::success("Successfully updated product type");
            return $this->redirect($request, $response, 'admin.index');
        } catch (\Throwable $th) {
            FlashMessage::error("Update failed. Please try again");
            return $this->redirect($request, $response, 'pages/adminView.php');
        }
    }

    public function delete(Request $request, Response $response, array $args): Response {
        $id = $args['id'];

        $this->productModel->deleteProductType($id);
        FlashMessage::success("Successfully Deleted Product Type With ID: $id");

        return $this->redirect($request, $response, 'admin.index');
    }

    public function showDelete(Request $request, Response $response, array $args): Response {
        $type_id = $args['id'];

        $type = $this->productModel->getProductTypeById($type_id);

        $data = [
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_type_delete' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['type_to_delete' => $type,]),
            ];
        return $this->render($response, 'admin/databaseView.php', $data);
    }
}

?>
