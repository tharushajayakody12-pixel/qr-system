<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: Arial;
            background:#eef2f7;
            padding:20px;
        }
        h2 { text-align:center; }

        .nav {
            text-align:center;
            margin-bottom:15px;
        }

        .nav a {
            padding:10px 20px;
            background:#333;
            color:white;
            text-decoration:none;
            margin:5px;
            border-radius:5px;
        }

        .top-bar {
            text-align:center;
            margin-bottom:15px;
        }

        canvas {
            background:white;
            padding:20px;
            border-radius:10px;
        }
    </style>
</head>
<body>

<h2>📊 Production Chart</h2>

<div class="nav">
    <a href="dashboard.php">📋 Table</a>
    <a href="chart.php">📊 Chart</a>
</div>

<?php
// 🔥 RANGE SELECT (default today)
$from = isset($_GET['from']) && $_GET['from'] != '' ? $_GET['from'] : date("Y-m-d");
$to   = isset($_GET['to']) && $_GET['to'] != '' ? $_GET['to'] : date("Y-m-d");

// 🔥 CHART DATA WITH RANGE
$chart = $conn->query("
    SELECT line_no, SUM(qty) as total_qty 
    FROM records 
    WHERE created_date BETWEEN '$from' AND '$to'
    GROUP BY line_no
");

$labels = [];
$data = [];

while($c = $chart->fetch_assoc()) {
    $labels[] = "Line " . $c['line_no'];
    $data[] = $c['total_qty'];
}
?>

<!-- 🔥 RANGE FILTER -->
<div class="top-bar">
    <form method="GET">
        From: <input type="date" name="from" value="<?= $from ?>">
        To: <input type="date" name="to" value="<?= $to ?>">
        <button type="submit">Filter</button>
    </form>
</div>

<!-- 🔥 CHART -->
<canvas id="myChart"></canvas>

<script>
new Chart(document.getElementById("myChart"), {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'QTY by Line',
            data: <?= json_encode($data) ?>
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>