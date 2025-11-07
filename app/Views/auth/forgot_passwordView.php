<?php
use App\Helpers\ViewHelper;
$page_title ='Password Reset';
ViewHelper::loadHeader($page_title);
?>
<form method="POST"
//TODO: add php file to action
action="">
 <label for="current_password">Current Password</label>
    <input type="password" name="current_password" id="current_password" required>

 <label for="new_password">New Password</label>
    <input type="password" name="new_password" id="new_password" required>

    <label for="confirm_password">Confirm Password</label>
    <input type="password" name="confirm_password" id="confirm_password" required>

    <button type="submit">RESET PASSWORD</button>


</form>
<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
