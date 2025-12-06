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

// Admin tab with submenu
$tabs['tab1'] = [
    "key" => "admin",
    "icon" => "<i class='bi bi-person-gear'></i>",
    "subtabs" => [
        ["label" => "Dashboard", "url" => "./admin"],
        ["label" => "Employee Management", "url" => "./admin/users"],
        ["label" => "<sup>Employees</sup>", "url" => "./admin/type"],
        ["label" => "<sup>Schedule</sup>", "url" => "./admin/type"],
        ["label" => "<sup>Shifts</sup>", "url" => "./admin/type"],
        ["label" => "Station Management", "url" => "./admin/product"],
        ["label" => "<sup>Stations</sup>", "url" => "./admin/product"],
        ["label" => "<sup>Teams</sup>", "url" => "./admin/product"],
        ["label" => "<sup>Team Members</sup>", "url" => "./admin/product"],
        ["label" => "Products Management", "url" => "./admin/colour"],
        ["label" => "<sup>Products</sup>", "url" => "./admin/product"],
        ["label" => "<sup>Product Types</sup>", "url" => "./admin/product"],
        ["label" => "<sup>Product Variants</sup>", "url" => "./admin/product"],
        ["label" => "<sup>Product Colours</sup>", "url" => "./admin/product"],
        ["label" => "Storage Management", "url" => "./admin/type"],
        ["label" => "<sup>Pallets</sup>", "url" => "./admin/product"],
        ["label" => "<sup>Totes</sup>", "url" => "./admin/product"],
    ]
];

$tabs['tab2'] = ["key" => "home", "icon" => "<i class='bi bi-columns-gap'></i>"];
$tabs['tab4'] = ["key" => "schedule", "icon" => "<i class='bi bi-calendar-week'></i>"];
$tabs['tab5'] = ["key" => "reports", "icon" => "<i class='bi bi-file-earmark-bar-graph'></i>"];
$tabs['tab6'] = ["key" => "work", "icon" => "<i class='bi bi-wrench'></i>"];
$tabs['tab7'] = ["key" => "settings", "icon" => "<i class='bi bi-gear'></i>"];

$currentPath = $_SERVER['REQUEST_URI'];

?>

<nav id="nav-bar">
    <div id="sidebar-toggle"><i class="bi bi-list"></i></div>
    <div id="logo" class="expanded metallic-bg"><p>KVC</p></div>

    <div id="nav-bar-inner">
        <ul id="tabs">
            <?php foreach ($tabs as $key => $tab) { ?>
                <li id="<?= $key ?>" class="tab <?= isset($tab['subtabs']) ? 'tab-with-submenu' : '' ?> expanded">
                    <a href="./<?= $tab['key'] ?>" class="tab-main-btn">
                        <span class="tab-icon"><?= $tab['icon'] ?></span>
                        <span class="tab-label"><?= LocalizationHelper::get("sidebar_content." . $tab['key']) ?></span>
                        <?php if (isset($tab['subtabs'])): ?>
                            <span class="tab-dropdown-btn"><i class="bi bi-chevron-right"></i></span>
                        <?php else: ?>
                            <span class="tab-dropdown-btn"><i class="bi bi-chevron-down"></i></span>
                        <?php endif; ?>
                    </a>
                    <?php if (isset($tab['subtabs'])): ?>
                        <ul class="submenu">
                            <?php foreach ($tab['subtabs'] as $sub): ?>
                                <li class="subtab-item">
                                    <a href="<?= $sub['url'] ?>"><?= $sub['label'] ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php } ?>
        </ul>
    </div>

    <div id="language-control" class="mt-2 display-flex">
        <?php foreach ($langs as $lang): ?>
            <a href="?lang=<?= $lang ?>" class="<?= $currentLang === $lang ? 'active-lang' : '' ?>">
                <?= strtoupper($lang) ?>
            </a>
        <?php endforeach; ?>
    </div>
</nav>
