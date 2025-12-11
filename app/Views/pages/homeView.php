<?php

use App\Helpers\ViewHelper;
use App\Helpers\UserContext;

$page_title = 'Welcome to KVC Manager!';

$currentUser = UserContext::getCurrentUser();

$isAdmin = UserContext::isAdmin();
$isEmployee = UserContext::isEmployee();
?>

<div id="page-wrapper" class="page">
    <div id="page-content">
        <!-- This is the admin's view -->
        <?php if ($isAdmin): ?>
            <ul id="dashboard" class="center-v">
                <li>
                    <h2> Leaderboard </h2>
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
                    <div class="bars">
                        <div class="bar bar1" style="height: 70%">
                            <span class="rank">1</span>
                        </div>
                        <div class="bar bar2" style="height: 55%">
                            <span class="rank">2</span>
                        </div>
                        <div class="bar bar3" style="height: 35%">
                            <span class="rank">3</span>
                        </div>
                    </div>
                    <div>
                        <table class="leaderboard-table">
                            <tr>
                                <th>Team Name</th>
                                <th>Units</th>
                                <th>Speed</th>
                            </tr>
                            <tr><td>Team_1</td><td>384</td><td>4u/min</td></tr>
                            <tr><td>Team_2</td><td>284</td><td>3.5u/min</td></tr>
                            <tr><td>Team_3</td><td>181</td><td>3u/min</td></tr>
                            <tr><td>Team_4</td><td>145</td><td>2u/min</td></tr>
                        </table>
                    </div>
                </li>
                <li>
                    <h2> Schedule </h2>
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
                    <div>
                        <!-- Quick view of data -->
                        <!-- Calendar -->
                    </div>  
                </li>
                <li>
                    <h2> Team Assignment </h2>
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
                    <div>
                        <div class="team-assignment-date">
                            <span>Date:</span>
                            <input type="text" value="2025/11/08" readonly>
                        </div>

                        <!-- TODO: clean up code, use php to create a loop to dynamically render data -->
                        <div class="team-assignment-card">
                            <!-- TEAM TEMPLATE (repeat for each team) -->
                            <div class="team-group">
                                <div class="team-header" onclick="toggleTeam(this)">
                                    <h3 class="team-label">Team 1 :</h3>
                                    <span class="team-arrow">▼</span>
                                </div>
                                <!-- MEMBER ROW TEMPLATE -->
                                <div class="team-members">
                                    <div class="member">
                                        <img href="/" class="avatar"></img>
                                        <p class="fname">First_Name1</p>
                                        <p class="lname">Last_Name1</p>
                                        <button class="btn btn-thin btn-danger">Remove</button>
                                        <button class="btn btn-thin btn-okay">Contact</button>
                                    </div>
                                    <div class="member">
                                        <img href="/" class="avatar"></img>
                                        <p class="fname">First_Name2</p>
                                        <p class="lname">Last_Name2</p>
                                        <button class="btn btn-thin btn-danger">Remove</button>
                                        <button class="btn btn-thin btn-okay">Contact</button>
                                    </div>
                                <div class="member">
                                    <img href="/" class="avatar"></img>
                                    <p class="fname">First_Name3</p>
                                    <p class="lname">Last_Name3</p>
                                    <button class="btn btn-thin btn-danger">Remove</button>
                                    <button class="btn btn-thin btn-okay">Contact</button>
                                </div>
                            </div>
                            <!-- Repeat for Team 2, Team 3, Team 4 -->
                            <div class="team-group">
                                <div class="team-header" onclick="toggleTeam(this)">
                                    <span class="team-label">Team 2 :</span>
                                    <span class="team-arrow">▼</span>
                                </div>
                                <div class="team-members">
                                    <div class="member">
                                        <img href="/" class="avatar"></img>
                                        <p class="fname">First_Name4</p>
                                        <p class="lname">Last_Name4</p>
                                        <button class="btn btn-thin btn-danger">Remove</button>
                                        <button class="btn btn-thin btn-okay">Contact</button>
                                    </div>
                                </div>
                            </div>

                            <div class="team-group">
                                <div class="team-header" onclick="toggleTeam(this)">
                                    <span class="team-label">Team 3 :</span>
                                    <span class="team-arrow">▼</span>
                                </div>
                                <div class="team-members">
                                    <div class="member">
                                        <img href="/" class="avatar"></img>
                                        <p class="fname">First_Name5</p>
                                        <p class="lname">Last_Name5</p>
                                        <button class="btn btn-thin btn-danger">Remove</button>
                                        <button class="btn btn-thin btn-okay">Contact</button>
                                    </div>
                                </div>
                            </div>

                            <div class="team-group">
                                <div class="team-header" onclick="toggleTeam(this)">
                                    <span class="team-label">Team 4 :</span>
                                    <span class="team-arrow">▼</span>
                                </div>
                                <div class="team-members">
                                    <div class="member">
                                        <img href="/" class="avatar"></img>
                                        <p class="fname">First_Name6</p>
                                        <p class="lname">Last_Name6</p>
                                        <button class="btn btn-thin btn-danger">Remove</button>
                                        <button class="btn btn-thin btn-okay">Contact</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <h2> Work Overview </h2>
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
                    <div>
                        <!-- Point graph of team work progress-->
                    </div>
                    <div>
                        <!-- Quick view of data -->
                        <!-- Either a table of a Ul -->
                    </div>
                </li>
            </ul>

        <!-- This is the employee's view -->              
        <?php elseif ($isEmployee): ?>
            <ul id="dashboard" class="center-v">
                <li class="metallic-bg">
                    <h2> Leaderboard </h2>
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
                    <div>
                        <!-- Leaderboard bar graph of top 3 -->
                    </div>
                    <div>
                        <!-- Quick view of data -->
                        <!-- Either a table of a OL? -->
                        <!-- I think an OL might make more sense since we're keeping track of the place value -->
                    </div>
                </li>
                <li>
                    <h2> Schedule </h2>
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
                    <div>
                        <!-- Quick view of data -->
                        <!-- Calendar -->
                    </div>  
                </li>
                <li>
                    <h2> Team Assignment </h2>
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
                    <div>
                        <!-- Quick view of data -->
                        <!-- List of team drop downs -->
                    </div>
                </li>
                <li class="metallic-bg">
                    <h2> Work Overview </h2>
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
                    <div>
                        <!-- Point graph of team work progress-->
                    </div>
                    <div>
                        <!-- Quick view of data -->
                        <!-- Either a table of a Ul -->
                    </div>
                </li>
            </ul>

        <?php else: ?>
        <!-- NOT LOGGED IN-->
            <!-- <p>You are not logged in.</p> -->
            <ul id="dashboard" class="center-v">
                <!-- Leaderboard Component -->
                <li id="leaderboard-card-admin" class="metallic small-widget">
                    <h2> Leaderboard </h2>
                    <h3> Our teams ranked by their packaging speeds</h3>
                    <div class="bars metallic-bg">
                        <div class="bar bar1" style="height: 70%">
                            <span class="rank">1</span>
                        </div>
                        <div class="bar bar2" style="height: 55%">
                            <span class="rank">2</span>
                        </div>
                        <div class="bar bar3" style="height: 35%">
                            <span class="rank">3</span>
                        </div>
                    </div>
                    <div id="leaderboard-table-wrapper">
                        <table class="leaderboard-table">
                            <tr>
                                <th>Team Name</th>
                                <th>Units</th>
                                <th>Speed</th>
                            </tr>
                            <tr><td>Team_1</td><td>384</td><td>4u/min</td></tr>
                            <tr><td>Team_2</td><td>284</td><td>3.5u/min</td></tr>
                            <tr><td>Team_3</td><td>181</td><td>3u/min</td></tr>
                            <tr><td>Team_4</td><td>145</td><td>2u/min</td></tr>
                        </table>
                    </div>
                </li>
                <!-- Team Assignment Component -->
                <li id="teamAssignment-card-admin" class="mini-widget">
                    <div class="header">            
                        <h2> Team Assignment </h2>
                    </div>  
                    <h3> Decide who is on what team today! </h3>
                    <div>
                        <div class="team-assignment-date">
                            <span>Date:</span>
                            <input type="text" value="2025/11/08" readonly>
                        </div>
                        <!-- TODO: clean up code, use php to create a loop to dynamically render data -->
                        <div id="team-assignment-card">
                            <!-- TEAM TEMPLATE (repeat for each team) -->
                            <div class="team-group">
                                <div class="team-header" onclick="toggleTeam(this)">
                                    <span class="team-label">Team 1 :</span>
                                    <span class="team-arrow">▼</span>
                                </div>
                                <!-- MEMBER ROW TEMPLATE -->
                                <div class="team-members">
                                    <div class="member">
                                        <img href="/" class="avatar"></img>
                                        <p class="fname">First_Name1</span>
                                        <p class="lname">Last_Name1</span>
                                        <button class="btn btn-thin btn-danger">Remove</button>
                                        <button class="btn btn-thin btn-okay">Contact</button>
                                    </div>
                                    <div class="member">
                                        <img href="/" class="avatar"></img>
                                        <p class="fname">First_Name2</span>
                                        <p class="lname">Last_Name2</span>
                                        <button class="btn btn-thin btn-danger">Remove</button>
                                        <button class="btn btn-thin btn-okay">Contact</button>
                                    </div>
                                <div class="member">
                                    <img href="/" class="avatar"></img>
                                    <p class="fname">First_Name3</span>
                                    <p class="lname">Last_Name3</span>
                                    <button class="btn btn-thin btn-danger">Remove</button>
                                    <button class="btn btn-thin btn-okay">Contact</button>
                                </div>
                            </div>
                            <!-- Repeat for Team 2, Team 3, Team 4 -->
                            <div class="team-group">
                                <div class="team-header" onclick="toggleTeam(this)">
                                    <span class="team-label">Team 2 :</span>
                                    <span class="team-arrow">▼</span>
                                </div>
                                <div class="team-members">
                                    <div class="member">
                                        <img href="/" class="avatar"></img>
                                        <p class="fname">First_Name4</span>
                                        <p class="lname">Last_Name4</span>
                                        <button class="btn btn-thin btn-danger">Remove</button>
                                        <button class="btn btn-thin btn-okay">Contact</button>
                                    </div>
                                </div>
                            </div>

                            <div class="team-group">
                                <div class="team-header" onclick="toggleTeam(this)">
                                    <span class="team-label">Team 3 :</span>
                                    <span class="team-arrow">▼</span>
                                </div>
                                <div class="team-members">
                                    <div class="member">
                                        <img href="/" class="avatar"></img>
                                        <p class="fname">First_Name5</span>
                                        <p class="lname">Last_Name5</span>
                                        <button class="btn btn-thin btn-danger">Remove</button>
                                        <button class="btn btn-thin btn-okay">Contact</button>
                                    </div>
                                </div>
                            </div>

                            <div class="team-group">
                                <div class="team-header" onclick="toggleTeam(this)">
                                    <span class="team-label">Team 4 :</span>
                                    <span class="team-arrow">▼</span>
                                </div>
                                <div class="team-members">
                                    <div class="member">
                                        <img href="/" class="avatar"></img>
                                        <p class="fname">First_Name6</span>
                                        <p class="lname">Last_Name6</span>
                                        <button class="btn btn-thin btn-danger">Remove</button>
                                        <button class="btn btn-thin btn-okay">Contact</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Schedule Component -->
                <li id="Schedule-card-admin" class="mini-widget">
                    <div class="header">
                        <h2> Schedule </h2>
                    </div>  

                    <h3> Future implementation:</h3>
                        <form>
                        <!-- Quick view of data -->
                        <!-- Calendar -->
                         <p>Here you would find a calendar</p>
                         <p> and a list of employees your schedules</p>
                        </form>
                </li >
                <!-- Work Overview Component -->
                <li id="teamProgress-card-admin" class="metallic small-widget">
                    <h2> Team Progress </h2>
                    <h3> [Component SubTitle] (a quick explanation of the contents) </h3>
                    <div class="metallic-bg">
                        <canvas id="teamsProgressChart"></canvas>
                    </div>
                    <div id="team-summary-list-wrapper">
                        <div class="team-summary-row best">
                            <span class="team-name">Best Team</span>
                            <span class="summary-item">Date: <span class="value">2025/11/08</span></span>
                            <span class="summary-item">Number of Units: <span class="value">74</span></span>
                            <span class="summary-item">Speed: <span class="value">3.5/min</span></span>
                        </div>

                        <div class="team-summary-row">
                            <span class="team-name">Team 1</span>
                            <span class="summary-item">Date: <span class="value">2025/11/13</span></span>
                            <span class="summary-item">Number of Units: <span class="value">48</span></span>
                            <span class="summary-item">Speed: <span class="value">2/min</span></span>
                        </div>

                        <div class="team-summary-row">
                            <span class="team-name">Team 2</span>
                            <span class="summary-item">Date: <span class="value">2025/11/13</span></span>
                            <span class="summary-item">Number of Units: <span class="value">26</span></span>
                            <span class="summary-item">Speed: <span class="value">1.25/min</span></span>
                        </div>
                    </div>
                </li>
            </ul>

            
        <!-- NOT LOGGED IN-->
            <!-- <ul id="dashboard" class="center-v">
                <li><h1>You are not logged in.</h1></li>
            </ul> -->
        <?php endif; ?>
    </div>
</div>
