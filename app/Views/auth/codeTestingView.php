

<?php

use App\Helpers\ViewHelper;
$code = $data['code'];

$page_title ='Login page';
ViewHelper::loadHeader($page_title,false);
?>

<div><?= $code ?></div>

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
