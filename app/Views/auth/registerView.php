<?php
use App\Helpers\ViewHelper;

$page_title = 'Registration Page';
ViewHelper::loadHeader($page_title, false);
?>

<!-- tips on how to html / csss -->

 <!-- > Don't hesitate to use styles/classes writting in te Global-Styles.css, these are intended to be used all throughout the project. -->

<!-- > If there is only one single copy of the element, then give it an Id with its identifying name (instead of a class) -->

<!-- > Ids should be specific, Classes can be generic -->

<div id="registration-page-wrapper" class="page">
    <div id="registration-page-content" class="display-flex-row">

        <!-- Left Info Panel -->
        <div id="registration-page-about" class="display-flex-col flex-center">
            <div id="registration-page-info">
                <h1>VKC</h1>
                <h2>Vito - Kian - Colton</h2>
                <p>
                    Registering for an account will grant you access to extensive data displays, easy work log process,
                    and access to your work schedule all in one place.
                </p>
                <p>
                    This web application is intended to be used only by employees of the company.
                    If you are not an existing employee, or a new hire then see below.
                </p>
                <p>
                    VKC is a new company with an ever-expanding workforce. For information on how to join the team,<br>
                    please contact us <a href="#">here</a><br>or<br> check out our <a href="#">job postings</a>.
                </p>
            </div>

            <div id="registration-page-socials">
                <!-- Add social media links if needed -->
            </div>
        </div>

        <!-- Right Registration Form -->
        <div id="register">
            <div id="registration-form-wrapper" class="auth-form-wrapper metallic">
                <form id="registration-form" method="POST" action="<?= APP_BASE_URL ?>/register">
                    <?= App\Helpers\FlashMessage::render() ?>
                    <h2>Registration intended for employees only.</h2>

                    <div id="registration-form-names" class="form-grid-2">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" placeholder="Enter first name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" placeholder="Enter last name" required>
                        </div>
                    </div>

                    <div id="registration-form-contact" class="form-grid-2">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter email address" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>
                        </div>
                    </div>

                    <div id="registration-form-password" class="form-grid-2">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter password" required>
                        </div>
                        <div class="form-group">
                            <labe   l for="password-confirm">Password Confirmation</label>
                            <input type="password" id="password-confirm" name="password-confirm" placeholder="Re-enter password" required>
                        </div>
                    </div>
                    <br>
                    <br>

                    <div id="registration-form-code" class="form-group">
                        <label for="code">Registration Code</label>
                        <input type="text" id="code" name="code" placeholder="Enter Code" required>
                    </div>

                    <div id="registration-form-buttons">
                        <button type="submit" class="btn btn-primary btn-wide">Register</button>
                        <button type="reset" class="btn btn-secondary btn-wide">Clear</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
