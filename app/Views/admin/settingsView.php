<?php

use App\Helpers\ViewHelper;
use App\Helpers\UserContext;

UserContext::init();
// $currentUser = UserContext::getCurrentUser() ?? ;
// $currentUser = SettingsController::getFirstAdminForTest();
$currentUser = $data['defaultUser'] ?? null;
$page_title = 'User Settings';
// $show_settings_edit = $show_settings_edit ?? null;
$show_settings_edit = isset($_GET['edit']);
ViewHelper::loadHeader($page_title, true);

?>

<!--
<div class="profile-wrapper2">
<div class="profile-card2">


    <div class="info4">
        <h2 class="name" ><?= $currentUser['first_name'] ?> <?= $currentUser['last_name'] ?></h2>
        <p class="detail" ><strong>Team:</strong> <?= $currentUser['phone'] ?></p>
    </div>
</div>

</div> -->

<main class="page">
<div class="profile-wrapper2">
    <div class="profile-card2">


        <div class="info2">
            <h2 class="name"><?= $currentUser['first_name'] ?> <?= $currentUser['last_name'] ?></h2>
            <p class="detail"><strong>Phone:</strong> <?= $currentUser['phone'] ?></p>
            <p class="detail"><strong>Email:</strong> <?= $currentUser['email'] ?></p>
        </div>
        <div class="avatar2">
            <img src="/kvc-manager/public/assets/images/profile2.png" alt="Profile Picture">
        </div>
        <!-- <button class="edit-btn2">Edit My Info</button> -->
        <a target=_blank href="?edit=1" class="edit-btn2" id="editInfoBtn">Update My information</a>

    </div>

</div>

<?php
if ($show_settings_edit): ?>
    <div id="userSettingsModal" class="forgot-modal-overlay">
        <div class="forgot-modal-box">
            <a target=_blank href="<?= APP_BASE_URL ?>/settings" class="close-forgot">X</a>
            <h2>Edit Personal Info</h2>
            <form action="<?= APP_BASE_URL ?>/settings/edit/<?= $currentUser['user_id'] ?>" method="POST">
                <input type="hidden" value="<?= $admin_to_edit['user_id'] ?>" name="user_id">
                <div class="quick-add-title">Enter Your New Info :</div>

                <label for="first_name">First Name: </label>
                <input value="<?= $currentUser['first_name'] ?>" name="first_name" type="text" placeholder="First Name:">

                <label for="last_name">Last Name: </label>
                <input value="<?= $currentUser['last_name'] ?>" name="last_name" type="text">

                <label for="email">Email: </label>
                <input value="<?= $currentUser['email'] ?>" name="email" type="text">

                <label for="phone">Phone Number: </label>
                <input value="<?= $currentUser['phone'] ?>" name="phone" type="text">

                <button type="submit">Update My information</button>
                <a target=_blank href="<?= APP_BASE_URL ?>/settings">Cancel</a>
            </form>

        </div>
    </div>
</main>
<?php endif; ?>

<!-- <button class="btn3" id="psw-update-btn">Update Password</button> -->
<?php
ViewHelper::loadFooter();
?>
