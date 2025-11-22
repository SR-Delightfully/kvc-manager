<?php

declare(strict_types=1);

namespace App\Controllers\admin;
use App\Controllers\BaseController;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\ProductModel;
use App\Domain\Models\ProductVariantModel;
use App\Helpers\AdminDataHelper;
use App\Helpers\FlashMessage;
use App\Domain\Models\ColourModel;
use App\Helpers\UserContext;

class ProductVariantController extends BaseController
{
    public function __construct(
        Container $container,
        private AdminDataHelper $adminDataHelper,
        private ProductModel $productModel,
        private ColourModel $colourModel,
    private ProductVariantModel $productVariantModel)
    {
        parent:: __construct($container);
    }

    //useless
    public function index(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderIndexView.php');
    }

    //maybe useless
    public function show(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderShowView.php');
    }
    //useless
    public function create(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryCreateView.php');
    }

    public function store(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $errors = [];

        if (empty($data['product_id']) || empty($data['units_size']) || empty($data['variant_description'])) {
            $errors[] = "product id, unit size and description must be filled out";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'admin.index');
        }
        try {
            $this->productVariantModel->createVariant($data);
            FlashMessage::success("Successfully Created Product Variant");
            return $this->redirect($request, $response, 'admin.index');
        } catch (\Throwable $th) {
            FlashMessage::error("Insert failed. Please try again");
            return $this->render($response, 'pages/adminView.php');
        }
    }

    //gets variants information, render page again and displays variant edit popup
    public function edit(Request $request, Response $response, array $args): Response {
        $variant_id = $args['id'];

        $variant = $this->productVariantModel->getVariantById($variant_id);

        $data = [
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_variant_edit' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['variant_to_edit' => $variant,]),
            ];
        return $this->render($response, 'pages/adminView.php', $data);
    }

    public function update(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $errors = [];

        if (empty($data['product_id']) || empty($data['units_size']) || empty($data['variant_description'])) {
            $errors[] = "product id, unit size and description must be filled out";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'admin.index');
        }
        try {
            $this->productVariantModel->updateVariant($data['variant_id'], $data);
            FlashMessage::success("Successfully updated product");
            return $this->redirect($request, $response, 'admin.index');
        } catch (\Throwable $th) {
            FlashMessage::error("Update failed. Please try again");
            return $this->redirect($request, $response, 'pages/adminView.php');
        }
    }

    public function delete(Request $request, Response $response, array $args): Response {
        $id = $args['id'];

        $this->productVariantModel->deleteVariant($id);
        FlashMessage::success("Successfully Deleted Variant With ID: $id");

        return $this->redirect($request, $response, 'admin.index');
    }
}

?>
