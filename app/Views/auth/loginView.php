<?php
use App\Helpers\ViewHelper;
$page_title ='Login page';
ViewHelper::loadHeader($page_title);
?>

<div class="login-container">
   <div class="lang-switch">
        <a href="">EN</a>
        <a href="">FR</a>
    </div>
  <div class="logo-section">
    <div class="logo-circle">KVC</div>
  </div>


  <div class="form-section">
    <form method="POST" action="">
      <label for="email">Email Address</label>
      <input type="text" name="email" id="email" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" required>

      <a href="#">Forgot Password?</a>

      <div>
        <button type="submit">Sign In</button>
        <button type="submit">Sign Up</button>
      </div>
    </form>
  </div>
</div>

<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
