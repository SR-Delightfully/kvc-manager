<?php
use App\Domain\Models\UserModel;
?>

<?php if (!empty($isFooterShown)): ?>
<div id="footer" class="lang-switch">
    <h4>
        <a href="">EN</a> - <a href="">FR</a>
    </h4>

    <h3>
        <?= isset($userCount) ? $userCount : '0' ?> registered employees — join the team, register today.
    </h3>

    <h4>
        <span id="datetime-display"></span>
    </h4>
</div>
<?php endif; ?>

<script src="./public/assets/js/04-Login-Script.js"></script>
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
</body>
</html>
