<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\PalletModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\UserModel;
use App\Helpers\FlashMessage;
use App\Helpers\RegistrationCodeHelper;
use App\Helpers\AuthHelper;
use App\Helpers\SessionManager;
use App\Helpers\UserContext;


class AuthController extends BaseController
{
    private UserModel $user_model;
    private PalletModel $pallet_model;
    private SmsHelper $smsHelper;
    public function __construct(
        Container $container,
     UserModel $userModel,
     PalletModel $palletModel,
    SmsHelper $smsHelper
    )
    {
        parent:: __construct($container);
        $this->user_model=$userModel;
        $this->pallet_model=$palletModel;
        $this->smsHelper=$smsHelper;

    }

    public function showLoginForm(Request $request, Response $response, array $args): Response {
        $data = ['title' => 'Login'];

        return $this->render($response, 'pages/loginView.php', $data);
    }

    //for logging the user in when pressing sign in button, if login successful send 2fa code and load 2fa form
    public function login(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $errors = [];

        //email validation
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalid format";
        }

        //if password is shorter than 8 chars
        if (!preg_match('/^.{8,}$/', $data['password'])) {
            $errors[] = "Password must be 8 characters long";
        }

        $specialChars = "/[!@#$%^&*()_\-+=}{\][?><,.]/";
        if (!preg_match($specialChars, $data['password'])) {
            $errors[] = "Password must contain a Special Character";
        }

