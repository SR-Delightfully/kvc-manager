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

$show_variant_delete = $show_variant_delete ?? null;
$variant_to_delete = $data['variant_to_delete'] ?? null;

$show_product_type_edit = $show_product_type_edit ?? null;
$product_type_to_edit = $data['product_type_to_edit'] ?? null;

$show_type_delete = $show_type_delete ?? null;
$type_to_delete = $data['type_to_delete'] ?? null;

$show_user_delete = $show_user_delete ?? null;
$user_to_delete = $data['user_to_delete'] ?? null;

$show_product_edit = $show_product_edit ?? null;
$product_to_edit = $data['product_to_edit'] ?? null;

$show_product_delete = $show_product_delete ?? null;
$product_to_delete = $data['product_to_delete'] ?? null;

$show_colour_edit = $show_colour_edit ?? null;
$colour_to_edit = $data['colour_to_edit'] ?? null;

$show_colour_delete = $show_colour_delete ?? null;
$colour_to_delete = $data['colour_to_delete'] ?? null;

$show_pallet_edit = $show_pallet_edit ?? null;
$pallet_to_edit = $data['pallet_to_edit'] ?? null;

$show_pallet_delete = $show_pallet_delete ?? null;
$pallet_to_delete = $data['pallet_to_delete'] ?? null;

$show_station_edit = $show_station_edit ?? null;
$station_to_edit = $data['station_to_edit'] ?? null;

$show_station_delete = $show_station_delete ?? null;
$station_to_delete = $data['station_to_delete'] ?? null;

$show_tote_edit = $show_tote_edit ?? null;
$tote_to_edit = $data['tote_to_edit'] ?? null;

$show_tote_delete = $show_tote_delete ?? null;
$tote_to_delete = $data['tote_to_delete'] ?? null;

$show_team_edit = $show_team_edit ?? null;
$team_to_edit = $data['team_to_edit'] ?? null;

$show_team_delete = $show_team_delete ?? null;
$team_to_delete = $data['team_to_delete'] ?? null;
//var_dump($variant_to_edit);
//var_dump($show_variant_edit);
//var_dump($products);

$page_title = 'Database Overview';
ViewHelper::loadHeader($page_title, true);
ViewHelper::loadSideBar();
?>
<main class="page">
<?php
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
                <th>Product</th>
                <th>Colour</th>
                <th>Unit Size</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody id="variantBody"></tbody>
            <template id="defaultVariantsTemplate">
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
            </template>
            <template id="variantResults"></template>
    </table>
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
        <input id="searchInput" type="text" placeholder="Search . . ." aria-label="Search variants">

        <div class="actions-title">Actions :</div>

        <!-- <button id="view-variant" class="blue-btn">View Variant Details</button> -->
        <button id="edit-variant" class="yellow-btn">Edit Variant Details</button>
        <button id="delete-variant" class="red-btn">Delete Variant</button>
        <button class="jump-btn">Jump To ↪</button>
    </div>

</div>
</div>
<br>
<br>
 </div>
    <!-- RIGHT — EMPLOYEES SECTION -->
    <div class="employees-card">
<div class="employees-header">
    <h2>E M P L O Y E E S</h2>
</div>

<div class="employees-table-card">
    <form id="user-form" action="" method=""></form>
    <table>
        <thead>
        <tr>
            <th></th>
            <th></th>
            <th>Role</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Date Created</th>
        </tr>
        </thead>

        <tbody id="employeeBody">
            <template id="defaultUsersTemplate">
                <?php foreach ($users as $key => $user): ?>
                    <tr class="user-row">
                        <td>
                        <input type="radio" name="user_id"
                            value="<?= $user['user_id']?>"
                            class="user-radio">
                        </td>
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
            </template>
            <template id="usersResults"></template>
        </tbody>
    </table>
</div>

<div class="employees-bottom">

    <div class="left-side">
        <select id="userStatusFilter">
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

        <!-- <button id="view-user" class="blue-btn">View User Details</button> -->
        <button id="delete-user" class="red-btn">Terminate User</button>
    </div>
