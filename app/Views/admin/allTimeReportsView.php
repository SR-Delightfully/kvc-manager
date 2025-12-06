<?php

use App\Helpers\ViewHelper;

$page_title = 'Database Overview';
ViewHelper::loadHeader($page_title, true);
?>


<!-- to be completed!! -->
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

        <a href="" class="rpt-tab rpt-active">All Time Progress</a>

    </div>
    <div class="alltime-chart-wrapper">


    <div class="dropdown product-dropdown">
        <button class="dropdown-btn">
            Solution A
            <span class="arrow">⌄</span>
        </button>

        <div class="dropdown-menu">
            <div class="dropdown-item">Solution B</div>
            <div class="dropdown-item">100-Base Pods</div>
            <div class="dropdown-item">U-Base Pods</div>
        </div>
    </div>


    <div class="dropdown metric-dropdown">
        <button class="dropdown-btn">
            Units Produced
            <span class="arrow">⌄</span>
        </button>

        <div class="dropdown-menu">
            <div class="dropdown-item">Units/hr</div>
            <div class="dropdown-item">Pallets</div>
            <div class="dropdown-item">Breaks</div>
        </div>
    </div>



    <div class="chart-area">

        <div class="chart-placeholder">
          <!-- to be completed -->
        </div>
    </div>

    <div class="time-filters">
        <button class="time-btn">1D</button>
        <button class="time-btn">1W</button>
        <button class="time-btn">1M</button>
    </div>

</div>


<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
