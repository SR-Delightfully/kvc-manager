<?php

use App\Helpers\ViewHelper;

$page_title ='Dashboard Admin';
ViewHelper::loadHeader($page_title,true);
?>
<div class="dashboard-grid">

    <!-- LEFT: Leaderboard -->
    <div class="dashboard-left">
        <div class="leaderboard-container">
    <h2>Leaderboard</h2>

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
</div>
<!-- charts -->
 <!-- RIGHT: Teams Progress -->
    <div class="dashboard-right">
        <div class="team-progress-container">
    <h1 class="page-title">Work Overview</h1>

    <h2>Teams Progress</h2>
    <canvas id="teamsProgressChart"></canvas>
    <!-- Summary rows under the chart -->
    <div class="team-summary-list">
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
</div>
</div>
<div class="team-assignment-container">
    <h2>Team Assignment</h2>

    <div class="team-assignment-date">
        <span>Date:</span>
        <input type="text" value="2025/11/08" readonly>
    </div>


<div class="team-assignment-card">

    <!-- TEAM TEMPLATE (repeat for each team) -->
    <div class="team-group">
        <div class="team-header" onclick="toggleTeam(this)">
            <span class="team-label">Team 1 :</span>
            <span class="team-arrow">▼</span>
        </div>

        <div class="team-members">
            <!-- MEMBER ROW TEMPLATE -->
            <div class="member">
                <div class="avatar"></div>
                <span class="fname">First_Name1</span>
                <span class="lname">Last_Name1</span>
                <button class="remove-btn">Remove</button>
                <button class="contact-btn">Contact</button>
            </div>

            <div class="member">
                <div class="avatar"></div>
                <span class="fname">First_Name2</span>
                <span class="lname">Last_Name2</span>
                <button class="remove-btn">Remove</button>
                <button class="contact-btn">Contact</button>
            </div>
            <div class="member">
                <div class="avatar"></div>
                <span class="fname">First_Name3</span>
                <span class="lname">Last_Name3</span>
                <button class="remove-btn">Remove</button>
                <button class="contact-btn">Contact</button>
            </div>
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
                <div class="avatar"></div>
                <span class="fname">First_Name4</span>
                <span class="lname">Last_Name4</span>
                <button class="remove-btn">Remove</button>
                <button class="contact-btn">Contact</button>
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
                <div class="avatar"></div>
                <span class="fname">First_Name5</span>
                <span class="lname">Last_Name5</span>
                <button class="remove-btn">Remove</button>
                <button class="contact-btn">Contact</button>
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
                <div class="avatar"></div>
                <span class="fname">First_Name6</span>
                <span class="lname">Last_Name6</span>
                <button class="remove-btn">Remove</button>
                <button class="contact-btn">Contact</button>
            </div>
        </div>
    </div>

</div>



<?php
ViewHelper::loadJsScripts();
?>
<!-- for the chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('teamsProgressChart').getContext('2d');

const teamsProgressChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6"],
        datasets: [
            {
                label: "Team 1",
                data: [1.5, 1.7, 1.6, 1.8, 1.5, 2.0],
                borderColor: "#4da3ff",
                borderWidth: 2,
                tension: 0.3
            },
            {
                label: "Team 2",
                data: [1.3, 1.4, 1.5, 1.6, 1.2, 1.8],
                borderColor: "#ffb74d",
                borderWidth: 2,
                tension: 0.3
            },
            {
                label: "Team 3",
                data: [1.6, 2.0, 1.9, 2.1, 1.7, 2.2],
                borderColor: "#43d17b",
                borderWidth: 2,
                tension: 0.3
            },
            {
                label: "Team 4",
                data: [1.4, 1.6, 1.55, 1.7, 1.3, 1.9],
                borderColor: "#ff5252",
                borderWidth: 2,
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: "#fff",
                    font: { size: 14 }
                }
            }
        },
        scales: {
            x: {
                ticks: { color: "#bdbdbd" }
            },
            y: {
                ticks: { color: "#bdbdbd" },
                beginAtZero: false
            }
        }
    }
});

</script>

<?php
ViewHelper::loadFooter();
?>
