<?php

use App\Helpers\ViewHelper;
<<<<<<< HEAD
// var_dump($   data);
=======

//var_dump($data);
>>>>>>> 62b90d5e1f8f537185acf34ffea13b2c07c213f4
//* DYNAMIC POPUPS
$show2fa_login = $data['show2fa_login'] ?? false;
$show_forgot_password = $data['show_forgot_password'] ?? false;
//not using this
$show_forgot_password_2fa = $data['show_forgot_password_2fa'] ?? false;
$show_new_password = $data['show_new_password'] ?? false;

$show_forgot_email = $data['show_forgot_email'] ?? false;
$show_forgot_email_2fa = $data['show_forgot_email_2fa'] ?? false;
$show_new_email = $data['show_new_email'] ?? false;
<<<<<<< HEAD
echo $show2fa_login;
$page_title ='Login page';
ViewHelper::loadHeader($page_title, false);

?>

<div id="login-page-wrapper" class="page">
    <div id="login-page-content" class="display-flex-row">
        <div id="login">
            <div id="login-form-wrapper" class="auth-form-wrapper metallic">
                <!-- <div class="center-logo">
                    <div class="logo-circle">VKC</div>
                </div> -->
                <form id="login-form" method="POST" action="<?= APP_BASE_URL ?>/login">
                    <?= App\Helpers\FlashMessage::render() ?>   
                    <label for="email">Email Address</label>
                    <input type="text" name="email" id="email" required>
                    <a href="#">Forgot Email?</a>
                    <br>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                    <a href="#">Forgot Password?</a>
                    <br>
                    <br>

                    <div class="button-row">
                        <a href="./register"><button type="button" class="signup-btn btn btn-wide btn-secondary">Sign Up</button></a>
                        <button type="submit" class="signin-btn btn btn-wide btn-primary">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="login-page-about" class="display-flex-col flex-center">
            <div class="login-page-info">
                <h1>VKC</h1>
                <h4>[If VKC is short for something, update with the full company name]</h4>
                <h2>[Insert Subtitle Here (a short hook/summary of the company)]</h2>

                <div class="description-box">
                    <p>[INSERT Description - Summary of who/what/where is the company...]</p>
                    <p>BLALALALALALALALALALALALALALLALALALALALA</p>
                    <p>LALALALALALALALALALA</p>
                    <p>Socials:<br>[insert social media links here]</p>
                </div>
            </div>
=======
//echo $show2fa_login;
$page_title = 'Login page';
ViewHelper::loadHeader($page_title);

?>
<div class="login-container">

    <?= App\Helpers\FlashMessage::render() ?>
    <div class="left-panel">

        <div class="left-info-box">
            <h1 class="brand-title">VKC</h1>
            <h3 class="brand-sub">Vito · Kian · Colton</h3>

            <h2 class="brand-service">Co-Packaging Service</h2>

            <p class="brand-desc">
                VKC Packaging is a business-to-business company specializing in
                the packaging of resin products for the flooring industry.
            </p>

            <p class="brand-phone">
                Phone number:<br>
                +1 (514) 513-7900
            </p>
        </div>

    </div>

    <?= App\Helpers\FlashMessage::render() ?>


    <div class="form-panel">

        <div class="center-logo">
            <div class="logo-circle">VKC</div>
>>>>>>> 62b90d5e1f8f537185acf34ffea13b2c07c213f4
        </div>
        <form method="POST" action="">
            <label for="email">Email Address</label>
            <input type="text" name="email" id="email" required style="color:white;">
            <a href="</?= APP_BASE_URL ?>/login/forgot-email">Forgot Email?</a>
            <br>
            <br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required style="color:white;">
            <a href="</?= APP_BASE_URL ?>/login/forgot-password">Forgot Password?</a>

            <div class="button-row">
<<<<<<< HEAD
                <a class='btn btn-success' href="</?= APP_BASE_URL ?>/register">Sign in</a>
=======
                <a class='btn btn-success' href="<?= APP_BASE_URL ?>/register">Create New Account</a>
>>>>>>> 5cf569f45382940b981c9e3e2abe932d0a835d98
                <button type="submit" class="signin-btn">Sign In</button>
            </div>
        </form>
    </div>
</div>

<!-- FORGOT PASSWORD POPUP -->
<?php
if ($show_forgot_password): ?>
    <div id="forgotPasswordModal" class="forgot-modal-overlay">
        <div class="forgot-modal-box">
            <a class="close-forgot" href="<?= APP_BASE_URL ?>/login">X</a>

            <h2>Forgot Password</h2>
            <p>Please enter the 6-digit code sent to your phone number to confirm your account.</p>
            <form method="POST" action="<?= APP_BASE_URL ?>/login/forgot-password">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" placeholder="5141231234">

                <div class="forgot-btn-row">
                    <button type="submit" class="forgot-send">Send Code</button>
                </div>
            </form>

            <form method="POST" action="<?= APP_BASE_URL ?>/login/forgot-password/verify">
                <label for="code">Verification code:</label>
                <input type="text" id="code" name="code" maxlength="6" placeholder="000000">

<<<<<<< HEAD
        <div class="forgot-btn-row">
            <button class="forgot-send btn btn-wide btn-okay">Send Email</button>
            <button type="button" class="forgot-change"onclick="openNewPasswordModal()">Change Password</button>
