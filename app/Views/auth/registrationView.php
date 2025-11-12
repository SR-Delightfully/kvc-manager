<?php
use App\Helpers\ViewHelper;
$page_title = 'Registration Page';
ViewHelper::loadHeader($page_title);
?>

<div class="register-container">
  <h1>Registration</h1>
//TODO: add the action
  <form method="POST" action="<?= APP_BASE_URL ?>/register">
    <label for="user_role">User Role</label>
    <select id="user_role" name="role" required>
      <option value="">-- Select Role --</option>
      <option value="admin">Admin</option>
      <option value="user">Employee</option>
    </select>

    <label for="first_name">First Name</label>
    <input type="text" id="first_name" name="first_name" placeholder="Enter first name" required>

    <label for="last_name">Last Name</label>
    <input type="text" id="last_name" name="last_name" placeholder="Enter last name"required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="Enter email address"required>

    <label for="phone">Phone</label>
    <input type="number" id="phone" name="phone" placeholder="Enter phone number" required>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Enter password" required>

    <label for="user_dc">Date Created</label>
    <input type="date" id="user_dc" name="user_dc" required>

    <label for="user_status">User Status</label>
    <select id="user_status" name="user_status" required>
      <option value="">-- Select Status --</option>
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
      <option value="suspended">Suspended</option>
    </select>

    <div>
      <button type="submit">Sign In</button>
      <button type="reset">Clear</button>
    </div>
  </form>
</div>

<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
