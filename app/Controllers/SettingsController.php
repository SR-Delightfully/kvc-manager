<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\UserModel;
use App\Helpers\FlashMessage;
use DI\Container;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SettingsController extends BaseController
{
    public function __construct(Container $container, private UserModel $userModel)
    {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $data = [
            'page_title' => 'Welcome to KVC Manager',
            'contentView' => APP_VIEWS_PATH . '/pages/settingsView.php',
            'isSideBarShown' => true,
            'data' => [
                'title' => 'Settings',
                'message' => 'settings Page',
            ]
        ];

        return $this->render($response, 'common/layout.php', $data);
    }

    public function error(Request $request, Response $response, array $args): Response
    {

        return $this->render($response, 'errorView.php');
    }

    /**
     * Creates a new user in the database. if they do not exist.
     * The input form data will have the fields for the new user record, which will be validated
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function createUser(Request $request, Response $response, array $args): Response
    {
        //? 1) Parse the request
        $formData = $request->getParsedBody();
        $firstName = $formData["first_name"];
        $firstName = $formData["first_name"];
        $firstName = $formData["first_name"];
        $firstName = $formData["first_name"];

        //? 2) Validate
        $errors = [];

        if (empty($firstName)) {
            $errors[] = "All fields are required!";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'auth.register');
        } else {
            try {
                $userData = [
                    'first_name' => $firstName,
                ];
                $userId = $this->userModel->createUser($userData);
                FlashMessage::success("Registration successful! Please log in.");
                return $this->redirect($request, $response, 'auth.login');
            } catch (\Exception $e) {
                FlashMessage::error("Registration failed. Please try again.");
                return $this->redirect($request, $response, 'auth.register');
            }
        }
    }


    /**
     *Update a user's info if they do exist.
     * The input form data will have the fields that thar need to be updated, if they do not need to be updated, they can be empty of inexistent in the form data.
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function updateUserFields(Request $request, Response $response, array $args): Response
    {
        //? 1) Parse the request and 2) Verify what needs to be updated
        //? 3) Validate

        $errors = [];
        $phoneRegex1 = '/^\d{3}-\d{3}-\d{4}$/';
        $phoneRegex2 = '/^\d{10}$/';

        try {

            $formData = $request->getParsedBody();
            $userId = $formData["user_id"];

            if (!isset($userId) || $userId <= 0) {
                throw new Exception("User ID not set in the user update form; ID: $userId", 1);
            }

            if (isset($formData["first_name"]) && !empty($firstName)) {
                $firstName = trim($formData["first_name"]);
            } else {
                $firstName = $this->userModel->getUserField("first_name", $userId);
            }

            if (isset($formData["last_name"]) && !empty($lastName)) {
                $lastName = trim($formData["last_name"]);
            } else {
                $lastName = $this->userModel->getUserField("last_name", $userId);
            }

            if (isset($formData["email"]) && !empty($email)) {
                $email = trim($formData["email"]);

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Please enter valid email address like abc@example.com.";
                }
            } else {
                $email = $this->userModel->getUserField("email", $userId);
            }

            if (isset($formData["phone"]) && !empty($phone)) {
                $phone = trim($formData["phone"]);

                if (!preg_match($phoneRegex1, $phone) && !preg_match($phoneRegex2, $phone)) {
                    $errors[] = "Please enter valid phone number like 1231231234 or 123-123-1234";
                }
            } else {
                $phone = $this->userModel->getUserField("phone", $userId);
            }
        } catch (Exception $e) {
            print($e->getMessage());
        }

        //? 3) Validate:

        // $emailRegex = "";

        //TODO Update Flash messages if needed
        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'auth.register');
        } else {
            try {
                $userData = [
                    'user_id' => $userId,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'phone' => $phone
                ];

                $this->userModel->updateInformation($userId, $userData);
                FlashMessage::success("Update successful!");
                // return $this->redirect($request, $response, 'auth.login');
            } catch (\Exception $e) {
                FlashMessage::error("Update failed. Please try again.");
                // return $this->redirect($request, $response, 'auth.register');
            }
        }
    }
}
