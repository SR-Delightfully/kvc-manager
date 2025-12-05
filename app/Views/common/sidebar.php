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
// if (UserContext::isLoggedIn() && UserContext::isAdmin()) {
// TODO: update routes, better clarify subroute styles
    $tabs['tab1'] = [
        "key" => "admin",
        "icon" => "<i class='bi bi-person-gear'></i>",
        "subtabs" => [
            ["label" => "Dashboard", "url" => "./admin"],
            ["label" => "<b>Employee Management</b>", "url" => "./admin/users"],
            ["label" => "Employees", "url" => "./admin/type"],
            ["label" => "Schedule", "url" => "./admin/type"],
            ["label" => "Shifts", "url" => "./admin/type"],
            ["label" => "<b>Station Management</b>", "url" => "./admin/product"],
            ["label" => "Stations", "url" => "./admin/product"],
            ["label" => "Teams", "url" => "./admin/product"],
            ["label" => "Team Members", "url" => "./admin/product"],
            ["label" => "<b>Products Management</b>", "url" => "./admin/colour"],
            ["label" => "Products", "url" => "./admin/product"],
            ["label" => "Product Types", "url" => "./admin/product"],
            ["label" => "Product Variants", "url" => "./admin/product"],
            ["label" => "Product Colours", "url" => "./admin/product"],
            ["label" => "<b>Storage Management</b>", "url" => "./admin/type"],
            ["label" => "Pallets", "url" => "./admin/product"],
            ["label" => "Totes", "url" => "./admin/product"],
        ]
    ];
// }

$tabs['tab2'] = ["key" => "home", "icon" => "<i class='bi bi-columns-gap'></i>"];
$tabs['tab4'] = ["key" => "schedule", "icon" => "<i class='bi bi-calendar-week'></i>"];
$tabs['tab5'] = ["key" => "reports", "icon" => "<i class='bi bi-file-earmark-bar-graph'></i>"];
$tabs['tab6'] = ["key" => "work", "icon" => "<i class='bi bi-wrench'></i>"];
$tabs['tab7'] = ["key" => "settings", "icon" => "<i class='bi bi-gear'></i>"];

$currentPath = $_SERVER['REQUEST_URI'];

?>

<nav id="nav-bar">
    <div id="logo">
        <p>KVC</p>
    </div>

    <div id="nav-bar-inner">
        <ul id="tabs">
            <?php foreach ($tabs as $key => $tab) { ?>
                <li id="<?= $key ?>" class="tab <?= isset($tab['subtabs']) ? 'tab-with-submenu' : '' ?>">
                    <a href="./<?= $tab['key'] ?>" class="tab-main-btn">
                        <span class="tab-icon"><?= $tab['icon'] ?></span>
                        <span class="tab-label"><?= LocalizationHelper::get("sidebar_content." . $tab['key']) ?></span>
                        <!-- TODO: Switch logic for open close, this looks kinda ugl😭😭 -->
                        <?php if (isset($tab['subtabs'])): ?>
                            <span class="tab-dropdown-btn"> <i class="bi bi-chevron-right"></i></span>
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
            <a href="?lang=<?= $lang ?>"
                class="<?= $currentLang === $lang ? 'active-lang' : '' ?>">
                <?= strtoupper($lang) ?>
            </a>
        <?php endforeach; ?>
    </div>
</nav>

<script>
const currentPath = "<?= $currentPath ?>";

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".tab-with-submenu").forEach(tab => {
        const submenu = tab.querySelector(".submenu");
        const arrow = tab.querySelector(".tab-dropdown-btn i");

        if (!submenu) return;

        // Hover behavior
        tab.addEventListener("mouseenter", () => {
            submenu.style.maxHeight = submenu.scrollHeight + "px";
            submenu.style.opacity = 1;
            arrow.style.transform = "rotate(180deg)";
        });

        tab.addEventListener("mouseleave", () => {
            if (!tab.classList.contains("active-route")) {
                submenu.style.maxHeight = "0";
                submenu.style.opacity = 0;
                arrow.style.transform = "rotate(0deg)";
            }
        });

        // Auto-expand for active route
        const match = [...submenu.querySelectorAll("a")].some(a =>
            currentPath.startsWith(a.getAttribute("href"))
        );

        if (match) {
            tab.classList.add("active-route");
            submenu.style.maxHeight = submenu.scrollHeight + "px";
            submenu.style.opacity = 1;
            arrow.style.transform = "rotate(180deg)";
        }
    });
});
</script>
