<?php

use App\Helpers\ViewHelper;
// var_dump($   data);
//* DYNAMIC POPUPS
$show2fa_login = $data['show2fa_login'] ?? false;
$show_forgot_password = $data['show_forgot_password'] ?? false;
//not using this
$show_forgot_password_2fa = $data['show_forgot_password_2fa'] ?? false;
$show_new_password = $data['show_new_password'] ?? false;

$show_forgot_email = $data['show_forgot_email'] ?? false;
$show_forgot_email_2fa = $data['show_forgot_email_2fa'] ?? false;
$show_new_email = $data['show_new_email'] ?? false;
echo $show2fa_login;
$page_title ='Login page';
ViewHelper::loadHeader($page_title, false);
// var_dump($show_forgot_password);
// var_dump($show2fa_login);
// var_dump($show_forgot_password_2fa);
// var_dump($show_new_password);
// var_dump($show_forgot_email);
// var_dump($show_forgot_email_2fa);
?>

<div id="login-page-wrapper" class="page">
    <div id="login-page-content" class="display-flex-row">
        <div id="login">
            <div id="login-form-wrapper" class="auth-form-wrapper metallic">
                <!-- <div class="center-logo">
                    <div class="logo-circle">VKC</div>
                </div> -->
                <form id="login-form" method="POST" action="<?= APP_BASE_URL ?>/login">
                    <?php if ($show2fa_login === false && $show_forgot_password === false && $show_forgot_password_2fa === false && $show_new_password === false && $show_forgot_email === false && $show_forgot_email_2fa === false && $show_new_email === false): ?>
                        <?= App\Helpers\FlashMessage::render() ?>
                    <?php endif; ?>
                    <label for="email">Email Address</label>
                    <input type="text" name="email" id="email" required>
                    <a href="<?= APP_BASE_URL ?>/login/forgot-email">Forgot Email?</a>
                    <br>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                    <a href="<?= APP_BASE_URL ?>/login/forgot-password">Forgot Password?</a>
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
                <br><br><br>
                <h1>VKC</h1>
                <h4>Vito - Kian - Colton</h4>
                <h2>Co-Packaging Service</h2>

                <div class="description-box">
                    <p>VKC Packaging is a business-to-business company specializing in</p>
                    <p>the packaging of resin products for the flooring industry</p><br><br>
                    <p>Socials:<br>[insert social media links here]</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FORGOT PASSWORD POPUP -->
 <?php
 if ($show_forgot_password):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a class="close-forgot" href="<?=APP_BASE_URL?>/login">X</a>

        <h2>Forgot Password</h2>
        <?= App\Helpers\FlashMessage::render() ?>
        <p>Enter your phone number to obtain 2FA Code.</p>
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

        <div class="forgot-btn-row">
            <button class="forgot-send btn btn-wide btn-okay" disabled>Send Email</button>
            <button type="submit" class="forgot-change">Change Password</button>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<!--  New Password MODAL -->
<?php
if ($show_new_password):?>
<div id="new-password-modal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">

        <!-- Use same close button class -->
        <a class="close-forgot" href="<?=APP_BASE_URL?>/login">X</a>

        <h2>New Password</h2>
        <?= App\Helpers\FlashMessage::render() ?>
        <p>Please enter a new password.</p>

        <form id="newPasswordForm" method="POST" action="<?= APP_BASE_URL ?>/login/new-password">

            <label>New Password:</label>
            <input type="password" name="password" placeholder="Enter new password" required>

            <label>Confirm New Password:</label>
            <input type="password" name="conf_password" placeholder="Confirm new password" required>

            <div class="forgot-btn-row">
                <!-- Use same button styles -->
                <button type="submit" class="forgot-send btn btn-wide btn-okay">Send</button>
                <a href="<?=APP_BASE_URL?>/login" class="forgot-change btn btn-wide btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
<!-- FORGOT EMAIL MODAL -->
<?php
if ($show_forgot_email):?>
<div id="forgotEmailModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">

        <a class="close-forgot" href="<?=APP_BASE_URL?>/login">X</a>

        <h2>Forgot Email</h2>
        <?= App\Helpers\FlashMessage::render() ?>
        <p>Please enter your mobile number.<br><br>
        If there is an account with information you input here, you will receive a SMS message to regain access to your account.</p>

        <form id="forgotEmailForm" method="POST" action="<?= APP_BASE_URL ?>/login/forgot-email">
            <label>Mobile Number:</label>
            <input type="text" name="phone" placeholder="000-000-0000" required>

            <div class="forgot-btn-row">
                <a class="forgot-change" href="<?= APP_BASE_URL ?>/login">Cancel</a>
                <button type="submit" class="forgot-send">Send Message</button>
            </div>
        </form>

    </div>
</div>
<?php endif; ?>
<!-- FORGOT EMAIL 2FA MODAL -->
<?php
if ($show_forgot_email_2fa):?>
<div id="forgotEmailModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">

        <a class="close-forgot" href="<?=APP_BASE_URL?>/login">X</a>

        <h2>Forgot Email</h2>
        <?= App\Helpers\FlashMessage::render() ?>
        <p>Please enter the 6 digit code sent to the specified number.<br><br>

        <form id="forgotEmailForm" method="POST" action="<?= APP_BASE_URL ?>/login/forgot-email-2fa">
            <label>2FA CODE</label>
            <input type="text" name="code" placeholder="000000" required>

            <div class="forgot-btn-row">
                <a class="forgot-change" href="<?= APP_BASE_URL ?>/login">Cancel</a>
                <button type="submit" class="forgot-send">Send Message</button>
            </div>
        </form>

    </div>
</div>
<?php endif; ?>
<!-- LOGIN_2FA -->
<?php if ($show2fa_login): ?>
<div class="twofa-modal-overlay">
  <div class="twofactor-container">
        <a class="close-forgot" href="<?=APP_BASE_URL?>/login">X</a>

    <h1>Two-Factor Authentication</h1>

    <?= App\Helpers\FlashMessage::render() ?>
    <p>Please enter the 6-digit code sent to your phone.</p>

    <form method="POST" action="<?= APP_BASE_URL ?>/login/2fa">
      <input type="text" name="code" id="code" maxlength="6" placeholder="XXXXXX" required style="color:white;">

      <div>
        <button type="submit" class="verify">Verify</button>
        <button type="button" class="resend">Resend Code</button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>
<!-- New Email MODAL -->
<?php
if ($show_new_email):?>
<div id="new-email-modal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">

        <!-- Use same close button class -->
        <a class="close-forgot" href="<?=APP_BASE_URL?>/login">X</a>

        <h2>New Email</h2>

        <?= App\Helpers\FlashMessage::render() ?>
        <p>Please enter a new email.</p>

        <form id="newEmailForm" method="POST" action="<?= APP_BASE_URL ?>/login/new-email">

            <label>New Email:</label>
            <input type="text" name="email" placeholder="Enter new email" required>

            <label>Confirm New Email:</label>
            <input type="text" name="conf_email" placeholder="Confirm new email" required>

            <div class="forgot-btn-row">
                <!-- Use same button styles -->
                <button type="submit" class="forgot-send">Send</button>
                <button type="button" class="forgot-change">Cancel</button>
            </div>
        </form>

    </div>
</div>
<?php endif; ?>
<!-- 2-factor MODAL -->
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
