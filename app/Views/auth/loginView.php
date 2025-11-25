<?php
use App\Helpers\ViewHelper;
$page_title ='Login page';
ViewHelper::loadHeader($page_title,false);
?>

<div class="login-container">


    <div class="left-panel">
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




    <div class="form-panel">

    <div class="center-logo">
        <div class="logo-circle">VKC</div>
    </div>
        <form method="POST" action="">
            <label for="email">Email Address</label>
            <input type="text" name="email" id="email" required>
            <a href="#">Forgot Email?</a>
<br>
<br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <a href="#">Forgot Password?</a>

            <div class="button-row">
                <button type="submit" class="signup-btn">Sign Up</button>
                <button type="submit" class="signin-btn">Sign In</button>
            </div>
        </form>
    </div>




</div>
    <!-- FOOTER BAR BUT only for the login page so idk if we should have a separate file/footer for it -->
<div class="lang-switch">
    <div class="left">
        <a href="">EN</a> - <a href="">FR</a>
    </div>
    <div class="center">
        # of registered employees, join the team, register today.
    </div>
    <div class="right">
        <span id="datetime-display"></span>
    </div>
</div>

<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
