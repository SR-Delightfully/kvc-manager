<?php
use App\Helpers\ViewHelper;

$page_title = 'Registration Page';
ViewHelper::loadHeader($page_title,false);
?>

<!-- tips on how to html / csss -->

 <!-- > Don't hesitate to use styles/classes writting in te Global-Styles.css, these are intended to be used all throughout the project. -->

<!-- > If there is only one single copy of the element, then give it an Id with its identifying name (instead of a class) -->

<!-- > Ids should be specific, Classes can be generic -->


<!-- <div class="register-container">
  <div class="sidebar">
      <div>
        <h1>VKC</h1>
        <p>Registration intended for employees only!</p>
        <p>
          For more information on how to join the team, please contact us
          <a href="#">here</a> or check out our <a href="#">job postings</a>.
        </p>
      </div>
      <div class="socials">
        [insert social media links here]
      </div>
  </div>
<div class="form-wrapper">
  <form class="register-form" method="POST" action="<?= APP_BASE_URL ?>/register">
      <h1>Register</h1>

      <label for="user_role">User Role</label>
      <select id="user_role" name="role" required>
          <option value="">-- Select Role --</option>
          <option value="admin">Admin</option>
          <option value="user">Employee</option>
      </select>

      <label for="first_name">First Name</label>
      <input type="text" id="first_name" name="first_name" placeholder="Enter first name" required>

      <label for="last_name">Last Name</label>
      <input type="text" id="last_name" name="last_name" placeholder="Enter last name" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Enter email address" required>

      <label for="phone">Phone</label>
      <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>

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

      <div class="buttons">
          <button type="submit">Register</button>
          <button type="reset">Clear</button>
      </div>
  </form>
</div>
</div>
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
</div> -->


<div id="registration-page-container" class="page display-flex-row">
  <div id="registration-page-content" class="display-flex-row flex-center">
      <div id="registration-page-info">
        <h1>VKC</h1>
        <p>Registration intended for employees only! <br>
          For more information on how to join the team, please contact us
          <a href="#">here</a> or check out our <a href="#">job postings</a>.
        </p>
      </div>
      <div id="registration-page-socials">
        <!-- [insert social media links here] -->
      </div>
  </div>
  <div id="registration-form-wrapper">
  <form id="registration-form" method="POST" action="<?= APP_BASE_URL ?>/register">
      <h1>Register</h1>
      <!-- Any user signing up should be an employee role. -->
      <!-- Only admins can edit a user's role to make them also an admin. -->

      <!-- <label for="user_role">User Role</label>
      <select id="user_role" name="role" required>
          <option value="">-- Select Role --</option>
          <option value="admin">Admin</option>
          <option value="user">Employee</option>
      </select> -->

      <div id="registration-form-names">
        <span>
          <label for="first_name">First Name</label>
          <input type="text" id="first_name" name="first_name" placeholder="Enter first name" required>
        </span>
        <span>
          <label for="last_name">Last Name</label>
         <input type="text" id="last_name" name="last_name" placeholder="Enter last name" required>
        </span>
      </div>

      <div id="registration-form-contact">
        <span>
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter email address" required>
        </span>
        <span>
          <label for="phone">Phone</label>
          <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>
        </span>
      </div>

      <div id="registration-form-password">
        <span>
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter password" required>
        </span>
        <!-- When Registering a user, it is important to ensure that the user -->
        <!-- did not make any mistakes in their password, to do so a password -->
        <!-- confirmation is required to verify that the user will remember it -->
        <span>
          <label for="password-confirm">Password</label>
          <input type="password" id="password-confirm" name="password-confirm" placeholder="Re-enter password" required>
        </span>
      </div>

      <!-- Date created is an attribute that we will automatically generate -->

      <!-- <label for="user_dc">Date Created</label>
      <input type="date" id="user_dc" name="user_dc" required> -->

      <!-- Can be replaced with the users birthday instead? -->
      <!-- Con: We would have to add another attribute to the user table -->
      <!-- Pro: Highlighting birthdays can increase work moral and team spirit -->
      <!-- <label for="user_dc">Birth Date</label>
      <input type="date" id="user_bday" name="user_bday" required> -->

      <!-- User Status would also be autogenerated. -->
      <!-- The user should not be allowed to manipulate this attribute at all -->

      <!-- <label for="user_status">User Status</label>
      <select id="user_status" name="user_status" required>
          <option value="">-- Select Status --</option>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
          <option value="suspended">Suspended</option>
      </select> -->

      <div id="registration-form-buttons">
          <button type="submit">Register</button>
          <button type="reset">Clear</button>
      </div>
  </form>
</div>
</div>
<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
