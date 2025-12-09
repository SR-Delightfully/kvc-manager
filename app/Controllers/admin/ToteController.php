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
use App\Domain\Models\ToteModel;

class ToteController extends BaseController
{
    public function __construct(
        Container $container,
    private ToteModel $toteModel,
    private AdminDataHelper $adminDataHelper)
    {
        parent:: __construct($container);
    }

    //probably useless since AdminController index method loads all information
    //going to keep this just in case
    public function index(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'pages/adminView.php');
    }

    //get request
    //gets product's id then renders same page with show product popup
    public function show(Request $request, Response $response, array $args): Response {
        $product_id = $args['id'];
        $product = $this->toteModel->getToteById($product_id);

        $data = [
                'page_title' => 'Welcome to KVC Manager',
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_tote_show' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['tote_to_show' => $product]),
            ];
        return $this->render($response, 'pages/adminView.php', $data);
    }

    //useless since create option is already in the widget view
    public function create(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'pages/adminView.php');
    }

    //post method for creating product
    public function store(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $errors = [];
        //dd($data);
        if (empty($data['product_type_id']) || empty($data['product_name'])) {
            $errors[] = "Product Type and Product Name are required";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'admin.index');
        }
        try {
            $this->toteModel->createTote($data);
            FlashMessage::success("Successfully created product");
            return $this->redirect($request, $response, 'admin.index');
        } catch (\Throwable $th) {
            FlashMessage::error("Insert failed. Please try again");
            return $this->render($response, 'pages/adminView.php');
        }
    }

    //gets product's information, renders page again but display edit popup
    public function edit(Request $request, Response $response, array $args): Response {
        $tote_id = $args['id'];

        $tote = $this->toteModel->getToteCleanById($tote_id);

        $data = [
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_tote_edit' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['tote_to_edit' => $tote]),
            ];
        return $this->render($response, 'admin/databaseView.php', $data);
    }

    //post method for updating specified product
    public function update(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $errors = [];

        if (empty($data['variant_id']) || empty($data['batch_number'])) {
            $errors[] = "Variant ID and Batch Number must be filled out";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'admin.index');
        }
        try {
            $this->toteModel->updateTote($data['tote_id'], $data);
            FlashMessage::success("Successfully updated Tote");
            return $this->redirect($request, $response, 'admin.index');
        } catch (\Throwable $th) {
            FlashMessage::error("Update failed. Please try again");
            return $this->redirect($request, $response, 'admin.index');
        }
    }

    //get method deleting specified product
    public function delete(Request $request, Response $response, array $args): Response {
        $id = $args['id'];

        $this->toteModel->deleteTote($id);
        FlashMessage::success("Successfully Deleted Tote With ID: $id");

        return $this->redirect($request, $response, 'admin.index');
    }

    public function showDelete(Request $request, Response $response, array $args): Response {
        $tote_id = $args['id'];

        $tote = $this->toteModel->getToteById($tote_id);

        $data = [
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_tote_delete' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['tote_to_delete' => $tote,]),
            ];
        return $this->render($response, 'admin/databaseView.php', $data);
    }
}

?>
