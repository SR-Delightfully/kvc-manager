<?php
use App\Helpers\ViewHelper;

$page_title = 'Registration Page';
ViewHelper::loadHeader($page_title,false);
?>

<!-- tips on how to html / css -->

 <!-- > Don't hesitate to use styles/classes writing in te Global-Styles.css, these are intended to be used all throughout the project. -->

<!-- > If there is only one single copy of the element, then give it an Id with its identifying name (instead of a class) -->

<!-- > Ids should be specific, Classes can be generic -->

<div class="login-container">

    <!-- LEFT PANEL (same as login) -->
    <div class="left-panel">
        <div class="left-info-box">
            <h1 class="brand-title">VKC</h1>
            <h3 class="brand-sub">Kian · Vito · Colton</h3>

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

    <!-- RIGHT PANEL (registration form) -->
    <div class="form-panel">

        <div class="center-logo">
            <div class="logo-circle">VKC</div>
        </div>

        <form method="POST" action="<?= APP_BASE_URL ?>/register">

            <?= App\Helpers\FlashMessage::render() ?>

            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" required style="color:white;">

            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" required style="color:white;">

            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" required style="color:white;">

            <label for="phone">Phone Number</label>
            <input type="tel" name="phone" id="phone" required style="color:white;">

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required style="color:white;">

            <label for="password-confirm">Confirm Password</label>
            <input type="password" name="password-confirm" id="password-confirm" required style="color:white;">

            <label for="code">Registration Code</label>
            <input type="text" name="code" id="code" required style="color:white;">

            <div class="button-row">
                <a class="btn btn-success" href="<?= APP_BASE_URL ?>/login">Login</a>
                <button type="submit" class="signin-btn">Register</button>
            </div>
        </form>

    </div>
</div>
<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
