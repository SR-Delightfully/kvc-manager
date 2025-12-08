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

// Declaring boolean variables to perform checks, ensuring we edit/delete the right record.
// ! TODO: rework webroutes to match these subroutes ⬇
// ! TODO: rework Sidebar to match these subroutes (and their subroutes) ⬇

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

                <!-- Products Component -->
                <!-- Displays the most recent product variant entries -->
                <li class="metallic-bg small-widget">
                    <h2> Products </h2>
                    <h3> Most Recent Entries:</h3>

                    <!-- Some of the information is not necessary to be displayed right away and will be commented out... -->
                    <div>
                        <table class="products-small table table table-striped">
                            <!-- Reworking table headers to match "product_variant" table -->
                            <!-- if sql tables get reworked, I suggest maybe adding a 'name' attribute to easily identify the product variants -->
                            <thead>
                                <tr>
                                    <!-- <th>Product ID:</th> -->
                                    <th>Product Type:</th>
                                    <th>Product Colour:</th>
                                    <th>Product Size:</th>
                                    <th>Product Description:</th>
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
                                        <!-- <td></?= $variant['product_id']?></td> -->
                                        <td><?= $variant['colour_id']?></td> <!-- TODO: get color_name from colours table by colour_id -->
                                        <td><?= $variant['unit_size']?></td>
                                        <td><?= $variant['variant_description']?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <form action="<?= APP_BASE_URL ?>/admin/variant" method="POST">
                        <div class="left-side">
                            <h3 class="quick-add-title">Quick Add :</h3>

                            <label></label>
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
                                    <option value=""></option>
                                    <?php foreach ($colours as $colour): ?>
                                        <option value="<?= $colour['colour_id'] ?>">
                                            <?= $colour['colour_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                            <!-- TODO: create table or array variable to hold sizes  -->
                            <!-- TODO: use for each to display options (in case they carry most sizes in the future)-->
                            <label for="">Unit Size</label>
                                <select name="unit_size" class="form-select" id="unit_size">
                                    <option value=""></option>
                                    <option value="0.5L">0.5L</option>
                                    <option value="1L">1L</option>
                                    <option value="2L">2L</option>
                                    <option value="4L">4L</option>
                                    <option value="8L">8L</option>
                                </select>

                            <input name="variant_description" type="text" placeholder="Enter Product Description">
                        </div>
                        <div class="right-side">
                            <label>Search . .</label>
                            <input type="text" placeholder="Search . .">

                            <div class="actions-title">Actions :</div>

                            <button class="btn btn-thin btn-okay">View Product</button>
                            <button class="btn btn-thin btn-warning">Edit Product</button>
                            <button class="btn btn-thin btn-danger">Delete Product</button>
                            <button class="btn btn-wide btn-primary">Jump To ↪</button>
                        </div>
                    </form>
                </li>
                <!-- // * Suggestion, instead of schedule, display stations (station_id, station_name, team_num, team_members (a dropdown?))   -->
                <!-- Schedule Component -->
                <li class="mini-widget">
                    <div class="schedule-header">
                        <h2>S C H E D U L E S</h2><button class="jump-btn">Jump To ↪</button>
                    </div>  
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
                    <form>
                        <h2 class="quick-title">Quick Add :</h2>
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
                            <button class="btn btn-thin btn-danger">Cancel</button>
                            <button class="btn btn-thin btn-okay">Save Schedule</button>
                        </div>
                    </form>
                </li>
                <!-- Pallet Component -->
                <li class="mini-widget">
                    <div class="pallet-header">
                        <h2>P A L L E T S</h2><button class="btn btn-wide btn-pimary">Jump To ↪</button>
                    </div>  
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
                    <form>
                        <h2 class="quick-title">Quick Add :</h2>
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
                            <button class="btn btn-thin btn-danger">Cancel</button>
                            <button class="btn btn-thin btn-okay">Save Pallet</button>
                        </div>
                    </form>
                </li>
                <!-- Employees Component -->
                <li class="metallic-bg small-widget">
                    <h2>Employees</h2>
                    <h3>Recent Entries:</h3>
                    <table>
                        <thead>
                        <tr>
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
                    <form>
                        <div class="left-side">
                            <select>
                                <option>Employee Status</option>
                            </select>

                            <div class="reg-label">Registration Code :</div>
                            <input type="text" value="XJ8M32N" readonly> 
                            <!-- TODO: get actual code from database -->
                            <!-- TODO: create registration_code table so we keep track of codes used and avoid reusing the same code twice. -->
                            <button class="btn btn-wide btn-primary">Jump To ↪</button>
                        </div>

                        <div class="right-side">
                            <input class="search" type="text" placeholder="Search . .">

                            <div class="actions-title">Actions :</div>
                            <button class="btn btn-thin btn-okay">View Employee</button>
                            <button class="btn btn-thin btn-warning">Edit Employee</button>
                            <button class="btn btn-thin btn-danger">Delete Employee</button>
                        </div>
                    </form>
                </li>   
            </ul>
            <ul id="sections">
                <li>
                    <!-- TODO: call admin/users view -->
                    <!-- TODO: move big users table to this file -->
                    <!-- TODO: move big schedules to this file -->
                    <!-- TODO: move big shifts table to this file -->
                </li>
                <li>
                    <!-- TODO: call admin/stations view -->
                    <!-- TODO: move big stations table to this file -->
                    <!-- TODO: move big team table to this file -->
                    <!-- TODO: move big team members table to this file -->
                </li>
                <li>
                    <!-- TODO: call admin/storage view -->
                    <!-- TODO: move big pallets table to this file -->
                    <!-- TODO: move big totes table to this file -->
                </li>
                <li>
                    <!-- TODO: call admin/products view -->
                    <!-- TODO: move big products table to this file -->
                    <!-- TODO: move big product_type table to this file -->
                    <!-- TODO: move big product_variant table to this file -->

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
                    <div>
                        <table class="products-mini-table table table-striped">
                            <!-- Reworking table headers to match "product_variant" table -->
                            <!-- if sql tables get reworked, I suggest maybe adding a 'name' attribute to easily identify the product variants -->
                            <thead>
                                <tr>
                                    <!-- <th>Product ID:</th> -->
                                    <th>Product Type:</th>
                                    <th>Product Colour:</th>
                                    <th>Product Size:</th>
                                    <th>Product Description:</th>
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
                                        <!-- <td></?= $variant['product_id']?></td> -->
                                        <td><?= $variant['colour_id']?></td> <!-- TODO: get color_name from colours table by colour_id -->
                                        <td><?= $variant['unit_size']?></td>
                                        <td><?= $variant['variant_description']?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>                        
                    <form class="metallic" action="<?= APP_BASE_URL ?>/admin/variant" method="POST">
                            <div class="left-side">
                                <!-- <h3 class="quick-add-title">Quick Add :</h3> -->

                                <!-- <label></label> -->
                                <select name="product_id" class="select" id="product_id">
                                    <option value="">Select Product Id</option>
                                    <?php foreach ($products as $product): ?>
                                        <option value="<?= $product['product_id'] ?>">
                                            <?= $product['product_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <label for=""></label>
                                    <select name="colour_id" class="select" id="colour_id">
                                        <option value="">Select Colour Id</option>
                                        <?php foreach ($colours as $colour): ?>
                                            <option value="<?= $colour['colour_id'] ?>">
                                                <?= $colour['colour_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                <!-- TODO: create table or array variable to hold sizes  -->
                                <!-- TODO: use for each to display options (in case they carry most sizes in the future)-->
                                <label for=""></label>
                                    <select name="unit_size" class="select" id="unit_size">
                                        <option value="">Select Unit Size</option>
                                        <option value="0.5L">0.5L</option>
                                        <option value="1L">1L</option>
                                        <option value="2L">2L</option>
                                        <option value="4L">4L</option>
                                        <option value="8L">8L</option>
                                    </select>

                                <input name="variant_description" type="text" placeholder="Enter Product Description">
                            </div>
                            <div class="right-side">
                                <!-- <label>Search . .</label> -->
                                <input type="text" placeholder="Search . .">

                                <!-- <div class="actions-title">Actions :</div> -->

                                <button class="btn btn-wide btn-okay">View Product</button>
                                <button class="btn btn-thin btn-warning">Edit Product</button>
                                <button class="btn btn-thin btn-danger">Delete Product</button>
                                <button class="btn btn-wide btn-primary">Jump To ↪</button>
                            </div>
                        </form>
                </li>
                <!-- // * Suggestion, instead of schedule, display stations (station_id, station_name, team_num, team_members (a dropdown?))   -->
                <!-- Schedule Component -->
                <li class="mini-widget">
                    <div class="schedule-header">
                        <h2>S C H E D U L E S</h2><button class="btn btn-thin btn-secondary">Jump To ↪</button>
                    </div>  
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
                    <form>
                        <h2 class="quick-title">Quick Add :</h2>
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
                            <button class="btn btn-wide btn-danger">Cancel</button>
                            <button class="btn btn-wide btn-okay">Save Schedule</button>
                        </div>
                    </form>
                </li>
                <!-- Pallet Component -->
                <li class="mini-widget">
                    <div class="pallet-header">
                        <h2>P A L L E T S</h2><button class="btn btn-thin btn-secondary">Jump To ↪</button>
                    </div>  
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
                    <form>
                        <h2 class="quick-title">Quick Add :</h2>
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
                            <button class="btn btn-wide btn-danger">Cancel</button>
                            <button class="btn btn-wide btn-okay">Save Pallet</button>
                        </div>
                    </form>
                </li>
                <li class="metallic small-widget">
                    <h2> Employees </h2>
                    <h3> Most Recent Entries:</h3>
                    <div>
                        <table class="products-mini-table table table-striped">
                            <!-- Reworking table headers to match "product_variant" table -->
                            <!-- if sql tables get reworked, I suggest maybe adding a 'name' attribute to easily identify the product variants -->
                            <thead>
                                <tr>
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
                    <form class="metallic" action="<?= APP_BASE_URL ?>/admin/variant" method="POST">
                            <div class="left-side">
                            <div class="reg-label">Registration Code :</div>
                            <input type="text" value="XJ8M32N" readonly> 


                                <label for=""></label>
                                    <select name="colour_id" class="select" id="colour_id">
                                        <option value="">Select Colour Id</option>
                                        <?php foreach ($colours as $colour): ?>
                                            <option value="<?= $colour['colour_id'] ?>">
                                                <?= $colour['colour_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                <!-- TODO: create table or array variable to hold sizes  -->
                                <!-- TODO: use for each to display options (in case they carry most sizes in the future)-->
                                <label for=""></label>
                                    <select name="unit_size" class="select" id="unit_size">
                                        <option value="">Select Unit Size</option>
                                        <option value="0.5L">0.5L</option>
                                        <option value="1L">1L</option>
                                        <option value="2L">2L</option>
                                        <option value="4L">4L</option>
                                        <option value="8L">8L</option>
                                    </select>

                                <input name="variant_description" type="text" placeholder="Enter Product Description">
                            </div>
                            <div class="right-side">
                                <!-- <label>Search . .</label> -->
                                <input type="text" placeholder="Search . .">

                                <!-- <div class="actions-title">Actions :</div> -->

                                <button class="btn btn-wide btn-okay">View Employee</button>
                                <button class="btn btn-thin btn-warning">Edit Employee</button>
                                <button class="btn btn-thin btn-danger">Delete Employee</button>
                                <button class="btn btn-wide btn-primary">Jump To ↪</button>
                            </div>
                        </form>
                </li>
            </ul>
            <ul id="dashboard-sections">
                <li>
                    <?php include __DIR__ . '/admin/employeesView.php'; ?>
                    <!-- TODO: create admin/employees overview -->
                    <!-- TODO: move big employees table to this file -->
                    <!-- TODO: move big schedules to this file -->
                    <!-- TODO: move big shifts table to this file -->
                </li>
                <li>
                    <?php include __DIR__ . '/admin/stationsView.php'; ?>
                    <!-- TODO: create admin/stations overview -->
                    <!-- TODO: move big stations table to this file -->
                    <!-- TODO: move big team table to this file -->
                    <!-- TODO: move big team members table to this file -->
                </li>
                <li>
                    <?php include __DIR__ . '/admin/storageView.php'; ?>
                    <!-- TODO: call admin/storage view -->
                    <!-- TODO: create admin/storage overview -->
                    <!-- TODO: move big pallets table to this file -->
                    <!-- TODO: move big totes table to this file -->
                </li>
                <li>
                    <?php include __DIR__ . '/admin/productsView.php'; ?>
                    <!-- TODO: create admin/products overview -->
                    <!-- TODO: move big products table to this file -->
                    <!-- TODO: move big product_type table to this file -->
                    <!-- TODO: move big product_variant table to this file -->
                </li>
            </ul>
        <?php endif; ?>
    </div>
</div>
