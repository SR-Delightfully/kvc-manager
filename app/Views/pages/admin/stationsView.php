<!-- TODO: create admin/stations view -->
<!-- TODO: define admin/stations overview -->
<!-- TODO: move big stations table to this file -->
<!-- TODO: move big team table to this file -->
<!-- TODO: move big team members table to this file -->
<div class="dashboard-section">
    <!-- Station Table -->
<h2 style="color: white;">Stations</h2>
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stations as $key => $station): ?>
                <tr>
                    <td><?= $station['station_id']?></td>
                    <td><?= $station['station_name']?></td>
                    <td>
                        <a class="btn btn-secondary" href="admin/station/edit/<?=$station['station_id']?>">Edit</a>
                        <a class="btn btn-danger" href="admin/station/delete/<?=$station['station_id']?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Team Table -->
<h2 style="color: white;">Teams</h2>
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Station Id</th>
                <th scope="col">Team Creation Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($teams as $key => $team): ?>
                <tr>
                    <td><?= $team['team_id']?></td>
                    <td><?= $team['station_id']?></td>
                    <td><?= $team['team_date']?></td>
                    <td>
                        <a class="btn btn-secondary" href="admin/team/edit/<?=$team['team_id']?>">Edit</a>
                        <a class="btn btn-danger" href="admin/team/delete/<?=$team['team_id']?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Team Members Table -->
<h2 style="color: white;">Team Members</h2>
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">Team</th>
                <th scope="col">Station</th>
                <th scope="col">User</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
            <!--<th scope="col">Actions</th> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($team_members as $key => $member): ?>
                <tr>
                    <td><?= $member['team_id']?></td>
                    <td><?= $member['station_name']?></td>
                    <td><?= $member['user_id']?></td>
                    <td><?= $member['first_name']?></td>
                    <td><?= $member['last_name']?></td>
                    <!--<td>
                        <a class="btn btn-secondary" href="member/edit/<?=$member['team_id']?>/<?= $member['user_id'] ?>">Edit</a>
                        <a class="btn btn-danger" href="member/delete/<?=$member['team_id']?>/<?= $member['user_id'] ?>">Delete</a>
                    </td>-->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
