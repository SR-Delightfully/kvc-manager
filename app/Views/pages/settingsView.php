<?php

use App\Helpers\ViewHelper;
use App\Helpers\UserContext;

$page_title = 'Settings Page';

$currentUser = UserContext::getCurrentUser();

$isAdmin = UserContext::isAdmin();
$isEmployee = UserContext::isEmployee();
?>
<div id="page-wrapper" class="page">
    <div id="page-content">
        <ul id="dashboard" class="center-v">
            <li id="user-profile-card" class="metallic tall-widget profile-card2">
                <h2 class="metallic">User Profile</h2>
                <div class="user-profile">
                    <div class="user-avatar avatar2">
                        <img src="https://i.imgur.com/9BPfl0c.png" 
                             alt="employee image placeholder, to be replaced with the logged-in user's image">
                    </div>
                    <span>
                        <h5 class="user-fname"><?= e($currentUser['user_fname'] ?? 'FirstName') ?></h5>
                        <h5 class="user-lname"><?= e($currentUser['user_lname'] ??  'LastName') ?></h5>
                    </span>
                    <h6 class="user-email"><?= e($currentUser['user_email'] ?? 'example@email.ca') ?></h6>

                    <div class="user-role-tag">
                        <p>user's role:</p>
                        <?= e($currentUser['user_role'] ?? 'employee') ?>
                    </div>

                    <div class="user-status-tag status-<?= strtolower($currentUser['user_status'] ?? 'active') ?>">
                        <p>user's employment status:</p>
                        <?= e($currentUser['user_status'] ?? 'active') ?>
                    </div>
                </div>
            </li>
            
            <li id="user-details-card" class="small-widget">
                <h2 class="metallic settings-heading">Personal Information</h2>
                <div class="user-details card">
                    <form id="user-details-form" method="POST" action="/update-user">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" 
                                   value="<?= e($currentUser['user_fname']) ?>">
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" 
                                   value="<?= e($currentUser['user_lname']) ?>">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" 
                                   value="<?= e($currentUser['user_email']) ?>">
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" 
                                   value="<?= e($currentUser['user_phone'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <input type="text" value="<?= e($currentUser['user_role']) ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label>Account Status</label>
                            <input type="text" value="<?= e($currentUser['user_status']) ?>" disabled>
                        </div>

                        <button class="btn btn-primary" type="submit">Save Changes</button>
                    </form>
                </div>
            </li>


            <li class="mini-widget">
                <div class="user-preferences card">

                    <h3 class="settings-heading">Preferences</h3>
                    <div class="form-group">
                        <label>Theme</label>
                        <select id="theme-selector" name="theme">
                            <option value="default">Default</option>
                            <option value="dark-mode">Dark</option>
                            <option value="light-mode">Light</option>
                            <option value="blue-mode">Blue</option>
                            <option value="red-mode">Red</option>
                            <option value="green-mode">Green</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Notifications</label>
                        <div class="checkbox-group">
                            <label><input type="checkbox" /> Email Alerts</label>
                            <label><input type="checkbox" /> Shift Reminders</label>
                            <label><input type="checkbox" /> Team Updates</label>
                        </div>
                    </div>

                    <h4>Change Password</h4>
                    <form id="password-change-form" method="POST" action="/change-password">
                        <div class="form-group">
                            <label>Current Password</label>
                            <input type="password" name="old_password">
                        </div>

                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="new_password">
                        </div>

                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input type="password" name="confirm_password">
                        </div>

                        <button class="btn btn-warning" type="submit">Update Password</button>
                    </form>
                </div>
            </li>

        </ul>
    </div>
</div>
