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

var_dump($products);

$page_title = 'Database Overview';
ViewHelper::loadHeader($page_title, true);
?>
<!-- products section -->
 <div class="products-page">

    <!-- LEFT — PRODUCTS TABLE -->
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
        <label>Product Options</label>
        <select>
            <option>Product Options</option>
        </select>

        <div class="quick-add-title">Quick Add :</div>

        <input type="text" placeholder="Enter Product Code">
        <input type="text" placeholder="Enter Product Name">
        <select>
            <option>Select Product Type</option>
        </select>

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
        <span class="dot green">
            <?php foreach ($users as $key => $user): //<span class="dot green">
                 ?>
                <tr>
                    <td><?php
                        switch ($user['user_role']) {
                            case 'active':
                                ?>
                                <span class="dot green"> <?php
                                break;
                            case 'leave':
                                ?>
                                <span class="dot yellow"> <?php
                                break;
                            case 'terminated':
                                ?>
                                <span class="dot red"> <?php
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
        <h2>P A L L E T S</h2>
        <button class="jump-btn">Jump To ↪</button>
    </div>

    <div class="quick-title">Quick Add :</div>

    <div class="form-grid">

        <!-- LEFT SIDE -->
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

        <!-- RIGHT SIDE -->
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

    </div>

    <div class="button-row">
        <button class="cancel-btn">Cancel</button>
        <button class="save-btn">Save Pallet</button>
    </div>

</div>


<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
