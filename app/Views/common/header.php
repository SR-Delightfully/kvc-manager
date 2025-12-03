<!DOCTYPE html>
<html lang="en" data-theme="light-mode">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link rel="stylesheet" href="/kvc-manager/public/assets/css/00-Global-Styles.css">
    <link rel="stylesheet" href="/kvc-manager/public/assets/css/01-Navbar-Styles.css">
    <link rel="stylesheet" href="/kvc-manager/public/assets/css/02-Header-Styles.css">
    <link rel="stylesheet" href="/kvc-manager/public/assets/css/03-Dashboard-Styles.css">
     <link rel="stylesheet" href="/kvc-manager/public/assets/css/04-Login-Styles.css">
 <link rel="stylesheet" href="/kvc-manager/public/assets/css/05-TwoFactor-Styles.css">
  <link rel="stylesheet" href="/kvc-manager/public/assets/css/06-Reset-Styles.css">
   <link rel="stylesheet" href="/kvc-manager/public/assets/css/07-Register-Styles.css">

    <link rel="stylesheet" href="/kvc-manager/public/assets/css/08-Settings-Styles.css">
    <!-- bootstrap -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- it wil not show the header if in the view pahe next to the page title its set to false cuz in login and register view we dont need it -->
   <?php if (!isset($GLOBALS['SHOW_HEADER']) || $GLOBALS['SHOW_HEADER'] === true): ?>
<div id="page-wrapper">
    <header id="page-header" class="border-3">
        <h1>KVC Manager</h1>
        <div class="display-flex-row ribbon">
            <h2>Welcome back,</h2>
            <h3>['user_fname'] ['user_lname']</h3>
        </div>
    </header>
</div>
<?php endif; ?>

