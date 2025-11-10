<!DOCTYPE html>
<html lang="en" data-theme="light-mode">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="./public/assets/css/00-Global-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/01-Navbar-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/02-Header-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/03-Dashboard-Styles.css">
</head>

<?php

$tabs = array(
    "tab1" => ["Time & Attendance", "🕓"],
    "tab2" => ["Work Log", "🔧"],
    "tab3" => ["Employees", "🪪"],
    "tab4" => ["Settings", "⚙️"],
);

?>

<body>
    <div id="page-wrapper">
        <header id="page-header" class="border-3">
            <h1>KVC Manager</h1>
            <div class="display-flex-row ribbon">
                <h2>Welcome back,</h2>
                <h3>['user_fname'] ['user_lname']</h3>
            </div>
        </header>

        <nav id="nav-bar" class="border-3 center-v display-flex-col">
            <div id="nav-bar-inner" class="display-flex-col">
                <!-- Replace with img when logo is received:<img src=""> -->
                <div id="logo">
                    <p>KVC</p>
                </div>

                <ol id="tabs" class="display-flex-col">
                    <?php foreach ($tabs as $key => $tab) { ?>
                        <li id="<?= $key ?>" class="tab">
                            <span class="tab-icon"><?= $tab[1] ?></span>
                            <span class="tab-label"><?= $tab[0] ?></span>
                        </li>
                    <?php } ?>
                </ol>
                <button id="btn-quit">Quit</button>
            </div>
        </nav>
    </div>
