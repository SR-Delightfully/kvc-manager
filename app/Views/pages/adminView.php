<?php

use App\Helpers\ViewHelper;
use App\Helpers\UserContext;

$page_title = 'Welcome to KVC Manager!';

$currentUser = UserContext::getCurrentUser();

$isAdmin = UserContext::isAdmin();
$isEmployee = UserContext::isEmployee();
?>

<div id="home-page-wrapper" class="page">
    <div id="home-page-content">
        <?php if ($isAdmin): ?>
            <ul id="backend-dashboard" class="center-v">
                <!-- Products Component -->
                <li class="metallic-bg">
                    <h2> Products </h2>
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
                    <div>
                        <table class="products-mini-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Product Type</th>
                                    <th>Product Code</th>
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
                                    <td>4400RCB</td>
                                </tr>
                                <!-- etc. -->
                            </tbody>
                        </table>
                        <form>
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
                        </form>
                    </div>
                </li>
                <!-- Schedule Component -->
                <li>
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
                            <button class="cancel-btn">Cancel</button>
                            <button class="save-btn">Save Schedule</button>
                        </div>
                    </form>
                </li>
                <!-- Pallet Component -->
                <li>
                    <div class="pallet-header">
                        <h2>P A L L E T S</h2><button class="jump-btn">Jump To ↪</button>
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
                            <button class="cancel-btn">Cancel</button>
                            <button class="save-btn">Save Pallet</button>
                        </div>
                    </form>
                </li>
                <!-- Employees Component -->
                <li class="metallic-bg">
                    <h2>E M P L O Y E E S</h2>
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
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
                    <form>
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
                    </form>
                </li>   
            </ul>
        <?php else: ?>
            <!-- just adding this twice because i dont want to login -->
            <ul id="backend-dashboard" class="center-v">
                <!-- Products Component -->
                <li class="metallic-bg">
                    <h2> Products </h2>
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
                    <div>
                        <table class="products-mini-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Product Type</th>
                                    <th>Product Code</th>
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
                                    <td>4400RCB</td>
                                </tr>
                                <!-- etc. -->
                            </tbody>
                        </table>
                        <form>
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
                        </form>
                    </div>
                </li>
                <!-- Schedule Component -->
                <li>
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
                            <button class="cancel-btn">Cancel</button>
                            <button class="save-btn">Save Schedule</button>
                        </div>
                    </form>
                </li>
                <!-- Pallet Component -->
                <li>
                    <div class="pallet-header">
                        <h2>P A L L E T S</h2><button class="jump-btn">Jump To ↪</button>
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
                            <button class="cancel-btn">Cancel</button>
                            <button class="save-btn">Save Pallet</button>
                        </div>
                    </form>
                </li>
                <!-- Employees Component -->
                <li class="metallic-bg">
                    <h2>E M P L O Y E E S</h2>
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
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
                    <form>
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
                    </form>
                </li>   
            </ul>
        <?php endif; ?>
    </div>
</div>
