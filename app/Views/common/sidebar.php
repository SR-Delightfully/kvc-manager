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

$tabs = [
    "tab1" => ["key" => "time_attendance", "icon" => "🕓"],
    "tab2" => ["key" => "work_log",       "icon" => "🔧"],
];

if (UserContext::isLoggedIn() && UserContext::isAdmin()) {
    $tabs['tab3'] = ["key" => "admin_panel", "icon" => "🛠️"];
}

$tabs['tab4'] = ["key" => "settings", "icon" => "⚙️"];
?>

<nav id="nav-bar" class="border-3 center-v display-flex-col">
    <div id="nav-bar-inner" class="display-flex-col">
        <!-- Replace with img when logo is received:<img src=""> -->
        <div id="logo">
            <p>KVC</p>
        </div>

        <ol id="tabs" class="display-flex-col">
            <?php foreach ($tabs as $key => $tab) { ?>
                <li id="<?= $key ?>" class="tab">
                    <span class="tab-icon"><?= $tab['icon'] ?></span>
                    <span class="tab-label"><?= LocalizationHelper::get("sidebar_content." . $tab['key']) ?></span>
                </li>
            <?php } ?>
        </ol>
        <button id="btn-quit"><?= LocalizationHelper::get('sidebar_content.quit') ?></button>

        <div id="language-switcher" class="mt-2 display-flex">
            <?php foreach (['en','fr'] as $lang): ?>
                <a href="?lang=<?= $lang ?>" 
                class="<?= $currentLang === $lang ? 'active-lang' : '' ?>">
                    <?= strtoupper($lang) ?>
                </a>
            <?php endforeach; ?>
        </div>
</nav>