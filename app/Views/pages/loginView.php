<?php

use App\Helpers\ViewHelper;

//* DYNAMIC POPUPS
$show2fa_login = $render['show2fa_login'] ?? false;
$show_forgot_password = $render['show_forgot_password'] ?? false;
$show_forgot_password_2fa = $render['show_forgot_password_2fa'] ?? false;
$show_new_password = $render['show_new_password'] ?? false;

$show_forgot_email = $render['show_forgot_email'] ?? false;
$show_forgot_email_2fa = $render['show_forgot_email_2fa'] ?? false;
$show_new_email = $render['show_new_email'] ?? false;


//TODO: set the page title dynamically based on the view being rendered in the controller.
$page_title = 'Welcome to KVC Manager!';
ViewHelper::loadHeader($page_title);
?>
<p>Hello Login page! :)</p>
