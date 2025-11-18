<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\PalletModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\ProductModel;
use App\Domain\Models\UserModel;
use App\Helpers\FlashMessage;
use App\Helpers\RegistrationCodeHelper;
use App\Helpers\SMSHelper;

class AuthController extends BaseController
{
    public function __construct(
        Container $container,
    private UserModel $userModel)
    {
        parent:: __construct($container);
    }

    public function showLoginForm(Request $request, Response $response, array $args): Response {
        $sms = new \App\Helpers\SmsHelper($this->settings);

        $sms->send("5149920406", "TESTING TWILIO");
        return $this->render($response, 'pages/loginView.php');
    }

    public function login(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $isValid = true;

        //email validation
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            FlashMessage::error("Email invalid format");
            $isValid = false;
        }

        //if password is shorter than 8 chars
        if (!preg_match('/^.{8,}$/', $data['password'])) {
            FlashMessage::error("Password must be 8 characters long");
            $isValid = false;
        }

        //if validation is correct then check if the user exists/login
        if ($isValid) {
            $user = $this->userModel->login($data['email'], $data['password']);
            //if login is correct then redirect to 2fa
            if ($user) {
                //TODO SEND_2FA CODE_HERE -----------------------------------------------------------
                $render = [
                    'show2fa' => true,
                ];
                return $this->render($response, 'pages/loginView.php', $render);
            } else {
                //else display flash message and render same page
                FlashMessage::error("Incorrect Credentials");
                return $this->render($response, 'pages/loginView.php');
            }
        } else {
            //else data is not valid render same page and display flash messages
            return $this->render($response, 'pages/loginView.php');
        }
    }

    public function showRegisterForm(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'pages/registerView.php');
    }

    public function register(Request $request, Response $response, array $args): Response {
        //get data from form
        $data = $request->getParsedBody();
        $isValid = true;

        //validate for empty fields
        if (empty($data['first_name'] || $data['last_name'] || $data['email'] || $data['phone']
            || $data['password'] || $data['conf_password'])) {
            FlashMessage::error("Fill Out All Fields");
            $isValid = false;
        }
        //validate for only letters
        if (!preg_match('/^[\p{L}\s\'-]+$/u', $data['first_name']) || !preg_match('/^[\p{L}\s\'-]+$/u', $data['last_name'])) {
            FlashMessage::error("First and Last name must be Letters only");
            $isValid = false;
        }
        //if phone number is only numbers
        if (!is_numeric($data['phone'])) {
            FlashMessage::error("Phone number must only contain numbers");
            $isValid = false;
        }
        //if phone number is 10 digits
        if (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
            FlashMessage::error("Phone number must be 10 digits");
            $isValid = false;
        }
        //if email follows email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            FlashMessage::error("Email invalid format");
            $isValid = false;
        }
        //if password and confirmation password match
        if (true) {
            FlashMessage::error("Password and Confirm Password Do Not Match");
            $isValid = false;
        }

        //if password is less than 8 characters
        if (!preg_match('/^.{8,}$/', $data['password'])) {
            FlashMessage::error("Password must be 8 characters long");
            $isValid = false;
        }

        //* validate registration code
        if ($data['registration_code'] !== RegistrationCodeHelper::getWeeklyCode()) {
            FlashMessage::error("Registration code invalid");
            $isValid = false;
        }

        //if isvalid render 2fa Page or just render signIn page
        if ($isValid) {
            return $this->render($response, 'pages/loginView.php');
        } else {
            //else render page again with flash messages
            return $this->render($response, 'pages/registerView.php');
        }
    }

    public function verifyTwoFactor(Request $request, Response $response, array $args): Response {
        //TODO 2FA CODE_VERIFICATION

        //TODO STORE_USER_INFORMATION_IN_USER_CONTEXT
        return $this->render($response, 'pages/homeView.php');
    }

    public function showForgotPasswordForm(Request $request, Response $response, array $args): Response {
        $render = [
            'show_forgot_password' => true,
        ];
        return $this->render($response, 'pages/loginView.php', $render);
    }

    public function sendForgotPassword(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();
        $render = [
            'show_forgot_password' => true,
        ];

        if (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
            FlashMessage::error("Phone number must be 10 digits");
            return $this->render($response, 'pages/loginView.php', $render);
        } else {
            $user = $this->userModel->getUserByPhone($data['phone']);

            if ($user) {
                //TODO SEND_VERIFICATION_CODE_HERE
                return $this->render($response, 'pages/loginView.php', $render);
            }

            return $this->render($response, 'pages/loginView.php', $render);
        }
    }

    public function verifyForgotPassword(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'pages/loginView.php');
    }

    public function showNewPasswordForm(Request $request, Response $response, array $args): Response {
        $render = [
            'show_new_password' => true,
        ];

        return $this->render($response, 'pages/loginView.php');
    }

    public function verifyNewPassword(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'pages/loginView.php');
    }

    public function showForgotEmail(Request $request, Response $response, array $args): Response {
        $render = [
            'show_forgot_email' => true,
        ];

        return $this->render($response, 'pages/loginView.php', $render);
    }
    public function verifyForgotEmail(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'pages/loginView.php');
    }

    public function showNewEmail(Request $request, Response $response, array $args): Response {
        $render = [
            'show_new_email' => true,
        ];

        return $this->render($response, 'pages/loginView.php', $render);
    }
    public function verifyNewEmail(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'pages/loginView.php');
    }

    public function logout(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'pages/loginView.php');
    }
}

?>
