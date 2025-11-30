<?php
use App\Domain\Models\UserModel;

$userModel = $container->get(UserModel::class);
$userCount = $userModel->countUsers();
?>

<div id="footer" class="lang-switch">
    <h4>
        <a href="">EN</a> - <a href="">FR</a>
    </h4>
    <h3>
        <?= $userCount ?> registered employees — join the team, register today.
    </h3>
    <h4>
        <span id="datetime-display"></span>
    </h4>
</div>
<!-- <h6> this is the footer </h6> -->
<script src="./public/assets/js/04-Login-Script.js"></script>
</body>

</html>
