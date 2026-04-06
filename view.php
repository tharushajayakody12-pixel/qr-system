<?php include 'db.php'; ?>

<?php
$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM records WHERE id=$id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Production Details</title>

<style>
body {
    font-family: Arial;
    background: linear-gradient(135deg, #0f4c81, #00a9a5);
    margin:0;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.card {
    background:white;
    padding:18px;
    border-radius:12px;
    width:300px;
    box-shadow:0 8px 20px rgba(0,0,0,0.25);
}

.logo {
    text-align:center;
    margin-bottom:5px;
}

.logo img {
    width:150px;
}

.lot {
    text-align:center;
    font-size:16px;
    font-weight:bold;
    color:#0f4c81;
    margin-bottom:5px;
}

h2 {
    text-align:center;
    margin-bottom:10px;
    font-size:18px;
    color:#00a9a5;
}

.row {
    display:flex;
    justify-content:space-between;
    padding:6px 0;
    border-bottom:1px solid #eee;
    font-size:14px;
}

.label {
    font-weight:bold;
    color:#555;
}

.value {
    color:#222;
}

/* 🔥 BUTTON STYLE */
.btn {
    margin-top:10px;
    width:100%;
    padding:10px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    color:white;
    font-size:14px;
}

.back-btn { background:#0f4c81; }
.back-btn:hover { background:#00a9a5; }

</style>
</head>

<body>

<div class="card">

    <!-- LOGO -->
    <div class="logo">
        <img src="./image-removebg-preview.png" 
             onerror="this.src='https://via.placeholder.com/150?text=Logo';">
    </div>

    <!-- LOT -->
    <div class="lot">
        Lot No: <?= $row['lot_no'] ?>
    </div>

    <h2>Production Details</h2>

    <div class="row"><span class="label">Reporting</span><span class="value"><?= $row['reporting_person'] ?></span></div>
    <div class="row"><span class="label">Fabric</span><span class="value"><?= $row['fabric_type'] ?></span></div>
    <div class="row"><span class="label">MO1</span><span class="value"><?= $row['mo1'] ?></span></div>
    <div class="row"><span class="label">MO2</span><span class="value"><?= $row['mo2'] ?></span></div>
    <div class="row"><span class="label">MO3</span><span class="value"><?= $row['mo3'] ?></span></div>
    <div class="row"><span class="label">QTY</span><span class="value"><?= $row['qty'] ?></span></div>
    <div class="row"><span class="label">Line</span><span class="value"><?= $row['line_no'] ?></span></div>
    <div class="row"><span class="label">PSO</span><span class="value"><?= $row['pso_no'] ?></span></div>
    <div class="row"><span class="label">Line MO</span><span class="value"><?= $row['line_mo'] ?></span></div>
    <div class="row"><span class="label">Date</span><span class="value"><?= $row['created_date'] ?></span></div>

    <div class="row">
        <span class="label">Time</span>
        <span class="value">
            <?= $row['created_time'] ? date("h:i A", strtotime($row['created_time'])) : '' ?>
        </span>
    </div>

    <!-- 🔥 BACK TO QR PAGE (CORRECT FIX) -->
    <button class="btn back-btn" onclick="window.location.href='qr.php?id=<?= $id ?>'">
        ⬅ Back to QR
    </button>

</div>

</body>
</html>