<?php

use App\Helpers\ViewHelper;
$page_title = 'Welcome to KVC Manager!';
ViewHelper::loadHeader($page_title);
?>
<div id="dashboard" class="center-v">
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
// ViewHelper::loadNavbar();

?>
