<?php

use App\Helpers\ViewHelper;

$page_title = 'Database Overview';
ViewHelper::loadHeader($page_title, true);
?>
<div class="profile-wrapper2">
<div class="profile-card2">


    <div class="info2">
        <h2 class="name">Full Name</h2>
        <p class="detail"><strong>Phone:</strong> 123-456-7890</p>
        <p class="detail"><strong>Email:</strong> abc@example.com</p>
    </div>
<div class="avatar2">
        <img src="/kvc-manager/public/assets/images/profile.png" alt="Profile Picture">
    </div>
    <button class="edit-btn2">Edit My Info</button>
</div>
</div>
<?php
ViewHelper::loadFooter();
?>
