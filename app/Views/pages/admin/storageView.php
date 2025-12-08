<!-- TODO: create admin/storage view -->
<!-- TODO: define admin/storage overview -->
<!-- TODO: move big pallets table to this file -->
<!-- TODO: move big totes table to this file -->
<div class="dashboard-section"> 

<!-- Tote Table -->
<h2 style="color: white;">Totes</h2>
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Variant</th>
                <th scope="col">Batch Number</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($totes as $key => $tote): ?>
                <tr>
                    <td><?= $tote['tote_id']?></td>
                    <td><?= $tote['variant_id']?></td>
                    <td><?= $tote['batch_number']?></td>
                    <td>
                        <a class="btn btn-secondary" href="admin/tote/edit/<?=$tote['tote_id']?>">Edit</a>
                        <a class="btn btn-danger" href="admin/tote/delete/<?=$tote['tote_id']?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Pallet Table -->
<h2 style="color: white;">Pallets</h2>
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tote Id</th>
                <th scope="col">Station Id</th>
                <th scope="col">Start Time</th>
                <th scope="col">End Time</th>
                <th scope="col">Units</th>
                <th scope="col">Break Time</th>
                <th scope="col">Mess</th>
                <th scope="col">Notes</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pallets as $key => $pallet): ?>
                <tr>
                    <td><?= $pallet['pallet_id']?></td>
                    <td><?= $pallet['tote_id']?></td>
                    <td><?= $pallet['station_id']?></td>
                    <td><?= $pallet['start_time']?></td>
                    <td><?= $pallet['end_time']?></td>
                    <td><?= $pallet['units']?></td>
                    <td><?= $pallet['break_time']?></td>
                    <td><?= $pallet['mess']?></td>
                    <td><?= $pallet['notes']?></td>
                    <td>
                        <a class="btn btn-secondary" href="admin/pallet/edit/<?=$pallet['pallet_id']?>">Edit</a>
                        <a class="btn btn-danger" href="admin/pallet/delete/<?=$pallet['pallet_id']?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
