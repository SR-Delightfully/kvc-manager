<?php

use App\Helpers\ViewHelper;

$page_title = 'Reports - Admin';
ViewHelper::loadHeader($page_title, true);
ViewHelper::loadSideBar();
?>



<div id="rpt-dashboard-container">

    <!-- Top Tabs -->
    <div id="rpt-top-tabs">

        <a href="" class="rpt-tab rpt-active">Daily Progress</a>

        <!-- DATE FILTER -->
        <div class="rpt-date-filter">

            <button id="rpt-dateButton" class="rpt-tab rpt-date-btn" onclick="rpt_toggleDateDropdown()">
                Choose Date: Default today
            </button>

            <div class="rpt-date-dropdown" id="rpt-dateDropdown">
                <div class="rpt-dropdown-item" onclick="rpt_setDateFilter('Default Today')">Default Today</div>
                <div class="rpt-dropdown-item" onclick="rpt_setDateFilter('This Month')">This Month</div>
                <div class="rpt-dropdown-item" onclick="rpt_setDateFilter('This Year')">This Year</div>
            </div>

        </div>

        <a href="<?= APP_BASE_URL ?>/reports/all-time" class="rpt-tab rpt-active">All Time Progress</a>

    </div>

    <!-- Station 1 -->
    <div class="rpt-station">

        <div class="rpt-station-header" onclick="rpt_toggleStation(this)">
            <span>Station 1: Solution A, Team members</span>
            <span class="rpt-arrow">∨</span>
        </div>

        <div class="rpt-station-details">

            <div class="rpt-metrics-grid">
                <div class="rpt-metric-title">Metric</div>
                <div class="rpt-metric-title">Value</div>
                <div class="rpt-metric-title">Comparison</div>

                <div>Units Made</div><div>1028</div><div>+20% vs Last Week</div>
                <div>Pallets Completed</div><div>6</div><div>+20% vs Last Week</div>
                <div>Rate (units/hr)</div><div>352</div><div>+13% vs Avg</div>
                <div>DownTime</div><div>32 min</div><div>-6% vs Last Week</div>
            </div>

            <div class="rpt-progress-bar">
                <div class="rpt-progress-fill" style="width:40%;"></div>
            </div>

            <h4 class="rpt-sub-title">Units Compared to Last Week</h4>

        </div>
    </div>

    <!-- Station 2 -->
    <div class="rpt-station">

        <div class="rpt-station-header" onclick="rpt_toggleStation(this)">
            <span>Station 2: Solution B, Team members</span>
            <span class="rpt-arrow">∨</span>
        </div>

        <div class="rpt-station-details">

            <div class="rpt-metrics-grid">
                <div class="rpt-metric-title">Metric</div>
                <div class="rpt-metric-title">Value</div>
                <div class="rpt-metric-title">Comparison</div>

                <div>Units Made</div><div>1544</div><div>+12% vs Last Week</div>
                <div>Pallets Completed</div><div>4</div><div>+5% vs Last Week</div>
                <div>Rate (units/hr)</div><div>223</div><div>+2% vs Avg</div>
                <div>DownTime</div><div>41 min</div><div>-3% vs Last Week</div>
            </div>

            <div class="rpt-progress-bar">
                <div class="rpt-progress-fill" style="width:40%;"></div>
            </div>

            <h4 class="rpt-sub-title">Units Compared to Last Week</h4>

        </div>
    </div>

    <!-- Station 3 -->
    <div class="rpt-station">

        <div class="rpt-station-header" onclick="rpt_toggleStation(this)">
            <span>Station 3: Pods, Team members</span>
            <span class="rpt-arrow">∨</span>
        </div>

        <div class="rpt-station-details">

            <div class="rpt-metrics-grid">
                <div class="rpt-metric-title">Metric</div>
                <div class="rpt-metric-title">Value</div>
                <div class="rpt-metric-title">Comparison</div>

                <div>Units Made</div><div>2010</div><div>+8% vs Last Week</div>
                <div>Pallets Completed</div><div>7</div><div>+10% vs Last Week</div>
                <div>Rate (units/hr)</div><div>286</div><div>+3% vs Avg</div>
                <div>DownTime</div><div>22 min</div><div>-4% vs Last Week</div>
            </div>

            <div class="rpt-progress-bar">
                <div class="rpt-progress-fill" style="width:40%;"></div>
            </div>

            <h4 class="rpt-sub-title">Units Compared to Last Week</h4>

        </div>
    </div>


        <!-- Summary -->
        <div id="summary-card">
            <h2>Summary:</h2>

            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Total Units Today</th>
                        <th>Avg Rate</th>
                        <th>vs Last Week</th>
                        <th>vs Global avg</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Solution A</td>
                        <td>2913</td>
                        <td>323</td>
                        <td>328 (-5%)</td>
                        <td>318 (+2%)</td>
                    </tr>

                    <tr>
                        <td>Solution B</td>
                        <td>1544</td>
                        <td>223</td>
                        <td>227 (+2%)</td>
                        <td>210 (-6%)</td>
                    </tr>

                    <tr>
                        <td>Pods</td>
                        <td>2010</td>
                        <td>286</td>
                        <td>275 (+3%)</td>
                        <td>300 (-4%)</td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>

</div>

<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
