<?php

use App\Helpers\ViewHelper;
$products = $data['products'] ?? null;
$product_types = $data['product_types'] ?? null;
$colours = $data['colours'] ?? null;
$variants = $data['variants'] ?? null;
$users = $data['users'] ?? null;
$schedules = $data['schedules'] ?? null;
$shifts = $data['shifts'] ?? null;
$stations = $data['stations'] ?? null;
$pallets = $data['pallets'] ?? null;
$teams = $data['teams'] ?? null;
$team_members = $data['team_members'] ?? null;
$totes = $data['totes'] ?? null;

$show_variant_edit = $show_variant_edit ?? null;
$variant_to_edit = $data['variant_to_edit'] ?? null;
//var_dump($variant_to_edit);
//var_dump($show_variant_edit);
//var_dump($products);

$page_title = 'Database Overview';
ViewHelper::loadHeader($page_title, true);
?>
<!-- products section -->
 <div class="products-page">
            <?= App\Helpers\FlashMessage::render() ?>
    <!-- LEFT — PRODUCTS VARIANTS TABLE -->
    <div class="products-left">
<div class="table-card">
    <form id="variant-form" action="" method=""></form>
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Product ID</th>
                <th>Colour ID</th>
                <th>Unit Size</th>
                <th>Description</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($variants as $key => $variant): ?>
                <tr class="variant-row">
                    <td>
                        <input type="radio" name="variant_id"
                            value="<?= $variant['variant_id']?>"
                            class="variant-radio">
                    </td>
                    <td><?= $variant['product_id']?></td>
                    <td><?= $variant['colour_id']?></td>
                    <td><?= $variant['unit_size']?></td>
                    <td><?= $variant['variant_description']?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>