=======
                <div class="forgot-btn-row">
                    <button type="submit" class="forgot-change">Change Password</button>
                </div>
            </form>

>>>>>>> 62b90d5e1f8f537185acf34ffea13b2c07c213f4
        </div>
    </div>
<?php endif; ?>
<!--  New Password MODAL -->
<?php
if ($show_new_password): ?>
    <div id="new-password-modal" class="forgot-modal-overlay">
        <div class="forgot-modal-box">

            <!-- Use same close button class -->
            <a class="close-forgot" href="<?= APP_BASE_URL ?>/login">X</a>

            <h2>New Password</h2>
            <p>Please enter a new password.</p>

            <form id="newPasswordForm" method="POST" action="<?= APP_BASE_URL ?>/login/new-password">

                <label>New Password:</label>
                <input type="password" name="password" placeholder="Enter new password" required>

                <label>Confirm New Password:</label>
                <input type="password" name="conf_password" placeholder="Confirm new password" required>

<<<<<<< HEAD
            <div class="forgot-btn-row">
                <!-- Use same button styles -->
                <button type="button" class="forgot-send btn btn-wide btn-okay" onclick="submitNewPassword()">Send</button>
                <button type="button" class="forgot-change btn btn-wide btn-danger" onclick="closeNewPasswordModal()">Cancel</button>
            </div>
        </form>
=======
                <div class="forgot-btn-row">
                    <!-- Use same button styles -->
                    <button type="submit" class="forgot-send">Send</button>
                    <button type="button" class="forgot-change" onclick="closeNewPasswordModal()">Cancel</button>
                </div>
            </form>
        </div>
>>>>>>> 62b90d5e1f8f537185acf34ffea13b2c07c213f4
    </div>
<?php endif; ?>
<!-- FORGOT EMAIL MODAL -->
<?php
if ($show_forgot_email): ?>
    <div id="forgotEmailModal" class="forgot-modal-overlay">
        <div class="forgot-modal-box">

            <a class="close-forgot" href="<?= APP_BASE_URL ?>/login">X</a>

            <h2>Forgot Email</h2>
            <p>Please enter your name and mobile number.<br>
                If there is an account with information you input here, you will receive a SMS message to regain access to your account.</p>

            <form id="forgotEmailForm" method="POST" action="<?= APP_BASE_URL ?>/login/forgot-email">
                <label>First Name:</label>
                <input type="text" placeholder="Enter first name" required>

                <label>Last Name:</label>
                <input type="text" placeholder="Enter last name" required>

                <label>Mobile Number:</label>
                <input type="text" name="phone" placeholder="000-000-0000" required>

                <div class="forgot-btn-row">
                    <button type="button" class="forgot-change" onclick="closeForgotEmailModal()">Cancel</button>
                    <button type="submit" class="forgot-send" onclick="sendForgotEmail()">Send Message</button>
                </div>
            </form>

        </div>
    </div>
<?php endif; ?>
<!-- LOGIN_2FA -->

<!-- New Email MODAL -->
<?php
if ($show_new_email): ?>
    <div id="new-email-modal" class="forgot-modal-overlay">
        <div class="forgot-modal-box">

            <!-- Use same close button class -->
            <a class="close-forgot" href="<?= APP_BASE_URL ?>/login">X</a>

            <h2>New Email</h2>
            <p>Please enter a new email.</p>

            <form id="newEmailForm">

                <label>New Email:</label>
                <input type="password" placeholder="Enter new email" required>

                <label>Confirm New Email:</label>
                <input type="password" placeholder="Confirm new email" required>

                <div class="forgot-btn-row">
                    <!-- Use same button styles -->
                    <button type="button" class="forgot-send" onclick="submitNewEmail()">Send</button>
                    <button type="button" class="forgot-change" onclick="closeNewEmailModal()">Cancel</button>
                </div>
            </form>

        </div>
    </div>
<?php endif; ?>
<!-- 2-factor MODAL -->
<?php if ($show2fa_login): ?>
    <div id="two-factor-modal" class="forgot-modal-overlay">
        <div class="forgot-modal-box">

            <!-- Use same close button class -->
            <a class="close-forgot" href="<?= APP_BASE_URL ?>/login">X</a>

            <h2>Two Factor Authentification</h2>
            <p>Please enter the 6-digit code generated by your application to confirm your login.</p>


            <form method="POST" action="<?= APP_BASE_URL ?>/login/2fa">
                <input type="text" name="code" id="code" maxlength="6" placeholder="XXXXXX" required style="color:white;">

                <div class="forgot-btn-row">
                    <button type="submit" class="verify">Verify</button>
                    <button type="button" class="resend" onclick="resend2FACode()">Resend Code</button>
                </div>
            </form>

        </div>
    </div>
<?php endif; ?>
<!-- FOOTER BAR BUT only for the login page so idk if we should have a separate file/footer for it -->


<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>

<script>
    function close2FAModal() {
        document.querySelector('.twofa-modal-overlay').style.display = 'none';
    }

    function resend2FACode() {
        // TODO: AJAX request to resend
        alert("Code resent!");
    }
</script>
