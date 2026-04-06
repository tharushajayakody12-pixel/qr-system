<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body {
    font-family: Arial;
    background: linear-gradient(135deg, #0f4c81, #00a9a5);
    margin:0;
    padding:20px;
}

/* HEADER */
.header {
    display:flex;
    justify-content:space-between;
    align-items:center;
}

/* LOGO */
.logo-center {
    display:flex;
    justify-content:center;
    margin:30px 0;
}

.logo-center img {
    width:320px;
    filter: drop-shadow(0 0 6px white)
            drop-shadow(0 0 10px white)
            drop-shadow(0 0 15px white);
}

/* NAV */
.nav a {
    padding:10px 15px;
    background:#222;
    color:white;
    border-radius:6px;
    margin-left:10px;
    text-decoration:none;
}

/* FILTER BAR */
.filter-bar {
    text-align:center;
    margin:15px 0;
}

.filter-bar input {
    padding:8px;
    margin:5px;
}

.filter-btn {
    padding:8px 15px;
    background:#00a9a5;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.filter-btn:hover {
    background:#0f4c81;
}

.download-btn {
    background:#ff9800;
}

/* SUMMARY */
.summary {
    display:flex;
    justify-content:center;
    gap:20px;
    flex-wrap:wrap;
}

.box {
    background:white;
    padding:20px;
    border-radius:10px;
    width:200px;
    text-align:center;
}

.box i {
    color:#00a9a5;
    font-size:22px;
}

/* TABLE */
table {
    width:100%;
    background:white;
    border-collapse:collapse;
    margin-top:20px;
}

th {
    background:#0f4c81;
    color:white;
    padding:10px;
    position:relative;
}

.filter-icon {
    margin-left:5px;
    cursor:pointer;
    font-size:12px;
}

td {
    padding:8px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

tr:hover {
    background:#f2f2f2;
}

/* BUTTON */
.view-btn {
    background:#00a9a5;
    color:white;
    padding:5px 10px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

/* 🔥 POPUP */
.filter-popup {
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
    background:white;
    padding:20px;
    border-radius:10px;
    display:none;
    width:250px;
    box-shadow:0 10px 30px rgba(0,0,0,0.4);
    z-index:999;
}

.filter-popup input {
    width:100%;
    margin:5px 0 10px;
    padding:6px;
}

.filter-popup button {
    width:48%;
    padding:8px;
    margin-top:5px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    background:#00a9a5;
    color:white;
}
</style>

</head>
<body>

<div class="header">
    <div style="color:white;font-size:20px;">Ansell</div>

    <div class="nav">
        <a href="dashboard.php">Table</a>
        <a href="chart.php">Chart</a>
    </div>
</div>

<!-- LOGO -->
<div class="logo-center">
    <img src="./image-removebg-preview.png">
</div>

<!-- FILTER BAR -->
<div class="filter-bar">
<form method="GET">
From: <input type="date" name="from">
To: <input type="date" name="to">

<button class="filter-btn">Filter</button>
<button type="button" class="filter-btn download-btn" onclick="downloadExcel()">Download Excel</button>
</form>
</div>

<?php
$from = $_GET['from'] ?? date("Y-m-d");
$to = $_GET['to'] ?? date("Y-m-d");
$line = $_GET['line'] ?? '';

$data = $conn->query("
SELECT COALESCE(SUM(qty),0) as total_qty, COUNT(*) as total_records 
FROM records 
WHERE created_date BETWEEN '$from' AND '$to'
");

$d = $data->fetch_assoc();
?>

<!-- SUMMARY -->
<div class="summary">

<div class="box">
<i class="fa fa-box"></i>
<h3>Range QTY</h3>
<h1><?= $d['total_qty'] ?></h1>
</div>

<div class="box">
<i class="fa fa-list"></i>
<h3>Total Records</h3>
<h1><?= $d['total_records'] ?></h1>
</div>

<div class="box">
<i class="fa fa-arrow-down"></i>
<h3>Previous</h3>
<h1>0</h1>
</div>

<div class="box">
<i class="fa fa-chart-line"></i>
<h3>Difference</h3>
<h1 style="color:green;"><?= $d['total_qty'] ?></h1>
</div>

</div>

<!-- TABLE -->
<table id="dataTable">

<tr>
<th>Date <i class="fa fa-filter filter-icon" onclick="openFilter()"></i></th>
<th>Time</th>
<th>Lot</th>
<th>Reporting</th>
<th>Fabric</th>
<th>MO1</th>
<th>MO2</th>
<th>MO3</th>
<th>QTY</th>
<th>Line</th>
<th>PSO</th>
<th>Line MO</th>
<th>Action</th>
</tr>

<?php
$query = "
SELECT * FROM records 
WHERE created_date BETWEEN '$from' AND '$to'
";

if($line != ''){
    $query .= " AND line_no = '$line'";
}

$query .= " ORDER BY id DESC";

$result = $conn->query($query);

while($row = $result->fetch_assoc()){
echo "<tr>
<td>{$row['created_date']}</td>
<td>{$row['created_time']}</td>
<td>{$row['lot_no']}</td>
<td>{$row['reporting_person']}</td>
<td>{$row['fabric_type']}</td>
<td>{$row['mo1']}</td>
<td>{$row['mo2']}</td>
<td>{$row['mo3']}</td>
<td>{$row['qty']}</td>
<td>{$row['line_no']}</td>
<td>{$row['pso_no']}</td>
<td>{$row['line_mo']}</td>

<td>
<button class='view-btn' onclick=\"window.location.href='qr.php?id={$row['id']}'\">
View
</button>
</td>

</tr>";
}
?>

</table>

<!-- 🔥 FILTER POPUP -->
<div id="filterPopup" class="filter-popup">

<h3>Filter Data</h3>

<label>From Date</label>
<input type="date" id="f_from">

<label>To Date</label>
<input type="date" id="f_to">

<label>Line No</label>
<input type="text" id="f_line">

<button onclick="applyFilter()">Apply</button>
<button onclick="closeFilter()">Close</button>

</div>

<script>
function openFilter(){
    document.getElementById("filterPopup").style.display = "block";
}

function closeFilter(){
    document.getElementById("filterPopup").style.display = "none";
}

function applyFilter(){
    let from = document.getElementById("f_from").value;
    let to = document.getElementById("f_to").value;
    let line = document.getElementById("f_line").value;

    let url = "dashboard.php?";

    if(from) url += "from=" + from + "&";
    if(to) url += "to=" + to + "&";
    if(line) url += "line=" + line;

    window.location.href = url;
}

function downloadExcel(){
let table = document.getElementById("dataTable").outerHTML;
let url = 'data:application/vnd.ms-excel,' + encodeURIComponent(table);
let a = document.createElement("a");
a.href = url;
a.download = "data.xls";
a.click();
}
</script>

</body>
</html>