<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\PalletModel;
use App\Domain\Models\UserModel;
use App\Helpers\FlashMessage;
use App\Helpers\RegistrationCodeHelper;
use App\Helpers\SessionManager;
use App\Helpers\UserContext;
use App\Helpers\AuthHelper;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * AuthController
 *
 * TODO: finish documentation
 */
class AuthController extends BaseController
{

    public function __construct(
        Container $container,
        private UserModel $userModel,
        private PalletModel $palletModel,
        private AuthHelper $authHelper
    ) {
        parent::__construct($container);
    }

        public function registrationCode(Request $request, Response $response, array $args): Response
        {
            $code = RegistrationCodeHelper::getWeeklyCode();
            $this->authHelper->sendVerificationCode("+15149920406");
            $data = ['title' => 'Login',
                    'code' => $code,
                ];
            return $this->render($response, 'auth/codeTestingView.php', $data);
        }

    public function showLoginForm(Request $request, Response $response, array $args): Response
    {
        $data = ['title' => 'Login'];
        return $this->render($response, 'auth/loginView.php', $data);
    }

    public function showRegisterForm(Request $request, Response $response, array $args): Response
    {
        $data = ['title' => 'Registration'];
        return $this->render($response, 'auth/registerView.php', $data);
    }

    public function login(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody() ?? [];
        $email = trim((string)($data['email'] ?? ''));
        $password = (string)($data['password'] ?? '');
        $errors = [];

        // Basic validation
        if ($email === '' || $password === '') {
            $errors[] = "Fill out all fields";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email invalid format";
            }

            if (!preg_match('/^.{8,}$/', $password)) {
                $errors[] = "Password must be at least 8 characters long";
            }

            $specialChars = '/[!@#$%^&*()_\-+=}{\][?><,.]/';
            if (!preg_match($specialChars, $password)) {
                $errors[] = "Password must contain a special character";
            }

            if (!preg_match('/\d/', $password)) {
                $errors[] = "Password must contain at least 1 number";
            }
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'login.index');
        }

        // Verify credentials (UserModel->verifyCredentials returns user array or null)
        $user = $this->userModel->verifyCredentials($email, $password);

        if (!$user) {
            FlashMessage::error("Invalid credentials. Please try again.");
            return $this->redirect($request, $response, 'login.index');
        }

        // Send 2FA code
        try {
            $phone = $user['phone'] ?? '';
            if ($phone === '') {
                FlashMessage::error("No phone number available for 2FA.");
                return $this->redirect($request, $response, 'login.index');
            }

            $phoneFormat = '+1' . preg_replace('/\D+/', '', $phone);
            $sent = $this->authHelper->sendVerificationCode($phoneFormat);

            if (!$sent) {
                FlashMessage::error("Failed to send SMS message");
                return $this->redirect($request, $response, 'login.index');
            }

            // Store pending 2FA session state
            SessionManager::set('pending_2fa', [
                'user'  => $user,
                'phone' => $phoneFormat,
            ]);

            error_log('AFTER LOGIN, SESSION pending_2fa = ' . print_r(SessionManager::get('pending_2fa'), true));

            return $this->redirect($request, $response, 'auth.2fa');
        } catch (\Throwable $th) {
            error_log('2FA send error: ' . $th->getMessage());
            FlashMessage::error("2FA Failed. Please try again.");
            return $this->redirect($request, $response, 'login.index');
        }
    }
    public function showTwoFactorForm(Request $request, Response $response, array $args): Response
    {
        $data = ['title' => 'Login', 'show2fa_login'=>true];
        return $this->render($response, 'auth/loginView.php', $data);
    }

    public function register(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody() ?? [];

        $firstName = trim((string)($data['first_name'] ?? ''));
        $lastName  = trim((string)($data['last_name'] ?? ''));
        $email     = trim((string)($data['email'] ?? ''));
        $phone     = preg_replace('/\D+/', '', (string)($data['phone'] ?? '')); // digits only
        $password  = (string)($data['password'] ?? '');
        $confPass  = (string)($data['password-confirm'] ?? '');
        $regCode   = trim((string)($data['code'] ?? ''));

        $errors = [];

        // Required fields
        if ($firstName === '' || $lastName === '' || $email === '' || $phone === '' || $password === '' || $confPass === '') {
            $errors[] = "Fill Out All Fields";
        }

        // Name validation (letters, spaces, apostrophes, hyphens)
        if ($firstName !== '' && !preg_match('/^[\p{L}\s\'-]+$/u', $firstName)) {
            $errors[] = "First name must contain letters only";
        }
        if ($lastName !== '' && !preg_match('/^[\p{L}\s\'-]+$/u', $lastName)) {
            $errors[] = "Last name must contain letters only";
        }

        // Phone checks
        if ($phone !== '' && !preg_match('/^[0-9]{10}$/', $phone)) {
            $errors[] = "Phone number must be 10 digits";
        }

        // Email format
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalid format";
        }

        // Password checks
        if ($password !== $confPass) {
            $errors[] = "Password and Confirm Password do not match";
        }

        if (!preg_match('/^.{8,}$/', $password)) {
            $errors[] = "Password must be at least 8 characters long";
        }
        $specialChars = '/[!@#$%^&*()_\-+=}{\][?><,.]/';
        if (!preg_match($specialChars, $password)) {
            $errors[] = "Password must contain a special character";
        }
        if (!preg_match('/\d/', $password)) {
            $errors[] = "Password must contain at least 1 number";
        }

        // Registration code check
        if ($regCode === '' || $regCode !== RegistrationCodeHelper::getWeeklyCode()) {
            $errors[] = "Registration code invalid";
        }

        // Existing user checks
        if ($phone !== '') {
            $userPhone = $this->userModel->getUserByPhone($phone);
            if ($userPhone) {
                $errors[] = "Phone number already in use";
            }
        }
        if ($email !== '') {
            $userEmail = $this->userModel->getUserByEmail($email);
            if ($userEmail) {
                $errors[] = "Email already in use";
            }
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'register.index');
        }

        try {
            // Pass plaintext password to UserModel->register which will hash it
            $user = [
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'email'      => $email,
                'phone'      => $phone,
                'password'   => $password,
            ];

            $this->userModel->register($user);

            FlashMessage::success("Registration successful");
            return $this->redirect($request, $response, 'login.index');
        } catch (\Throwable $th) {
            error_log('Registration error: ' . $th->getMessage());
            FlashMessage::error("Registration failed. Please try again.");
            return $this->redirect($request, $response, 'register.index');
        }
    }

    public function verifyTwoFactor(Request $request, Response $response, array $args): Response
    {
        error_log('VERIFY 2FA - RAW $_SESSION: ' . print_r($_SESSION ?? [], true));

        $data = $request->getParsedBody() ?? [];
        $code = trim((string)($data['code'] ?? ''));

        $pending = SessionManager::get('pending_2fa');

        if (!$pending || empty($pending['user']) || empty($pending['phone'])) {
            FlashMessage::error("2FA Session Expired. Login again");
            SessionManager::remove('pending_2fa');
            return $this->render($response, 'auth/loginView.php');
        }

        $phoneFormat = $pending['phone'];

        try {
            $ok = $this->authHelper->checkVerificationCode($phoneFormat, $code);

            if (!$ok) {
                FlashMessage::error("Invalid or expired verification code.");
                return $this->render($response, 'auth/loginView.php', ['show2fa_login' => true]);
            }

            // Success: log the user in and clear session
            $user = $pending['user'];
            SessionManager::remove('pending_2fa');

            UserContext::login($user);

            return $this->redirect($request, $response, 'dashboard.load');
        } catch (\Throwable $e) {
            error_log("2FA verify error: " . $e->getMessage());
            FlashMessage::error("There was a problem verifying your code. Try again.");
            return $this->render($response, 'auth/loginView.php', ['show2fa_login' => true]);
        }
    }

    public function showForgotPasswordForm(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'auth/loginView.php', ['show_forgot_password' => true, 'title' => 'Login']);
    }

    public function sendForgotPassword(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody() ?? [];
        $contact = trim((string)($data['phone'] ?? ''));

        if ($contact === '') {
            FlashMessage::error("Please provide a phone number or email");
            return $this->redirect($request, $response, 'login.forgot-password');
        }

        // Try phone first (digits-only)
        $digits = preg_replace('/\D+/', '', $contact);
        $userPhone = null;
        $userEmail = null;

        if (preg_match('/^[0-9]{10}$/', $digits)) {
            $userPhone = $this->userModel->getUserByPhone($digits);
        }

        if (!$userPhone && filter_var($contact, FILTER_VALIDATE_EMAIL)) {
            $userEmail = $this->userModel->getUserByEmail($contact);
        }

        if ($userPhone) {
            $phone = $userPhone['phone'] ?? '';
            $phoneFormat = '+1' . preg_replace('/\D+/', '', $phone);
            $sent = $this->authHelper->sendVerificationCode($phoneFormat);

            if (!$sent) {
                FlashMessage::error("Failed to send SMS message");
                return $this->redirect($request, $response, 'login.index');
            }

            SessionManager::set('pending_2fa', [
                'user'  => $userPhone,
                'phone' => $phoneFormat,
            ]);

            $discreteNum = substr($phone, -2);
            FlashMessage::success("Verification code sent to phone number ending with $discreteNum");

            return $this->redirect($request, $response, 'login.forgot-password');
        }

        if ($userEmail) {
            // TODO: implement email sending logic for password reset
            FlashMessage::error("Email-based password reset is not implemented yet.");
            return $this->redirect($request, $response, 'login.index');
        }

        FlashMessage::error("User with that phone number or email does not exist");
        return $this->redirect($request, $response, 'login.index');
    }

    public function verifyForgotPassword(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody() ?? [];
        $code = trim((string)($data['code'] ?? ''));
        $pending = SessionManager::get('pending_2fa');

        if (!$pending || empty($pending['user']) || empty($pending['phone'])) {
            FlashMessage::error("2FA Session Expired. Login again");
            SessionManager::remove('pending_2fa');
            return $this->redirect($request, $response, 'login.forgot-password');
        }

        $phoneFormat = $pending['phone'];

        try {
            $ok = $this->authHelper->checkVerificationCode($phoneFormat, $code);

            if (!$ok) {
                FlashMessage::error("Invalid or expired verification code.");
                return $this->redirect($request, $response, 'login.forgot-password');
            }

            //Verified -> allow user to set a new password
            $user = $pending['user'];
            SessionManager::set('temp_user', ['user' => $user]);
            SessionManager::remove('pending_2fa');

            return $this->redirect($request, $response, 'login.new-password');
        } catch (\Throwable $e) {
            error_log("2FA verify error: " . $e->getMessage());
            FlashMessage::error("There was a problem verifying your code. Try again.");
            return $this->redirect($request, $response, 'login.forgot-password');
        }
    }

    public function showNewPasswordForm(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'auth/loginView.php', ['show_new_password' => true, 'title'=>'login']);
    }

    public function verifyNewPassword(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody() ?? [];
        $pass = (string)($data['password'] ?? '');
        $conf_pass = (string)($data['conf_password'] ?? '');

        $pending = SessionManager::get('temp_user');

        if (!$pending || empty($pending['user'])) {
            FlashMessage::error("2FA Session Expired. Try again.");
            SessionManager::remove('temp_user');
            return $this->redirect($request, $response, 'login.new-password');
        }

        if (!preg_match('/^.{8,}$/', $pass)) {
            FlashMessage::error("Password must be at least 8 characters");
            return $this->redirect($request, $response, 'login.new-password');
        }

        if (!preg_match('/\d/', $pass)) {
            FlashMessage::error("Password must contain at least 1 number");
            return $this->redirect($request, $response, 'login.new-password');
        }

        if ($pass !== $conf_pass) {
            FlashMessage::error("Password does not match Confirm Password");
            return $this->redirect($request, $response, 'login.new-password');
        }

        // Update user password (UserModel->changePassword will hash)
        $user = $pending['user'];
        $this->userModel->changePassword($user, $pass);
        SessionManager::remove('temp_user');

        FlashMessage::success("Password changed successfully. Please login.");
        return $this->redirect($request, $response, 'login.index');
    }

    public function showForgotEmail(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'auth/loginView.php', ['show_forgot_email' => true]);
    }

    public function sendForgotEmail(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody() ?? [];
        $phoneRaw = preg_replace('/\D+/', '', (string)($data['phone'] ?? ''));

        if (!preg_match('/^[0-9]{10}$/', $phoneRaw)) {
            FlashMessage::error("Phone number must be 10 digits");
            return $this->redirect($request, $response, 'login.forgot-email');
        }

        $user = $this->userModel->getUserByPhone($phoneRaw);

        if (!$user) {
            FlashMessage::error("User with that phone number does not exist");
            return $this->redirect($request, $response, 'login.forgot-email');
        }

        $phoneFormat = '+1' . $phoneRaw;
        $sent = $this->authHelper->sendVerificationCode($phoneFormat);

        if (!$sent) {
            FlashMessage::error("Failed to send SMS message");
            return $this->redirect($request, $response, 'login.forgot-email');
        }

        SessionManager::set('pending_2fa', [
            'user'  => $user,
            'phone' => $phoneFormat,
        ]);

        $discreteNum = substr($phoneRaw, -2);
        FlashMessage::success("Verification code sent to phone number ending with $discreteNum");

        return $this->redirect($request, $response, 'login.forgot-email.2fa');
    }

    public function showForgotEmail2fa(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'auth/loginView.php', ['show_forgot_email_2fa' => true]);
    }
    public function verifyForgotEmail(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody() ?? [];
        $code = trim((string)($data['code'] ?? ''));

        if (!preg_match('/^[0-9]{6}$/', $code)) {
            FlashMessage::error("Verification code must be 6 digits");
            return $this->redirect($request, $response, 'login.forgot-email.2fa');
        }

        $pending = SessionManager::get('pending_2fa');

        if (!$pending || empty($pending['user']) || empty($pending['phone'])) {
            FlashMessage::error("2FA Session Expired. Try process again");
            SessionManager::remove('pending_2fa');
            return $this->redirect($request, $response, 'login.index');
        }

        $phoneFormat = $pending['phone'];

        try {
            $ok = $this->authHelper->checkVerificationCode($phoneFormat, $code);

            if (!$ok) {
                FlashMessage::error("Invalid or expired verification code.");
                return $this->render($response, 'pages/loginView.php', ['show_forgot_email_2fa' => true]);
            }

            //Verified -> allow email change; store in a descriptive session key
            SessionManager::set('change_email', ['user' => $pending['user']]);
            SessionManager::remove('pending_2fa');

            return $this->redirect($request, $response, 'login.new-email');
        } catch (\Throwable $e) {
            error_log("2FA verify error: " . $e->getMessage());
            FlashMessage::error("There was a problem verifying your code. Try again.");
            return $this->redirect($request, $response, 'login.forgot-email');
        }
    }

    public function showNewEmail(Request $request, Response $response, array $args): Response
    {
        $session = SessionManager::get('change_email');
        if (!$session || empty($session['user'])) {
            return $this->render($response, 'pages/loginView.php');
        }

        return $this->render($response, 'pages/loginView.php', ['show_new_email' => true]);
    }

    public function verifyNewEmail(Request $request, Response $response, array $args): Response
    {
        $session = SessionManager::get('change_email');
        if (!$session || empty($session['user'])) {
            return $this->redirect($request, $response, 'login.index');
        }

        $data = $request->getParsedBody() ?? [];
        $email = trim((string)($data['email'] ?? ''));
        $confEmail = trim((string)($data['conf_email'] ?? ''));

        $isValid = true;

        if ($email === '' || $confEmail === '') {
            FlashMessage::error("Fill out both fields");
            $isValid = false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !filter_var($confEmail, FILTER_VALIDATE_EMAIL)) {
            FlashMessage::error("Emails do not follow email format");
            $isValid = false;
        }

        if ($email !== $confEmail) {
            FlashMessage::error("Emails do not match");
            $isValid = false;
        }

        if ($this->userModel->getUserByEmail($email)) {
            FlashMessage::error("Email already in use");
            $isValid = false;
        }

        if (!$isValid) {
            return $this->redirect($request, $response, 'login.new-email');
        }

        // Update email
        $user = $session['user'];
        $this->userModel->changeEmail($user, $email);
        SessionManager::remove('change_email');

        FlashMessage::success("Email updated successfully.");
        return $this->redirect($request, $response, 'login.index');
    }

    public function logout(Request $request, Response $response, array $args): Response
    {
        UserContext::logout();
        return $this->redirect($request, $response, 'login.index');
    }
}
