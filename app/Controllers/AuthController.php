<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\PalletModel;
use App\Domain\Models\UserModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController extends BaseController
{
    private UserModel $user_model;
    private PalletModel $pallet_model;
    public function __construct(
        Container $container,UserModel $user_model,PalletModel $pallet_model)
    {
        parent:: __construct($container);
        $this->user_model=$user_model;
        $this->pallet_model=$pallet_model;
    }

    public function showLoginForm(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderIndexView.php');
    }

    public function login(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderShowView.php');
    }

    public function showRegisterForm(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryCreateView.php');
    }

    // public function register(Request $request, Response $response, array $args): Response {
    //     return $this->render($response, 'admin/categoryCreateView.php');
    // }
    //?_NOTE for David: im not sure about your function so here is what i would have done instead?
     public function register(Request $request, Response $response, array $args): Response
{

    $data = $request->getParsedBody();
    $errors = [];


    if (empty($data['first_name'])) {
        $errors[] = 'First name is required.';
    }
    if (empty($data['last_name'])) {
        $errors[] = 'Last name is required.';
    }
    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email is required.';
    }
    if (empty($data['password'])) {
        $errors[] = 'Password is required.';
    }


    $data = array_map('trim', $data);
    $data['first_name'] = htmlspecialchars($data['first_name'], ENT_QUOTES, 'UTF-8');
    $data['last_name']  = htmlspecialchars($data['last_name'], ENT_QUOTES, 'UTF-8');
    $data['email']      = filter_var($data['email'], FILTER_SANITIZE_EMAIL);


    if (!empty($errors)) {
        return $this->render($response, 'auth/registerView.php', [
            'errors' => $errors,
            'old'    => $data
        ]);
    }

    $this->user_model->createUser($data);



    return $this->redirect($request, $response, 'auth.register');
}


    public function showTwoFactorForm(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryEditView.php');
    }

    public function verifyTwoFactor(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryEditView.php');
    }

    // public function logout(Request $request, Response $response, array $args): Response {
    //     return $this->render($response, 'admin/categoryIndexView.php');
    // }

     public function logout(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'auth/loginView.php',[
            'message'=>'You have been logged out.'
        ]);
    }
}

?>