        if (!preg_match('/\d/', $data['password'])) {
            $errors[] = "Password must contain at least 1 number";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'pages/loginView.php');
        }

        //find user by its email and password
        $user = $this->userModel->verifyCredentials($data['email'], $data['password']);

        //if not exists flash message and redirect
        if (!$user) {
            FlashMessage::error("Invalid credentials. Please try again.");
            return $this->redirect($request, $response, 'pages/loginView.php');
        }

        //user exists, send 2fa code to phone number and render 2fa page
        try {
            //* SENDING_2FA_CODE
            $phone = $user['phone'];
            $phoneFormat = '+1' . $phone;
            $sent = $this->smsHelper->sendVerificationCode($phoneFormat);

                if (!$sent) {
                    FlashMessage::error("Failed to send SMS message");
                    return $this->render($response, 'auth/loginView.php');
                }

            SessionManager::set('pending_2fa', [
                'user'       => $user,
                'phone'      => $phoneFormat,
            ]);

            $render = [
                'title' => 'login',
                'show2fa_login' => true,
            ];
            return $this->render($response, 'pages/loginView.php', $render);
        } catch (\Throwable $th) {
            FlashMessage::error("2FA Failed. Please try again.");
            return $this->redirect($request, $response, 'auth/loginView.php');
        }
    }


    //used when pressing sign up button
    public function showRegisterForm(Request $request, Response $response, array $args): Response {
        $data = ['title' => 'Registration'];
        return $this->render($response, 'auth/registerView.php', $data);
    }

    //register method used when submitting register form
    public function register(Request $request, Response $response, array $args): Response {
        //get data from form
        $data = $request->getParsedBody();
        $errors = [];

        //validate for empty fields
        if (empty($data['first_name'] || $data['last_name'] || $data['email'] || $data['phone']
            || $data['password'] || $data['conf_password'])) {
            $errors[] = "Fill Out All Fields";
        }
        //validate for only letters
        if (!preg_match('/^[\p{L}\s\'-]+$/u', $data['first_name']) || !preg_match('/^[\p{L}\s\'-]+$/u', $data['last_name'])) {
            $errors[] = "First and Last name must be Letters only";
        }
        //if phone number is only numbers
        if (!is_numeric($data['phone'])) {
            $errors[] = "Phone number must only contain numbers";
        }
        //if phone number is 10 digits
        if (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
            $errors[] = "Phone number must be 10 digits";
        }
        //if email follows email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalid format";
        }
        //if password and confirmation password don't match
        if ($data['password'] !== $data['conf_password']) {
            $errors[] = "Password and Confirm Password Do Not Match";
        }

        //if password is less than 8 characters
        if (!preg_match('/^.{8,}$/', $data['password'])) {
            $errors[] = "Password must be 8 characters long";
        }

        $specialChars = "/[!@#$%^&*()_\-+=}{\][?><,.]/";
        if (!preg_match($specialChars, $data['password'])) {
            $errors[] = "Password must contain a Special Character";
        }

        if (!preg_match('/\d/', $data['password'])) {
            $errors[] = "Password must contain at least 1 number";
        }

        //* validate registration code
        if ($data['registration_code'] !== RegistrationCodeHelper::getWeeklyCode()) {
            $errors[] = "Registration code invalid";
        }
        //if there is already user with that email or phone
        $userPhone = $this->userModel->getUserByPhone($data['phone']);
        if ($userPhone) {
            $errors[] = "Phone number already in use";
        }

        $userEmail = $this->userModel->getUserByEmail($data['email']);
        if ($userEmail) {
            $errors[] = "Email already in use";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'auth/registerView.php');
        }

        //errors is empty then is true, register user
        try {
            //create user array
            $user = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => $data['password'],
            ];

            $this->userModel->register($user);

            FlashMessage::success("Registration successful");
            return $this->redirect($request, $response, 'auth/loginView.php');
        } catch (\Throwable $th) {
            FlashMessage::error("Registration failed. Please try again.");
            return $this->redirect($request, $response, 'auth/registerView.php');
        }
    }

    //controller used when the 2fa form is submitted, checks if codes match if correct set currentUser to user and render dashboard
    public function verifyTwoFactor(Request $request, Response $response, array $args): Response {
        //get inputted code from post form
        $data = $request->getParsedBody();
        $code = trim($data['code'] ?? '');

        $pending = SessionManager::get('pending_2fa');

        if (!$pending || empty($pending['user']) || empty($pending['phone'])) {
            FlashMessage::error("2FA Session Expired. Login again");
            SessionManager::remove('pending_2fa');
            return $this->render($response, 'auth/loginView.php');
        }

        $phoneFormat = $pending['phone'];

        try {
        // $sms = new SmsHelper();

        $ok = $this->smsHelper->checkVerificationCode($phoneFormat, $code);

        //if code is incorrect
        if (!$ok) {
            FlashMessage::error("Invalid or expired verification code.");
            return $this->render($response, 'auth/loginView.php', ['show2fa' => true]);
        }

        //2fa code is correct
        $user = $pending['user'];

        SessionManager::remove('pending_2fa');

        UserContext::login($user);

        return $this->render($response, 'pages/homeView.php');

    } catch (\Throwable $e) {
        error_log("2FA verify error: " . $e->getMessage());
        FlashMessage::error("There was a problem verifying your code. Try again.");

        $render = [
            'show2fa_login' => true,
        ];

        return $this->render($response, 'auth/loginView.php', $render);
        }
    }

    //loads forgot password form
    public function showForgotPasswordForm(Request $request, Response $response, array $args): Response {
        $render = [
            'show_forgot_password' => true,
        ];
        return $this->render($response, 'auth/loginView.php', $render);
    }


    //used when send sms code button is pressed from forgot password form, sends sms code to user's phone
    public function sendForgotPassword(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();
        $render = ['show_forgot_password' => true,];

        //* Check if data is a phone number
        $userPhone = $this->userModel->getUserByPhone($data['contact']);
        $userEmail = $this->userModel->getUserByEmail($data['contact']);
        if ($userPhone) {
            //format phone for twilio
            $phone = $userPhone['phone'];
            $phoneFormat = '+1' . $phone;
            $sent = $this->smsHelper->sendVerificationCode($phoneFormat);

            if (!$sent) {
                FlashMessage::error("Failed to send SMS message");
                return $this->render($response, 'pages/loginView.php', $render);
            }

            //store in session storage so that next step know which user we are resetting
            SessionManager::set('pending_2fa', [
                'user'=> $userPhone,
                'phone'=> $phoneFormat,
            ]);

            $discreteNum = substr($phone, -2);
            FlashMessage::success("Verification code Sent to Phone number ending with $discreteNum");
            $render = ['show_forgot_password_2fa' => true];

            return $this->render($response, 'pages/loginView.php', $render);
        } elseif ($userEmail) {
            //TODO SEND_EMAIL_VERIFICATION
        } else {
            FlashMessage::error("User with that phone number or email does not exist");
            return $this->render($response, 'pages/loginView.php', $render);
        }
    }


    //used when user fills out 2fa code for password change and submits form by pressing change password.
    //if code is correct then render change password popup
    public function verifyForgotPassword(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $code = trim($data['code'] ?? '');
        $render = ['show_forgot_password_2fa' => true];

        $pending = SessionManager::get('pending_2fa');

        if (!$pending || empty($pending['user']) || empty($pending['phone'])) {
            FlashMessage::error("2FA Session Expired. Login again");
            SessionManager::remove('pending_2fa');
            return $this->render($response, 'pages/loginView.php', $render);
        }

        $phoneFormat = $pending['phone'];

        try {
            $ok = $this->smsHelper->checkVerificationCode($phoneFormat, $code);

            //if code is incorrect
            if (!$ok) {
                FlashMessage::error("Invalid or expired verification code.");
                return $this->render($response, 'pages/loginView.php', ['show2fa_login' => true]);
            }

            //2fa code is correct
            $user = $pending['user'];
            //making new session array in case user forcefully navigates to new password without inserting 2fa code
            SessionManager::set('temp_user', ['user' => $user,]);
            SessionManager::remove("pending_2fa");

            $renderNewPass = ['show_new_password' => true];

            return $this->render($response, 'pages/loginView.php', $renderNewPass);
        } catch (\Throwable $e) {
            error_log("2FA verify error: " . $e->getMessage());
            FlashMessage::error("There was a problem verifying your code. Try again.");

            return $this->render($response, 'pages/loginView.php', $render);
        }
    }

    //* probably useless since verifyForgotPassword already renders it
    public function showNewPasswordForm(Request $request, Response $response, array $args): Response {
        $render = [
            'show_new_password' => true,
        ];

        return $this->render($response, 'auth/loginView.php');
        return $this->render($response, 'pages/loginView.php', $render);
    }

    //used when change password form is submitted, if correct then changes user's password
    public function verifyNewPassword(Request $request, Response $response, array $args): Response {
        //* 1. get data from post form
        $data = $request->getParsedBody();
        $pass = $data['password'];
        $conf_pass = $data['conf_password'];
        $render = ['show_new_password' => true];

        //* check if user navigated here from 2fa code
        $pending = SessionManager::get("temp_user") ?? null;

        if (!$pending || empty($pending['user'])) {
            FlashMessage::error("2FA Session Expired. try again");
            SessionManager::remove('temp_user');
            return $this->render($response, 'pages/loginView.php', $render);
        }

        //* 2. validate password requirements
        //if password is less than 8 chars
        if (!preg_match('/^.{8,}$/', $pass)) {
            FlashMessage::error("Password must be at least 8 characters");
            return $this->render($response, 'pages/loginView.php', $render);
        }
        //if password contains at least 1 number
        if (!preg_match('/\d/', $pass)) {
            FlashMessage::error("Password must contain at least 1 number");
            return $this->render($response, 'pages/loginView.php', $render);
        }
        //if password and confirm password match
        if ($pass !== $conf_pass) {
            FlashMessage::error("Password does not match with Confirm Password");
            return $this->render($response, 'pages/loginView.php', $render);
        }

        //* change password
        if ($pending) {
            $user = $pending['user'];
            $this->userModel->changePassword($user, $pass);
            SessionManager::remove("temp_user");
            return $this->render($response, 'pages/loginView.php');
        } else {
            FlashMessage::error("Error loading user. Try Again");
            return $this->render($response, 'auth/loginView.php');
        }
    }

    //loads forgot email popup in loginView
    public function showForgotEmail(Request $request, Response $response, array $args): Response {
        $render = [
            'show_forgot_email' => true,
        ];

        return $this->render($response, 'auth/loginView.php', $render);
    }

    //sends sms code to specified phone number verify user before resetting email
    public function sendForgotEmail(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $render = ['show_forgot_email' => true,];
        $isValid = true;

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

        if (!$isValid) {
            return $this->render($response, 'pages/loginView.php', $render);
        }

        //* check if phone number exists
        $user = $this->userModel->getUserByPhone($data['phone']);
        if ($user) {
            //format phone for twilio
            $phone = $user['phone'];
            $phoneFormat = '+1' . $phone;
            $sent = $this->smsHelper->sendVerificationCode($phoneFormat);

            if (!$sent) {
                FlashMessage::error("Failed to send SMS message");
                return $this->render($response, 'pages/loginView.php', $render);
            }

            //store in session storage so that next step know which user we are resetting
            SessionManager::set('pending_2fa', [
                'user'=> $user,
                'phone'=> $phoneFormat,
            ]);

            //get last 2 digits of phone number
            $discreteNum = substr($phone, -2);
            FlashMessage::success("Verification code Sent to Phone number ending with $discreteNum");
            $render = ['show_forgot_email_2fa' => true];

            return $this->render($response, 'pages/loginView.php', $render);
        } else {
            FlashMessage::error("User with that phone number does not exist");
            return $this->render($response, 'pages/loginView.php', $render);
        }
    }

    //for verifying 2fa code from authentication form, check 2fa codes if match
    public function verifyForgotEmail(Request $request, Response $response, array $args): Response {

        $data = $request->getParsedBody();
        $code = $data['code'] ?? null;
        $render = ['show_forgot_email_2fa' => true,];

        if (is_null($code)) {
            FlashMessage::error("Insert Verification Code");
            return $this->render($response, 'pages/loginView.php', $render);
        }

        if (!preg_match('/^[0-9]{6}$/', $data['code'])) {
            FlashMessage::error("Verification Code must only contain numbers");
            return $this->render($response, 'pages/loginView.php', $render);
        }

        $pending = SessionManager::get('pending_2fa');

        if (!$pending || empty($pending['user']) || empty($pending['phone'])) {
            FlashMessage::error("2FA Session Expired. Try process again");
            SessionManager::remove('pending_2fa');
            return $this->render($response, 'pages/loginView.php', $render);
        }

        //no need to add +1 since pending['phone'] is already formatted for twilio
        $phoneFormat = $pending['phone'];

        try {
            $ok = $this->smsHelper->checkVerificationCode($phoneFormat, $code);

            //if code is incorrect
            if (!$ok) {
                FlashMessage::error("Invalid or expired verification code.");
                return $this->render($response, 'pages/loginView.php', ['show_forgot_email_2fa' => true]);
            }

            //2fa code is correct
            //* EXPLANATION_FOR_NEW_SESSION_KEY
            // instead of keeping pending_2fa and having it in verifyNewEmail i made new session with new key
            // since someone can send the code which makes session manager create the pending_2fa then they can
            // forcefully navigate to set new email skipping 2fa.
            SessionManager::set('change_pass', ['user' => $pending['user'],]);
            SessionManager::remove("pending_2fa");

            $render = ['show_new_email' => true];
            return $this->render($response, 'pages/loginView.php', $render);
        } catch (\Throwable $e) {
            error_log("2FA verify error: " . $e->getMessage());
            FlashMessage::error("There was a problem verifying your code. Try again.");
            $render = ['show_forgot_password' => true,];

            return $this->render($response, 'pages/loginView.php', $render);
        }
    }



    //displays show new email form
    public function showNewEmail(Request $request, Response $response, array $args): Response {

        $user = SessionManager::get("change_pass");
        //redirect to login view if someone navigates to this page without going through 2fa
        if (is_null($user)) {
            return $this->render($response, 'pages/loginView.php');
        }

        $render = ['show_new_email' => true,];
        return $this->render($response, 'pages/loginView.php', $render);
    }

    //validation of new email form when new email form is submitted
    public function verifyNewEmail(Request $request, Response $response, array $args): Response {

        $user = SessionManager::get("change_pass");
        //redirect to login view if someone navigates to this page without going through 2fa
        if (is_null($user)) {
            return $this->render($response, 'pages/loginView.php');
        }

        $data = $request->getParsedBody();
        $render = ['show_new_email' => true];
        $email = $data['email'];
        $confEmail = $data['conf_email'];
        $isValid = true;

        if (empty($email || $confEmail)) {
            FlashMessage::error("Fill out both fields");
            $isValid = false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !filter_var($confEmail, FILTER_VALIDATE_EMAIL)) {
            FlashMessage::error("Emails do not follow email format");
            $isValid = false;
        }

        //check if emails match
        if ($email !== $confEmail) {
            FlashMessage::error("Emails do not Match");
            $isValid = false;
        }

        //check if email is already in use
        $checkEmail = $this->userModel->getUserByEmail($email);
        if ($checkEmail) {
            FlashMessage::error("Email already in use");
            $isValid = false;
        }

        if (!$isValid) {
            return $this->render($response, 'pages/loginView.php', $render);
        }

        //email is correct, update email
        $this->userModel->changeEmail($user, $email);
        SessionManager::remove("change_pass");
        return $this->render($response, 'pages/loginView.php');
    }

    public function logout(Request $request, Response $response, array $args): Response {
        UserContext::logout();
        return $this->render($response, 'pages/loginView.php');
    }
}

?>
