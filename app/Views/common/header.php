<?php
$currentUser = null;
    use App\Helpers\UserContext;

    UserContext::init();
    $currentUser = UserContext::getCurrentUser();
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

function e($value)
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light-mode">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= isset($page_title) ? e($page_title) : 'KVC Manager' ?></title>

    <!-- bootstrap -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/public/assets/css/00-Global-Styles.css">
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/public/assets/css/01-Element-Styles.css">
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/public/assets/css/02-Register-Styles.css">
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/public/assets/css/03-Login-Styles.css">
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/public/assets/css/04-NavBar-Styles.css">
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/public/assets/css/05-Header-Styles.css">
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/public/assets/css/06-Dashboard-Styles.css">
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/public/assets/css/07-Settings-Styles.css">
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/public/assets/css/08-Reports-Styles.css">
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/public/assets/css/09-Twofactor-Styles.css">



</head>

<body>
    <?php if (!isset($GLOBALS['SHOW_HEADER']) || $GLOBALS['SHOW_HEADER'] === true): ?>
    <div id="header-wrapper">
        <header id="header">
            <h1>VKC Manager</h1>

            <div class="display-flex-row ribbon">
                <h2>Welcome back,</h2>
                <h3 >
                    <?= e($currentUser['first_name'] ?? 'Unidentified User') ?> <?= e($currentUser['last_name'] ?? '') ?>
                </h3>
                <h3><?= date('F j, Y') ?></h3>
            </div>

        </header>
    </div>
    <?php endif; ?>
