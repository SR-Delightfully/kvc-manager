<?php

use App\Helpers\LocalizationHelper;
use App\Helpers\UserContext;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

UserContext::init();
$currentUser = UserContext::getCurrentUser();

$currentLang = $_SESSION['lang'] ?? 'en';
LocalizationHelper::setLanguage($currentLang);
$langs = ['en', 'fr'];
$tabs = [];

if (UserContext::isLoggedIn() && UserContext::isAdmin()) {
    $tabs['tab1'] = ["key" => "Admin", "icon" => "🛠️"];
}

$tabs['tab2'] = ["key" => "home", "icon" => "<i class='bi bi-columns-gap'></i>"];
// $tabs['tab3'] = ["key" => "products", "icon" => "<i class='bi bi-box-seam'></i>"];
$tabs['tab4'] = ["key" => "schedule", "icon" => "<i class='bi bi-calendar-week'></i>"];
$tabs['tab5'] = ["key" => "reports", "icon" => "<i class='bi bi-file-earmark-bar-graph'></i>"];
$tabs['tab6'] = ["key" => "work", "icon" => "<i class='bi bi-wrench'></i>"];
$tabs['tab7'] = ["key" => "settings", "icon" => "<i class='bi bi-gear'></i>"];

?>

<nav id="nav-bar">
    <div id="logo">
        <p>KVC</p>
    </div>
    <div id="nav-bar-inner">
        <!-- Replace with img when logo is received:<img src=""> -->


        <ul id="tabs">
            <?php foreach ($tabs as $key => $tab) { ?>
                <li id="<?= $key ?>" class="tab">
                    <a href="./<?= $tab['key'] ?>">
                        <span class="tab-icon"><?= $tab['icon'] ?></span>
                        <span class="tab-label"><?= LocalizationHelper::get("sidebar_content." . $tab['key']) ?></span>
                        <span class="tab-dropdown-btn"><i class="bi bi-chevron-down"></i></span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div id="language-control" class="mt-2 display-flex">
        <?php foreach ($langs as $lang): ?>
            <a href="?lang=<?= $lang ?>"
                class="<?= $currentLang === $lang ? 'active-lang' : '' ?>">
                <?= strtoupper($lang) ?>
            </a>

        <?php endforeach; ?>
    </div>
</nav>