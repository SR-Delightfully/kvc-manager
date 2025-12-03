<?php

use App\Helpers\ViewHelper;



// $page_title = 'Admin Reports Page';
$page_title = $data["page_title"];


ViewHelper::loadHeader($page_title);
/*

*/

$dailyProd = $data['dailyProduction'];

?>
<p>Admin Reports Page</p>

<table class="table">
    <thead>
        <th>Team</th>
        <th>Daily Production</th>
    </thead>
    <tbody>
        <?php foreach ($data["shops"] as $key => $shop): ?>
            <tr>
                <td><?= $shop["name"] ?></td>
                <td><?= $shop["description"] ?></td>
                <td><a class="btn btn-primary" href="shops/<?= $shop["id"] ?>">View</a></td>
                <td><a class="btn btn-danger">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>