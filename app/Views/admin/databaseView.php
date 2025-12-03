<?php

use App\Helpers\ViewHelper;

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
            <tr>
                <td>1</td>
                <td>U-BASE Pods</td>
                <td>U-BASE</td>
                <td>NULL</td>
            </tr>
            <tr>
                <td>2</td>
                <td>100-BASE Pods</td>
                <td>100-BASE</td>
                <td>NULL</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Solution A</td>
                <td>SCI</td>
                <td>4400R</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Solution B</td>
                <td>SCI</td>
                <td>4405RCB</td>
            </tr>
            <tr>
                <td>5</td>
                <td>U-BASE Pods</td>
                <td>U-BASE</td>
                <td>NULL</td>
            </tr>
            <tr>
                <td>6</td>
                <td>Solution B</td>
                <td>SCI</td>
                <td>4405RCB</td>
            </tr>
            <tr>
                <td>7</td>
                <td>Solution A</td>
                <td>SCI</td>
                <td>4400R</td>
            </tr>
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
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
        </tr>
        </thead>

        <tbody>
        <tr><td><span class="dot green"></span></td><td>John Doe</td><td>514-000-0000</td><td>j_doe@email.com</td></tr>
        <tr><td><span class="dot yellow"></span></td><td>Jane Deer</td><td>438-000-0000</td><td>j_deer@email.com</td></tr>
        <tr><td><span class="dot green"></span></td><td>Jordan Moose</td><td>514-000-0000</td><td>j_moose@email.com</td></tr>
        <tr><td><span class="dot green"></span></td><td>Joe Caribou</td><td>514-000-0000</td><td>j_caribou@email.com</td></tr>
        <tr><td><span class="dot green"></span></td><td>Joann Elk</td><td>514-000-0000</td><td>j_elk@email.com</td></tr>
        <tr><td><span class="dot green"></span></td><td>Joseph Roe</td><td>514-000-0000</td><td>j_roe@email.com</td></tr>
        <tr><td><span class="dot yellow"></span></td><td>Jessica Taruca</td><td>438-000-0000</td><td>j_taruca@email.com</td></tr>
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
