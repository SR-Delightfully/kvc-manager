<?php

use App\Helpers\ViewHelper;

$page_title = 'Database Overview';
ViewHelper::loadHeader($page_title, true);
ViewHelper::loadSideBar();
?>

<div id="rpt-dashboard-container">


    <div id="rpt-top-tabs">
        <a href="<?= APP_BASE_URL ?>/reports" class="rpt-tab rpt-active">Daily Progress</a>
        <a href="" class="rpt-tab">All Time Progress</a>
    </div>


    <div id="atp-chart-filters">
        <!-- PRODUCT SELECT -->
        <form action="" method="GET">
            <select name="" id="">
                <option value="solution_a">Solution A</option>
                <option value="solution_b">Solution B</option>
                <option value="100_base_pods">100-Base Pods</option>
                <option value="u_base_pods">U-Base Pods</option>
            </select>
            <select name="" id="">
                <option value="">Units Produced</option>
                <option value="">Units/Hr</option>
                <option value="">Pallets Completed</option>
                <option value="">Breaks</option>
            </select>
        </form>
    </div>


    <div style="width:100%; height:350px;">
        <canvas id="rptChart"></canvas>
    </div>


    <div class="atp-time-filters">
        <button class="atp-time-btn">1D</button>
        <button class="atp-time-btn">1W</button>
        <button class="atp-time-btn">1M</button>
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
