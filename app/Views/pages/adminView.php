<?php

use App\Helpers\ViewHelper;
use App\Helpers\UserContext;

// Original code from aya & david
// Layout provided by Sabrina
// Modifications/Notes from Sabrina

$page_title = 'Admin Dashboard - Database Overview';

// Getting user context to ensure they have access to this page
$currentUser = UserContext::getCurrentUser();

$isAdmin = UserContext::isAdmin();
$isEmployee = UserContext::isEmployee();

// Decaring data variables for the different tables displayed on this page:
$schedules = $data['schedules'] ?? null;
$shifts = $data['shifts'] ?? null;

$users = $data['users'] ?? null;
$team_members = $data['team_members'] ?? null;
$teams = $data['teams'] ?? null;

$stations = $data['stations'] ?? null;
$pallets = $data['pallets'] ?? null;
$totes = $data['totes'] ?? null;

$products = $data['products'] ?? null;
$product_types = $data['product_types'] ?? null;
$colours = $data['colours'] ?? null;
$variants = $data['variants'] ?? null;

$code = $data['code'] ?? null;

// Declaring boolean variables to perform checks, ensuring we edit/delete the right record.
// ! TODO: rework webroutes to match these subroutes ⬇
// ! TODO: rework Sidebar to match these subroutes (and their subroutes) ⬇


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

// Variables for /admin/users
$schedule_selected = $data['schedule_selected'] ?? null;
$is_schedule_edit_open = $is_schedule_edit_open ?? null;
$is_schedule_dlt_open = $is_schedule_dlt_open ?? null;

$shifts_selected = $data['shifts_selected'] ?? null;
$is_shifts_edit_open = $is_shifts_edit_open ?? null;
$is_shifts_dlt_open = $is_shifts_dlt_open ?? null;

$user_selected = $data['user_selected'] ?? null;
$is_user_edit_open = $is_user_edit_open ?? null;
$is_user_dlt_open = $is_user_dlt_open ?? null;

// Variables for /admin/stations
$team_member_selected = $data['team_member_selected'] ?? null;
$is_team_member_edit_open = $is_team_member_edit_open ?? null;
$is_team_member_dlt_open = $is_team_member_dlt_open ?? null;

$team_selected = $data['team_selected'] ?? null;
$is_team_edit_open = $is_team_edit_open ?? null;
$is_team_dlt_open = $is_team_dlt_open ?? null;

$station_selected = $data['station_selected'] ?? null;
$is_station_edit_open = $is_station_edit_open ?? null;
$is_station_dlt_open = $is_station_dlt_open ?? null;

// Variables for /admin/storage
$pallet_selected = $data['pallet_selected'] ?? null;
$is_pallet_edit_open = $is_pallet_edit_open ?? null;
$is_pallet_dlt_open = $is_pallet_dlt_open ?? null;

$tote_selected = $data['tote_selected'] ?? null;
$is_tote_edit_open = $is_tote_edit_open ?? null;
$is_tote_dlt_open = $is_tote_dlt_open ?? null;

// Variables for /admin/products
$product_selected = $data['product_selected'] ?? null;
$is_product_edit_open = $is_product_edit_open ?? null;
$is_product_dlt_open = $is_product_dlt_open ?? null;

$type_selected = $data['type_selected'] ?? null;
$is_type_edit_open = $is_type_edit_open ?? null;
$is_type_dlt_open = $is_type_dlt_open ?? null;

$colour_selected = $data['colour_selected'] ?? null;
$is_colour_edit_open = $is_colour_edit_open ?? null;
$is_colour_dlt_open = $is_colour_dlt_open ?? null;

$variant_selected = $data['variant_selected'] ?? null;
$is_variant_edit_open = $is_variant_edit_open ?? null;
$is_variant_dlt_open = $is_variant_dlt_open ?? null;

?>

