<?php
use App\Helpers\ViewHelper;
use App\Helpers\LocalizationHelper;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$currentLang = $_SESSION['lang'] ?? 'en';
LocalizationHelper::setLanguage($currentLang);

$page_title = $page_title ?? 'KVC Manager';
$isSideBarShown = $isSideBarShown ?? true;
$isFooterShown = $isFooterShown ?? true;
?>

<?php ViewHelper::loadHeader($page_title); ?>

<?php if ($isSideBarShown): ?>
    <?php ViewHelper::loadSideBar(); ?>
<?php endif; ?>

<div id="main-content" class="center-v">
    <?php require $contentView; ?>
</div>

<?php
ViewHelper::loadJsScripts();
// adding userCount prop so we can display that number on the footer :)
ViewHelper::loadFooter(['userCount' => $userCount ?? 0]);
?>
