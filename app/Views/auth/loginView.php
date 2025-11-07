<?php
use App\Helpers\ViewHelper;
$page_title ='Login page';
ViewHelper::loadHeader($page_title);
?>
<form method="POST"
//TODO: add php file to action
action="">
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email" required>
    //i dont think we should need a 'forgot your email?'

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>
<a href="#">Forgot password?</a>
    <button type="submit">Sign In</button>
    <button type="submit">Sign Up</button>

</form>
<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
