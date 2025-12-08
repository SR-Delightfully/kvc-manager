<?php

use App\Helpers\ViewHelper;

$page_title = 'Database Overview';
ViewHelper::loadHeader($page_title, true);
?>

<div id="rpt-dashboard-container">


    <div id="rpt-top-tabs">
        <a href="" class="rpt-tab rpt-active">Daily Progress</a>
        <a href="" class="rpt-tab">All Time Progress</a>
    </div>


    <div id="rpt-chart-filters">


        <div class="rpt-select" onclick="rpt_toggleSelect(this)">
            <div class="rpt-select-header">
                <span id="rpt-product-label">Solution A</span>
                <span class="rpt-arrow">⌄</span>
            </div>

            <div class="rpt-select-options">
                <div onclick="rpt_setProduct('Solution A')">Solution A</div>
                <div onclick="rpt_setProduct('Solution B')">Solution B</div>
                <div onclick="rpt_setProduct('100-Base Pods')">100-Base Pods</div>
                <div onclick="rpt_setProduct('U-Base Pods')">U-Base Pods</div>
            </div>
        </div>


        <div class="rpt-select" onclick="rpt_toggleSelect(this)">
            <div class="rpt-select-header">
                <span id="rpt-metric-label">Units Produced</span>
                <span class="rpt-arrow">⌄</span>
            </div>

            <div class="rpt-select-options">
                <div onclick="">Units Produced</div>
                <div onclick="">Units/hr</div>
                <div onclick="">Pallets</div>
                <div onclick="">Breaks</div>
            </div>
        </div>
    </div>


    <div style="width:100%; height:350px;">
        <canvas id="rptChart"></canvas>
    </div>


    <div class="time-filters">
        <button class="time-btn">1D</button>
        <button class="time-btn">1W</button>
        <button class="time-btn">1M</button>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// simple fake data for now
const rpt_fakeData = {
    "Units Produced": [220, 300, 260, 410, 300, 360, 250],

};

// initial chart
const ctx = document.getElementById("rptChart");

let rptChart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
        datasets: [{
            label: "Units Produced",
            data: rpt_fakeData["Units Produced"],
            backgroundColor: "#D9D9D9",
            borderRadius: 8,
            barPercentage: 0.6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false }},
        scales: {
            y: { ticks: { color: "#ffffff" }},
            x: { ticks: { color: "#ffffff" }}
        }
    }
});

// dropdown
function rpt_toggleSelect(selectBox) {
    const boxOpen = selectBox.classList.contains("open");

    document.querySelectorAll(".rpt-select").forEach(s => {
        s.classList.remove("open");
        s.querySelector(".rpt-select-options").style.display = "none";
    });

    if (!boxOpen) {
        selectBox.classList.add("open");
        selectBox.querySelector(".rpt-select-options").style.display = "flex";
    }
}



</script>

<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