<div class="bottom-card">
    <div class="left-side">
        <form action="<?= APP_BASE_URL ?>/admin/variant" method="POST">
            <div class="quick-add-title">Quick Add :</div>

            <label for="">Product</label>
            <select name="product_id" class="form-select" id="product_id">
                <option value="">Select Product Id</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?= $product['product_id'] ?>">
                        <?= $product['product_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="">Colour</label>
            <select name="colour_id" class="form-select" id="colour_id">
                <option value="">Select Colour Id</option>
                <?php foreach ($colours as $colour): ?>
                    <option value="<?= $colour['colour_id'] ?>">
                        <?= $colour['colour_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="">Unit Size</label>
            <select name="unit_size" class="form-select" id="unit_size">
                <option value="">Select Unit Size</option>
                <option value="0.5L">0.5L</option>
                <option value="1L">1L</option>
                <option value="2L">2L</option>
                <option value="4L">4L</option>
                <option value="8L">8L</option>
            </select>
            <input name="variant_description" type="text" placeholder="Enter Product Description">

            <button type="submit">Add Variant</button>
        </form>
    </div>

    <div class="right-side">
        <label class="quick-add-title">Search . . .</label>
        <input type="text" placeholder="Search . . .">

        <div class="actions-title">Actions :</div>

        <button id="view-variant" class="blue-btn">View Product Details</button>
        <button id="edit-variant" class="yellow-btn">Edit Product Details</button>
        <button id="delete-variant" class="red-btn">Delete Product Details</button>
        <button class="jump-btn">Jump To ↪</button>
    </div>

</div>
</div>
  </div>
<br>
<br>

    <!-- RIGHT — EMPLOYEES SECTION -->
    <div class="employees-card">
<div class="employees-header">
    <h2>E M P L O Y E E S</h2>
</div>

<div class="employees-table-card">
    <table>
        <thead>
        <tr>
            <th></th>
            <th>Role</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Date Created</th>
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
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="employees-bottom">

    <div class="left-side">
        <select>
            <option>Employee Status</option>
            <option value="active">Active</option>
            <option value="leave">Leave</option>
            <option value="terminated">Terminated</option>
        </select>

        <div class="reg-label">Registration Code :</div>
        <input type="text" value="XJ8M32N" readonly>

        <button class="jump-btn">Jump To ↪</button>
    </div>

    <div class="right-side">
        <input class="search" type="text" placeholder="Search . .">

        <div class="actions-title">Actions :</div>

        <button class="blue-btn">View Product Details</button>
        <button class="yellow-btn">Edit Product Details</button>
        <button class="red-btn">Delete Product</button>
    </div>

</div>

    </div>

    </div>

</div>
<br><br>
<!-- pallets section -->
<div class="pallet-card">

    <div class="pallet-header">
        <h2>Product Types</h2>
        <button class="jump-btn">Jump To ↪</button>
    </div>

    <div class="quick-title">Quick Add :</div>

    <div class="form-grid">

        <!-- LEFT SIDE -->
        <div class="employees-table-card">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
                </thead>

                <tbody>
                    <?php foreach ($product_types as $key => $type): //<span class="dot green">
                        ?>
                        <tr>
                            <td><?= $type['product_type_id']?></td>
                            <td><?= $type['product_type_name']?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <form action="">
            <!-- RIGHT SIDE -->
            <div class="left-side">

                <label>Enter Product Type:</label>
                <input type="text" name="name" class="form-control" id="inputName">
            </div>

        </div>

        <div class="button-row">
            <button class="save-btn">Save Pallet</button>
        </div>
    </form>



</div>

<!-- PRODUCTS section -->
<div class="products-left">
<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Code</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $key => $product): ?>
                <tr>
                    <td><?= $product['product_id']?></td>
                    <td><?= $product['product_name']?></td>
                    <td><?= $product['product_type_id']?></td>
                    <td><?= $product['product_code']?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<div class="bottom-card">

    <div class="left-side">

        <div class="quick-add-title">Quick Add :</div>
            <form action=""></form>
                <label for="">Product Type</label>
                <select name="product_type_id" class="form-select" id="product_type">
                    <option value="">Select Product Type</option>
                    <?php foreach ($product_types as $types): ?>
                        <option value="<?= $types['product_type_id'] ?>">
                            <?= $types['product_type_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="product_code" placeholder="Enter Product Code">
                <input type="text" name="product_name" placeholder="Enter Product Name">
            </form>
        <button class="jump-btn">Jump To ↪</button>
    </div>

    <div class="right-side">
        <label>Search . .</label>
        <input type="text" placeholder="Search . .">

        <div class="actions-title">Actions :</div>

        <button class="blue-btn">View Product Details</button>
        <button class="yellow-btn">Edit Product Details</button>
        <button class="red-btn">Delete Product</button>
    </div>

</div>
</div>

<!-- COLOURS section -->
<div class="products-left">
<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Colour Code</th>
                <th>Colour Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($colours as $key => $colour): ?>
                <tr>
                    <td><?= $colour['colour_id']?></td>
                    <td><?= $colour['colour_code']?></td>
                    <td><?= $colour['colour_name']?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<div class="bottom-card">

    <div class="left-side">
        <div class="quick-add-title">Quick Add :</div>

        <input type="text" placeholder="Enter Colour Code">
        <input type="text" placeholder="Enter Colour Name">

        <button class="jump-btn">Jump To ↪</button>
    </div>

    <div class="right-side">
        <label>Search . .</label>
        <input type="text" placeholder="Search . .">

        <div class="actions-title">Actions :</div>

        <button class="blue-btn">View Product Details</button>
        <button class="yellow-btn">Edit Product Details</button>
        <button class="red-btn">Delete Product</button>
    </div>

</div>
</div>


<!-- BIG_TABLES SECTION -->


<!-- Product_Types Table -->
<h2 style="color: white;">Product Types</h2>
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Type</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($product_types as $key => $type): ?>
                <tr>
                    <td><?= $type['product_type_id']?></td>
                    <td><?= $type['product_type_name']?></td>
                    <td>
                        <a class="btn btn-secondary" href="products/<?=$product['id']?>/edit">Edit</a>
                        <a class="btn btn-danger" href="products/<?=$product['id']?>/delete">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<!-- Products Table -->
<h2 style="color: white;">Products</h2>
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Type</th>
                <th scope="col">Code</th>
                <th scope="col">Name</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $key => $product): ?>
                <tr>
                    <td><?= $product['product_id']?></td>
                    <td><?= $product['product_type_id']?></td>
                    <td><?= $product['product_code']?></td>
                    <td><?= $product['product_name']?></td>
                    <td>
                        <a class="btn btn-secondary" href="products/<?=$product['id']?>/edit">Edit</a>
                        <a class="btn btn-danger" href="products/<?=$product['id']?>/delete">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Variants Table -->
<h2 style="color: white;">Product Variants</h2>
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Id</th>
                <th scope="col">Colour Id</th>
                <th scope="col">Unit Size</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($variants as $key => $variant): ?>
                <tr>
                    <td><?= $variant['variant_id']?></td>
                    <td><?= $variant['product_id']?></td>
                    <td><?= $variant['colour_id']?></td>
                    <td><?= $variant['unit_size']?></td>
                    <td><?= $variant['variant_description']?></td>
                    <td>
                        <a class="btn btn-secondary" href="products/<?=$product['id']?>/edit">Edit</a>
                        <a class="btn btn-danger" href="products/<?=$product['id']?>/delete">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

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
                        <a class="btn btn-secondary" href="products/<?=$product['id']?>/edit">Edit</a>
                        <a class="btn btn-danger" href="products/<?=$product['id']?>/delete">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Station Table -->
<h2 style="color: white;">Stations</h2>
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stations as $key => $station): ?>
                <tr>
                    <td><?= $station['station_id']?></td>
                    <td><?= $station['station_name']?></td>
                    <td>
                        <a class="btn btn-secondary" href="products/<?=$product['id']?>/edit">Edit</a>
                        <a class="btn btn-danger" href="products/<?=$product['id']?>/delete">Delete</a>
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
                        <a class="btn btn-secondary" href="products/<?=$product['id']?>/edit">Edit</a>
                        <a class="btn btn-danger" href="products/<?=$product['id']?>/delete">Delete</a>
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
                <th scope="col">Member</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($team_members as $key => $member): ?>
                <tr>
                    <td><?= $member['team_id']?></td>
                    <td><?= $member['user_id']?></td>
                    <td>
                        <a class="btn btn-secondary" href="products/<?=$product['id']?>/edit">Edit</a>
                        <a class="btn btn-danger" href="products/<?=$product['id']?>/delete">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

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
                        <a class="btn btn-secondary" href="products/<?=$product['id']?>/edit">Edit</a>
                        <a class="btn btn-danger" href="products/<?=$product['id']?>/delete">Delete</a>
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
                        <a class="btn btn-secondary" href="products/<?=$product['id']?>/edit">Edit</a>
                        <a class="btn btn-danger" href="products/<?=$product['id']?>/delete">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<!-- EDIT VARIANT POPUP -->
 <?php
 if ($show_variant_edit):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <span class="close-forgot">X</span>

        <h2>Edit Variant</h2>
        <form action="<?= APP_BASE_URL ?>/admin/variant/edit/<?= $variant_to_edit['variant_id'] ?>" method="POST">
            <input type="hidden" value="<?= $variant_to_edit['variant_id'] ?>" name="variant_id">
        <div class="quick-add-title">Quick Add :</div>

            <label for="">Product</label>
            <select name="product_id" class="form-select" id="product_id">
                <option value="<?= $variant_to_edit['product_id'] ?>"><?= $variant_to_edit['product_id'] ?></option>
                <?php foreach ($products as $product): ?>
                    <option value="<?= $product['product_id'] ?>">
                        <?= $product['product_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="">Colour</label>
            <select name="colour_id" class="form-select" id="colour_id">
                <option value="<?= $variant_to_edit['colour_id'] ?>"><?= $variant_to_edit['colour_id'] ?></option>
                <?php foreach ($colours as $colour): ?>
                    <option value="<?= $colour['colour_id'] ?>">
                        <?= $colour['colour_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="">Unit Size</label>
            <select name="unit_size" class="form-select" id="unit_size">
                <option value="<?= $variant_to_edit['unit_size'] ?>"><?= $variant_to_edit['unit_size'] ?></option>
                <option value="0.5L">0.5L</option>
                <option value="1L">1L</option>
                <option value="2L">2L</option>
                <option value="4L">4L</option>
                <option value="8L">8L</option>
            </select>
            <input value="<?= $variant_to_edit['variant_description'] ?>" name="variant_description" type="text" placeholder="Enter Product Description">

            <button type="submit">Add Variant</button>

        </form>

    </div>
</div>
<?php endif; ?>


<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