<div id="page-wrapper" class="page">
    <?= App\Helpers\FlashMessage::render() ?>
    <div id="page-content">
        <?php if ($isAdmin): ?>
             <ul id="dashboard" class="center-v">
                <!-- ? Clarification needed: What actually is the difference between the tables "product" and "product_type" they both seem to depict different aspects of the "product_variant" but if thats the case wouldn't "product_variant" just be the product itself..? -->

                <!-- // * Suggestion, instead of schedule, display stations (station_id, station_name, team_num, team_members (a dropdown?))   -->
                <!-- Schedule Component -->
                <li id="schedule-mini-widget" class="mini-widget">
                    <div class="header">
                        <h2>S C H E D U L E S</h2><button class="btn btn-thin btn-secondary">↪ View Table</button>
                    </div>
                    <h3>In a rush? Quickly add a new schedule with the form below!</h3>
                    <form>
                        <div class="left-side">
                            <label>Choose Schedule Date:</label>
                            <select>
                                <option>00/00/0000</option>
                                <!-- TODO: create/use script to generate options for the next 2-4 weeks? -->
                            </select>

                            <label>Assign Shift to Employee(s):</label>
                            <select>
                                <option>List of Employees</option>
                                <!-- TODO: create/use script to generate a list of active employees -->
                            </select>
                        </div>
                        <div class="right-side">
                            <label>Choose Shift:</label>
                            <div class="radio-row">
                                <label><input type="radio" name="size"> Morning</label>
                                <label><input type="radio" name="size"> Afternoon</label>
                                <label><input type="radio" name="size"> Evening</label>
                            </div>
                            <label>Chosen Employees:</label>
                            <div id="chosen-employees">
                                <!-- TODO: dynamically show all chosen employees -->
                                <span class="mini-employe-card">
                                    <img src="/" />
                                    <p>J.Doe</p>
                                </span>
                            </div>
                        </div>
                        <div class="button-row">
                            <button class="btn btn-wider btn-danger">Cancel</button>
                            <button class="btn btn-wider btn-okay">Save Schedule</button>
                        </div>
                    </form>
                </li>
                <!-- Pallet Component -->
                <li class="mini-widget">
                    <div class="header metallic">
                        <h2>P A L L E T S</h2><button class="btn btn-thin btn-secondary">↪ View Table</button>
                    </div>
                    <h3 class="metallic-bg">In a rush? Quickly add a new pallet with the form below!</h3>
                    <form class="metallic">
                        <div class="left-side">
                            <label>Choose Tote Type:</label>
                            <select>
                                <option>Tote Options</option>
                            </select>

                            <label>Assign Pallet to a Station:</label>
                            <select>
                                <option>Stations</option>
                            </select>
                        </div>
                        <div class="right-side">
                            <label>Choose Pallet Size:</label>
                            <div class="radio-row">
                                <label><input type="radio" name="size"> Small</label>
                                <label><input type="radio" name="size"> Medium</label>
                                <label><input type="radio" name="size"> Large</label>
                            </div>
                            <label>Specify Pallet Capacity:</label>
                            <input type="text" placeholder="Enter Number of Units">
                        </div>
                        <div class="button-row">
                            <button type="button" class="btn btn-wider btn-danger">Cancel</button>
                            <button type="button" class="btn btn-wider btn-okay">Save Pallet</button>
                        </div>
                    </form>
                </li>
                <li class="metallic small-widget">
                    <h2> Employees </h2>
                    <h3> Most Recent Entries:</h3>
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
                        <input type="text" value="<?= $code ?>" readonly>

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
                </li>
            </ul>
            <ul id="dashboard-sections">
                <li>
                    <?php include __DIR__ . '/admin/employeesView.php'; ?>
                    <!-- TODO: create admin/employees overview -->
                </li>
                <li>
                    <?php include __DIR__ . '/admin/stationsView.php'; ?>
                    <!-- TODO: create admin/stations overview -->
                </li>
                <li>
                    <?php include __DIR__ . '/admin/storageView.php'; ?>
                    <!-- TODO: call admin/storage view -->
                </li>
                <li>
                    <?php include __DIR__ . '/admin/productsView.php'; ?>
                    <!-- TODO: create admin/products overview -->
                </li>
            </ul>
        <?php else: ?>
            <!-- just adding this twice because i dont want to login rn -->
            <!-- In production version this code will be replaced with an error screen that -->
            <!-- will redirect the user back to the employee dashboard or login if no user is provided.-->
            <ul id="dashboard" class="center-v">
                <!-- ? Clarification needed: What actually is the difference between the tables "product" and "product_type" they both seem to depict different aspects of the "product_variant" but if thats the case wouldn't "product_variant" just be the product itself..? -->

                <!-- Products Component -->
                <!-- Displays the most recent product variant entries -->
                <li class="metallic small-widget">
                <h2> Products </h2>
                <h3> Most Recent Entries:</h3>

                <div class="table-card">
                    <form id="variant-form" action="" method=""></form>

                    <table class="products-mini-table table table-striped">
                    <thead>
                        <tr>
                        <th></th>
                        <th>Product Type</th>
                        <th>Product Colour</th>
                        <th>Product Size</th>
                        <th>Product Description</th>
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

                        <button type="submit" class="btn btn-wide btn-primary">Add Variant</button>
                    </form>
                    </div>

                    <div class="right-side">
                        <label class="quick-add-title">Search . . .</label>
                        <input id="searchInput" class="search" type="text" placeholder="Search . . .">

                        <div class="actions-title">Actions :</div>

                        <button id="edit-variant" type="button" class="btn btn-thin btn-warning">Edit Variant</button>
                        <button id="delete-variant" type="button" class="btn btn-thin btn-danger">Delete Variant</button>
                        <button class="btn btn-wide btn-primary">View Full Table</button>
                    </div>
                    </div>
                </div>
                </li>
                <!-- // * Suggestion, instead of schedule, display stations (station_id, station_name, team_num, team_members (a dropdown?))   -->
                <!-- Schedule Component -->
                <li id="schedule-mini-widget" class="mini-widget">
                    <div class="header">
                        <h2>S C H E D U L E S</h2><button class="btn btn-thin btn-secondary">↪ View Table</button>
                    </div>
                    <h3>In a rush? Quickly add a new schedule with the form below!</h3>
                    <form>
                        <div class="left-side">
                            <label>Choose Schedule Date:</label>
                            <select>
                                <option>00/00/0000</option>
                                <!-- TODO: create/use script to generate options for the next 2-4 weeks? -->
                            </select>

                            <label>Assign Shift to Employee(s):</label>
                            <select>
                                <option>List of Employees</option>
                                <!-- TODO: create/use script to generate a list of active employees -->
                            </select>
                        </div>
                        <div class="right-side">
                            <label>Choose Shift:</label>
                            <div class="radio-row">
                                <label><input type="radio" name="size"> Morning</label>
                                <label><input type="radio" name="size"> Afternoon</label>
                                <label><input type="radio" name="size"> Evening</label>
                            </div>
                            <label>Chosen Employees:</label>
                            <div id="chosen-employees">
                                <!-- TODO: dynamically show all chosen employees -->
                                <span class="mini-employe-card">
                                    <img src="/" />
                                    <p>J.Doe</p>
                                </span>
                            </div>
                        </div>
                        <div class="button-row">
                            <button class="btn btn-wider btn-danger">Cancel</button>
                            <button class="btn btn-wider btn-okay">Save Schedule</button>
                        </div>
                    </form>
                </li>
                <!-- Pallet Component -->
                <li class="mini-widget">
                    <div class="header metallic">
                        <h2>P A L L E T S</h2><button class="btn btn-thin btn-secondary">↪ View Table</button>
                    </div>
                    <h3 class="metallic-bg">In a rush? Quickly add a new pallet with the form below!</h3>
                    <form class="metallic">
                        <div class="left-side">
                            <label>Choose Tote Type:</label>
                            <select>
                                <option>Tote Options</option>
                            </select>

                            <label>Assign Pallet to a Station:</label>
                            <select>
                                <option>Stations</option>
                            </select>
                        </div>
                        <div class="right-side">
                            <label>Choose Pallet Size:</label>
                            <div class="radio-row">
                                <label><input type="radio" name="size"> Small</label>
                                <label><input type="radio" name="size"> Medium</label>
                                <label><input type="radio" name="size"> Large</label>
                            </div>
                            <label>Specify Pallet Capacity:</label>
                            <input type="text" placeholder="Enter Number of Units">
                        </div>
                        <div class="button-row">
                            <button type="button" class="btn btn-wider btn-danger">Cancel</button>
                            <button type="button" class="btn btn-wider btn-okay">Save Pallet</button>
                        </div>
                    </form>
                </li>
                <li class="metallic small-widget">
                    <h2> Employees </h2>
                    <h3> Most Recent Entries:</h3>
                    <div>
                        <form id="user-form" action=""></form>
                        <table class="products-mini-table table table-striped">
                            <!-- Reworking table headers to match "product_variant" table -->
                            <!-- if sql tables get reworked, I suggest maybe adding a 'name' attribute to easily identify the product variants -->
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
                                    <?php foreach ($users as $key => $user): //<span class="dot green">
                                    ?>
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
                                                // TODO: change 'leave' for 'inactive' to account for vacation, sick days, etc.
                                                // ? leave sounds to similar to ending something and may be confused for terminated.
                                                echo '<span class="dot yellow"></span>';
                                                    break;
                                                case 'terminated':
                                                echo '<span class="dot red"></span>';
                                                    break;
                                                default:
                                            }
                                        ?>
                                        </td>
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
                    <form class="metallic" action="<?= APP_BASE_URL ?>/admin/variant" method="POST">
                            <div class="left-side">
                            <div class="reg-label">Registration Code :</div>
                            <input type="text" value="<?= $code ?>" readonly>

                            </div>
                            <div class="right-side">
                                <!-- <label>Search . .</label> -->
                                <input type="text" id="userSearchInput" placeholder="Search . .">

                                <button id="delete-user" type="button" class="btn btn-thin btn-danger">Delete Employee</button>
                            </div>
                        </form>
                </li>
            </ul>
            <ul id="dashboard-sections">
                <li>
                    <?php include __DIR__ . '/admin/employeesView.php'; ?>
                    <!-- TODO: create admin/employees overview -->
                </li>
                <li>
                    <?php include __DIR__ . '/admin/stationsView.php'; ?>
                    <!-- TODO: create admin/stations overview -->
                </li>
                <li>
                    <?php include __DIR__ . '/admin/storageView.php'; ?>
                    <!-- TODO: call admin/storage view -->
                </li>
                <li>
                    <?php include __DIR__ . '/admin/productsView.php'; ?>
                    <!-- TODO: create admin/products overview -->
                </li>
            </ul>

        <!-- NOT LOGGED IN-->
            <!-- <ul id="dashboard" class="center-v">
                <li><h1>You are not logged in.</h1></li>
            </ul> -->
        <?php endif; ?>
    </div>
</div>
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

<script>
    window.APP_BASE_URL = '<?= APP_BASE_URL ?>';
</script>