</div>
</div>
</div>
<br><br>
<div class="triple-widget-row">
    <!--  PRODUCT TYPES WIDGET -->
    <div class="pallet-card">

        <div class="pallet-header">
            <h2>Product Types</h2>
            <button class="jump-btn">Jump To ↪</button>
        </div>
        <div class="form-grid">
            <div class="employees-table-card">
                <form id="product-type-form" action="" method=""></form>
                <table>
                    <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Name</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($product_types as $type): ?>
                            <tr class="product-type-row">
                                <td>
                                    <input type="radio"
                                           name="product_type_id"
                                           value="<?= $type['product_type_id'] ?>"
                                           class="type-radio">
                                </td>
                                <td><?= $type['product_type_id'] ?></td>
                                <td><?= $type['product_type_name'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="left-side">
                <div class="quick-title">Quick Add :</div>
                <form action="<?= APP_BASE_URL ?>/admin/type" method="POST">
                    <label>Enter Product Type:</label>
                    <input type="text" name="product_type_name" class="form-control">
                    <div class="button-row">
                        <button type="submit" class="save-btn">Save Product Type</button>
                    </div>
                </form>
                <div class="actions-title">Actions :</div>
                <button id="edit-type" class="yellow-btn">Edit Product Type</button>
                <button id="delete-type" class="red-btn">Delete Product Type</button>
            </div>

        </div>
    </div>
    <!--      PRODUCTS WIDGET   -->
    <div class="products-left">

        <div class="table-card">
            <form id="product-form" action="" method=""></form>
            <table>
                <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Code</th>
                </tr>
                </thead>
                <tbody id="productBody">
                    <template id="defaultProductsTemplate">
                        <?php foreach ($products as $product): ?>
                            <tr class="product-row">
                                <td>
                                    <input type="radio"
                                           name="product_id"
                                           value="<?= $product['product_id'] ?>"
                                           class="product-radio">
                                </td>
                                <td><?= $product['product_id'] ?></td>
                                <td><?= $product['product_name'] ?></td>
                                <td><?= $product['product_type_id'] ?></td>
                                <td><?= $product['product_code'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </template>
                </tbody>
            </table>
            <div class="bottom-card">
                <div class="left-side">
                    <div class="quick-add-title">Quick Add :</div>
                    <form action="<?= APP_BASE_URL ?>/admin/product" method="POST">
                        <label>Product Type</label>
                        <select name="product_type_id">
                            <option value="">Select Product Type</option>
                            <?php foreach ($product_types as $types): ?>
                                <option value="<?= $types['product_type_id'] ?>">
                                    <?= $types['product_type_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="product_code" placeholder="Enter Product Code">
                        <input type="text" name="product_name" placeholder="Enter Product Name">
                        <button type="submit">Add Product</button>
                    </form>
                    <button class="jump-btn">Jump To ↪</button>
                </div>
                <div class="right-side">
                    <label>Search . .</label>
                    <input id="productSearchInput" type="text" placeholder="Search . .">
                    <div class="actions-title">Actions :</div>
                    <button id="edit-product" class="yellow-btn">Edit Product</button>
                    <button id="delete-product" class="red-btn">Delete Product</button>
                </div>
            </div>
        </div>
    </div>
    <!--      COLOURS WIDGET    -->
    <div class="products-left">

        <div class="table-card">
            <form id="colour-form" action="" method=""></form>
            <table>
                <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Colour Code</th>
                    <th>Colour Name</th>
                </tr>
                </thead>
                <tbody id="colourBody">
                    <template id="defaultColoursTemplate">
                        <?php foreach ($colours as $colour): ?>
                            <tr class="colour-row">
                                <td>
                                    <input type="radio"
                                           name="colour_id"
                                           value="<?= $colour['colour_id'] ?>"
                                           class="colour-radio">
                                </td>
                                <td><?= $colour['colour_id'] ?></td>
                                <td><?= $colour['colour_code'] ?></td>
                                <td><?= $colour['colour_name'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </template>
                </tbody>
            </table>
            <div class="bottom-card">
                <div class="left-side">
                    <div class="quick-add-title">Quick Add :</div>
                    <form action="<?= APP_BASE_URL ?>/admin/colour" method="POST">
                        <input type="text" name="colour_code" placeholder="Enter Colour Code">
                        <input type="text" name="colour_name" placeholder="Enter Colour Name">
                        <button type="submit">Add Colour</button>
                    </form>
                    <button class="jump-btn">Jump To ↪</button>
                </div>
                <div class="right-side">
                    <label>Search . .</label>
                    <input id="colourSearchInput" type="text" placeholder="Search . .">
                    <div class="actions-title">Actions :</div>
                    <button id="edit-colour" class="yellow-btn">Edit Colour</button>
                    <button id="delete-colour" class="red-btn">Delete Colour</button>
                </div>
            </div>
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
                        <a class="btn btn-secondary" href="admin/type/edit/<?=$type['product_type_id']?>">Edit</a>
                        <a class="btn btn-danger" href="admin/type/delete/<?=$type['product_type_id']?>">Delete</a>
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
                        <a class="btn btn-secondary" href="admin/product/edit/<?=$product['product_id']?>">Edit</a>
                        <a class="btn btn-danger" href="admin/product/delete/<?=$product['product_id']?>">Delete</a>
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
                        <a class="btn btn-secondary" href="admin/variant/edit/<?=$variant['variant_id']?>">Edit</a>
                        <a class="btn btn-danger" href="admin/variant/delete/<?=$variant['variant_id']?>">Delete</a>
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
                        <a class="btn btn-danger" href="admin/users/delete/<?=$user['user_id']?>">Terminate</a>
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

<script>
    window.APP_BASE_URL = "<?= APP_BASE_URL ?>";
</script>

<!-- EDIT VARIANT POPUP -->
 <?php
 if ($show_variant_edit): ?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>

        <?= var_dump($variant_to_edit) ?>
        <h2>Edit Variant</h2>
        <form action="<?= APP_BASE_URL ?>/admin/variant/edit/<?= $variant_to_edit['variant_id'] ?>" method="POST">
            <input type="hidden" value="<?= $variant_to_edit['variant_id'] ?>" name="variant_id">
        <div class="quick-add-title">Quick Add :</div>

            <label for="">Product</label>
            <select name="product_id" class="form-select" id="product_id">
                <option value="<?= $variant_to_edit['product_id'] ?>"><?= $variant_to_edit['product_name'] ?></option>
                <?php foreach ($products as $product): ?>
                    <option value="<?= $product['product_id'] ?>" name="product_id">
                        <?= $product['product_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="">Colour</label>
            <select name="colour_id" class="form-select" id="colour_id">
                <option value="<?= $variant_to_edit['colour_id'] ?>"><?= $variant_to_edit['colour_code'] ?></option>
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

            <button type="submit">Update Variant</button>

        </form>

    </div>
</div>
<?php endif; ?>

<!-- DELETE VARIANT POPUP -->
 <?php
 if ($show_variant_delete):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>

        <h2>Delete Variant</h2>
        <h3>Are you sure you want to delete Variant: <?= $variant_to_delete['variant_description'] ?></h3>
        <form action="<?= APP_BASE_URL ?>/admin/variant/delete/<?= $variant_to_delete['variant_id']?>/do" method="GET">
            <input type="hidden" value="<?= $variant_to_delete['variant_id'] ?>" name="variant_id">
            <span>
                <button type="submit">Delete Variant</button>
                <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
            </span>
        </form>

    </div>
</div>
<?php endif; ?>

<!-- DELETE USER POPUP -->
 <?php
 if ($show_user_delete):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>

        <h2>Terminate User</h2>
        <h3>Are you sure you want to Terminate User: <?= $user_to_delete['first_name'] ?> <?= $user_to_delete['last_name'] ?></h3>
        <h3>Once they are terminated they are unable to access this website</h3>
        <form action="<?= APP_BASE_URL ?>/admin/users/delete/<?= $user_to_delete['user_id']?>/do" method="GET">
            <input type="hidden" value="<?= $user_to_delete['user_id'] ?>" name="user_id">
            <span>
                <button type="submit">Terminate User</button>
                <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
            </span>
        </form>

    </div>
</div>
<?php endif; ?>

<!-- EDIT PRODUCT TYPE POPUP -->
 <?php
 if ($show_product_type_edit):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>
        <h2>Edit Product Type</h2>
        <form action="<?= APP_BASE_URL ?>/admin/type/edit/<?= $product_type_to_edit['product_type_id'] ?>" method="POST">
        <input type="hidden" value="<?= $product_type_to_edit['product_type_id'] ?>" name="product_type_id">
        <div class="quick-add-title">Quick Add :</div>

            <label for="product_type_name">Type Name</label>
            <input value="<?= $product_type_to_edit['product_type_name'] ?>" name="product_type_name" type="text" placeholder="Enter Product Type Name">

            <button type="submit">Update Product Type</button>
            <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
        </form>

    </div>
</div>
<?php endif; ?>

<!-- DELETE PRODUCT TYPE POPUP -->
 <?php
 if ($show_type_delete):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>

        <h2>Delete Product Type</h2>
        <h3>Are you sure you want to delete Product Type: <?= $type_to_delete['product_type_name'] ?></h3>
        <form action="<?= APP_BASE_URL ?>/admin/type/delete/<?= $type_to_delete['product_type_id']?>/do" method="GET">
            <input type="hidden" value="<?= $type_to_delete['product_type_id'] ?>" name="product_type_id">
            <span>
                <button type="submit">Delete Product Type</button>
                <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
            </span>
        </form>

    </div>
</div>
<?php endif; ?>

<!-- EDIT PRODUCT POPUP -->
 <?php
 if ($show_product_edit):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>
        <h2>Edit Product</h2>
        <form action="<?= APP_BASE_URL ?>/admin/product/edit/<?= $product_to_edit['product_id'] ?>" method="POST">
        <input type="hidden" value="<?= $product_to_edit['product_id'] ?>" name="product_id">
        <div class="quick-add-title">Quick Add :</div>

            <label for="">Product Type</label>
            <select name="product_type_id" class="form-select" id="product_type_id">
                <option value="<?= $product_to_edit['product_type_id'] ?>"><?= $product_to_edit['product_type_id'] ?></option>
                <?php foreach ($product_types as $types): ?>
                    <option value="<?= $types['product_type_id'] ?>">
                        <?= $types['product_type_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="product_code">Product Code</label>
            <input value="<?= $product_to_edit['product_code'] ?>" name="product_code" type="text" placeholder="Enter Product Type Name">

            <label for="product_name">Product Name</label>
            <input value="<?= $product_to_edit['product_name'] ?>" name="product_name" type="text" placeholder="Enter Product Type Name">

            <button type="submit">Update Product Type</button>
            <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
        </form>

    </div>
</div>
<?php endif; ?>

<!-- DELETE PRODUCT POPUP -->
 <?php
 if ($show_product_delete):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>

        <h2>Delete Product Type</h2>
        <h3>Are you sure you want to delete Product: <?= $product_to_delete['product_name'] ?></h3>
        <form action="<?= APP_BASE_URL ?>/admin/product/delete/<?= $product_to_delete['product_id']?>/do" method="GET">
            <input type="hidden" value="<?= $product_to_delete['product_id'] ?>" name="product_id">
            <span>
                <button type="submit">Delete Product</button>
                <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
            </span>
        </form>

    </div>
</div>
<?php endif; ?>


<!-- EDIT COLOUR POPUP -->
 <?php
 if ($show_colour_edit):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>
        <h2>Edit Colour</h2>
        <form action="<?= APP_BASE_URL ?>/admin/colour/edit/<?= $colour_to_edit['colour_id'] ?>" method="POST">
        <input type="hidden" value="<?= $colour_to_edit['colour_id'] ?>" name="colour_id">
        <div class="quick-add-title">Quick Add :</div>

            <label for="colour_code">Colour Code</label>
            <input value="<?= $colour_to_edit['colour_code'] ?>" name="colour_code" type="text" placeholder="Enter Colour Code">

            <label for="colour_name">Colour Name</label>
            <input value="<?= $colour_to_edit['colour_name'] ?>" name="colour_name" type="text" placeholder="Enter Colour Name">

            <button type="submit">Update Colour</button>
            <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
        </form>

    </div>
</div>
<?php endif; ?>

<!-- DELETE COLOUR POPUP -->
 <?php
 if ($show_colour_delete):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>

        <h2>Delete Product Type</h2>
        <h3>Are you sure you want to delete Colour: <?= $colour_to_delete['colour_name'] ?></h3>
        <form action="<?= APP_BASE_URL ?>/admin/colour/delete/<?= $colour_to_delete['colour_id']?>/do" method="GET">
            <input type="hidden" value="<?= $colour_to_delete['colour_id'] ?>" name="colour_id">
            <span>
                <button type="submit">Delete Colour</button>
                <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
            </span>
        </form>

    </div>
</div>
<?php endif; ?>

<!-- EDIT STATION POPUP -->
 <?php
 if ($show_station_edit):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>
        <h2>Edit Station</h2>
        <form action="<?= APP_BASE_URL ?>/admin/station/edit/<?= $station_to_edit['station_id'] ?>" method="POST">
        <input type="hidden" value="<?= $station_to_edit['station_id'] ?>" name="station_id">
        <div class="quick-add-title">Quick Add :</div>

            <label for="station_name">Station Name</label>
            <input value="<?= $station_to_edit['station_name'] ?>" name="station_name" type="text" placeholder="Enter Station Name">

            <button type="submit">Update Station</button>
            <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
        </form>

    </div>
</div>
<?php endif; ?>

<!-- DELETE STATION POPUP -->
 <?php
 if ($show_station_delete):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>

        <h2>Delete Station</h2>
        <h3>Are you sure you want to delete Station: <?= $station_to_delete['station_id'] ?></h3>
        <form action="<?= APP_BASE_URL ?>/admin/station/delete/<?= $station_to_delete['station_id']?>/do" method="GET">
            <input type="hidden" value="<?= $station_to_delete['station_id'] ?>" name="station_id">
            <span>
                <button type="submit">Delete Station</button>
                <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
            </span>
        </form>

    </div>
</div>
<?php endif; ?>


<!-- EDIT PALLET POPUP -->
 <?php
 if ($show_pallet_edit):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>
        <h2>Edit Pallet</h2>
        <form action="<?= APP_BASE_URL ?>/admin/pallet/edit/<?= $pallet_to_edit['pallet_id'] ?>" method="POST">
        <input type="hidden" value="<?= $pallet_to_edit['pallet_id'] ?>" name="pallet_id">
        <div class="quick-add-title">Quick Add :</div>

            <label for="">Tote</label>
            <select name="tote_id" class="form-select" id="product_type_id">
                <option value="<?= $pallet_to_edit['tote_id'] ?>"><?= $pallet_to_edit['tote_id'] ?></option>
                <?php foreach ($totes as $tote): ?>
                    <option value="<?= $tote['tote_id'] ?>">
                        <?= $tote['batch_number'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="">Station</label>
            <select name="station_id" class="form-select" id="product_type_id">
                <option value="<?= $pallet_to_edit['station_id'] ?>"><?= $pallet_to_edit['station_id'] ?></option>
                <?php foreach ($stations as $station): ?>
                    <option value="<?= $station['station_id'] ?>">
                        <?= $station['station_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="start_time">Start Time</label>
            <input value="<?= $pallet_to_edit['start_time'] ?>" name="start_time" type="text" placeholder="Enter Start Time">

            <label for="end_time">End Time</label>
            <input value="<?= $pallet_to_edit['end_time'] ?>" name="end_time" type="text" placeholder="Enter End Time">

            <label for="units">Units</label>
            <input value="<?= $pallet_to_edit['units'] ?>" name="units" type="text" placeholder="Enter Units">

            <label for="break_time">Break Time</label>
            <input value="<?= $pallet_to_edit['break_time'] ?>" name="break_time" type="text" placeholder="Enter Break Time">

            <label for="mess">Break Time</label>
            <input value="<?= $pallet_to_edit['mess'] ?>" name="mess" type="button">

            <label for="notes">Notes</label>
            <input value="<?= $pallet_to_edit['notes'] ?>" name="notes" type="text" placeholder="Enter Notes">

            <button type="submit">Update Pallet</button>
            <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
        </form>

    </div>
</div>
<?php endif; ?>

<!-- DELETE PALLET POPUP -->
 <?php
 if ($show_pallet_delete):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>

        <h2>Delete Product Type</h2>
        <h3>Are you sure you want to delete Pallet with ID: <?= $pallet_to_delete['pallet_id'] ?></h3>
        <form action="<?= APP_BASE_URL ?>/admin/pallet/delete/<?= $pallet_to_delete['pallet_id']?>/do" method="GET">
            <input type="hidden" value="<?= $pallet_to_delete['pallet_id'] ?>" name="pallet_id">
            <span>
                <button type="submit">Delete Pallet</button>
                <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
            </span>
        </form>

    </div>
</div>
<?php endif; ?>

<!-- EDIT TOTE POPUP -->
 <?php
 if ($show_tote_edit):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>
        <h2>Edit Tote</h2>
        <form action="<?= APP_BASE_URL ?>/admin/tote/edit/<?= $tote_to_edit['tote_id'] ?>" method="POST">
        <input type="hidden" value="<?= $tote_to_edit['tote_id'] ?>" name="tote_id">
        <div class="quick-add-title">Quick Add :</div>

            <label for="">Variant</label>
            <select name="variant_id" class="form-select" id="variant_id">
                <option value="<?= $tote_to_edit['variant_id'] ?>"><?= $tote_to_edit['variant_id'] ?></option>
                <?php foreach ($variants as $variant): ?>
                    <option value="<?= $variant['variant_id'] ?>">
                        <?= $variant['variant_description'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="batch_number">Batch Number</label>
            <input value="<?= $tote_to_edit['batch_number'] ?>" name="batch_number" type="text" placeholder="Enter Batch Number">

            <button type="submit">Update Colour</button>
            <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
        </form>

    </div>
</div>
<?php endif; ?>

<!-- DELETE TOTE POPUP -->
 <?php
 if ($show_tote_delete):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>

        <h2>Delete Tote</h2>
        <h3>Are you sure you want to delete Tote with Batch Number: <?= $tote_to_delete['batch_number'] ?></h3>
        <form action="<?= APP_BASE_URL ?>/admin/tote/delete/<?= $tote_to_delete['tote_id']?>/do" method="GET">
            <input type="hidden" value="<?= $tote_to_delete['tote_id'] ?>" name="tote_id">
            <span>
                <button type="submit">Delete Tote</button>
                <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
            </span>
        </form>

    </div>
</div>
<?php endif; ?>

<!-- EDIT TEAM POPUP -->
 <?php
 if ($show_team_edit):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>
        <h2>Edit Team</h2>
        <form action="<?= APP_BASE_URL ?>/admin/team/edit/<?= $team_to_edit['team_id'] ?>" method="POST">
        <input type="hidden" value="<?= $team_to_edit['team_id'] ?>" name="team_id">
        <div class="quick-add-title">Quick Add :</div>

            <label for="">Station</label>
            <select name="station_id" class="form-select" id="station_id">
                <option value="<?= $team_to_edit['station_id'] ?>"><?= $team_to_edit['station_id'] ?></option>
                <?php foreach ($stations as $station): ?>
                    <option value="<?= $station['station_id'] ?>">
                        <?= $station['station_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Update Team</button>
            <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
        </form>

    </div>
</div>
<?php endif; ?>

<!-- DELETE TEAM POPUP -->
 <?php
 if ($show_team_delete):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/admin" class="close-forgot">X</a>

        <h2>Delete Team</h2>
        <h3>Are you sure you want to delete Team with Team ID: <?= $team_to_delete['team_id'] ?></h3>
        <form action="<?= APP_BASE_URL ?>/admin/team/delete/<?= $team_to_delete['team_id']?>/do" method="GET">
            <input type="hidden" value="<?= $tote_to_deleteam_to_deletete['team_id'] ?>" name="team_id">
            <span>
                <button type="submit">Delete Team</button>
                <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
            </span>
        </form>

    </div>
</div>
<?php endif; ?>
<script src="/kvc-manager/public/assets/js/admin-page.js"></script>
<?php
ViewHelper::loadFooter();
?>


