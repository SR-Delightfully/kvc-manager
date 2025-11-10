<?php

use App\Helpers\ViewHelper;

$page_title = 'Dashboard Employee';
ViewHelper::loadHeader($page_title);
ViewHelper::loadSideBar();
?>
<h1>VKC - Employee</h1>
//TODO: change the text to the variables for the full name
<h2>Welcome back, first_name last_name!</h2>
<div class="leaderboard">
    <h2>Leaderboard</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Team Members</th>
                <th>Units</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <th></th>
                <th></th>
                <th></th>

            </tr>
            <tr>
                <td>2</td>
                <th></th>
                <th></th>
                <th></th>

            </tr>
            <tr>
                <td>3</td>
                <th></th>
                <th></th>
                <th></th>

            </tr>
            <tr>
                <td>4</td>
                <th></th>
                <th></th>
                <th></th>

            </tr>
            <tr>
                <td>5</td>
                <th></th>
                <th></th>
                <th></th>

            </tr>
        </tbody>
    </table>
</div>
<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
