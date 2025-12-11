<!-- TODO: create admin/users view -->
<!-- TODO: define admin/users overview -->
<!-- TODO: move big users table to this file -->
<!-- TODO: move big schedules to this file -->
<!-- TODO: move big shifts table to this file -->
 <div class="dashboard-section"
 
 
 > 
    <!-- Users Table -->
<h2 style="color: white;">Users</h2>
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th></th>
            <th>Role</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Date Created</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>

        <tbody>
            <?php foreach ($users as $key => $user): //<span class="dot green">
                 ?>
                <tr>
                    <td><?php
                        switch ($user['user_status']) {
                            case 'active':
                            echo '<span class="dot green"></span>';
                                break;
                            case 'leave':
                            echo '<span class="dot yellow"></span>';
                                break;
                            case 'terminated':
                            echo '<span class="dot red"></span>';
                                break;
                            default:
                        }
                    ?></td>
                    <td><?= $user['user_role']?></td>
                    <td><?= $user['first_name']?></td>
                    <td><?= $user['last_name']?></td>
                    <td><?= $user['phone']?></td>
                    <td><?= $user['email']?></td>
                    <td><?= $user['user_dc']?></td>
                    <td>
                        <a class="btn btn-danger" href="admin/users/delete/<?=$user['user_id']?>">Terminate</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

 </div>
