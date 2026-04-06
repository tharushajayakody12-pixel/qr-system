<?php include 'db.php'; ?>

<?php
$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM records WHERE id=$id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>QR Page</title>

<style>
body {
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    background: linear-gradient(135deg, #0f4c81, #00a9a5);
    font-family:Arial;
}

.box {
    background:white;
    padding:25px;
    border-radius:15px;
    text-align:center;
    width:280px;
}

.logo img { width:120px; }

.qr img { width:180px; }

button {
    margin-top:10px;
    padding:10px;
    width:100%;
    border:none;
    border-radius:5px;
    color:white;
}

.print { background:#00a9a5; }
.preview { background:#ff9800; }
.next { background:#0f4c81; }

</style>
</head>

<body>

<div class="box">

<div class="logo">
<img src="./image-removebg-preview.png">
</div>

<h3><?= $row['lot_no'] ?></h3>

<div class="qr">
<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=http://localhost/qr-system/view.php?id=<?= $id ?>">
</div>

<button class="print" onclick="window.print()">Print</button>
<button class="preview" onclick="window.location.href='view.php?id=<?= $id ?>'">Preview</button>
<button class="next" onclick="window.location.href='index.php'">Next</button>

</div>

</body>
</html>