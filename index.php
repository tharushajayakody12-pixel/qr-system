<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';
date_default_timezone_set("Asia/Colombo");
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $rp = $_POST['reporting_person'] ?? '';
    $fabric = $_POST['fabric_type'] ?? '';
    $mo1 = $_POST['mo1'] ?? '';
    $mo2 = $_POST['mo2'] ?? '';
    $mo3 = $_POST['mo3'] ?? '';
    $qty = $_POST['qty'] ?? 0;
    $line = $_POST['line_no'] ?? '';
    $pso = $_POST['pso_no'] ?? '';
    $linemo = $_POST['line_mo'] ?? '';

    $today = date("Y-m-d");
    $time = date("h:i:s A");

    $result = $conn->query("SELECT COUNT(*) as total FROM records WHERE created_date = '$today'");
    $row = $result->fetch_assoc();
    $count = $row['total'] + 1;

    $number = str_pad($count, 3, "0", STR_PAD_LEFT);
    $lot_no = date("ymd") . "-" . $number;

    $sql = "INSERT INTO records 
    (lot_no, reporting_person, fabric_type, mo1, mo2, mo3, qty, line_no, pso_no, line_mo, created_date, created_time)
    VALUES ('$lot_no','$rp','$fabric','$mo1','$mo2','$mo3','$qty','$line','$pso','$linemo','$today','$time')";

    if ($conn->query($sql) === TRUE) {

        $last_id = $conn->insert_id;

        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Print QR</title>
            <style>
                body {
                    margin:0;
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
                    box-shadow:0 10px 25px rgba(0,0,0,0.3);
                    width:280px;
                }

                .logo img {
                    width:120px;
                    margin-bottom:10px;
                }

                h2 {
                    color:#0f4c81;
                }

                .qr img {
                    width:180px;
                }

                .btns {
                    display:flex;
                    flex-direction:column;
                    gap:8px;
                    margin-top:10px;
                }

                button {
                    padding:10px;
                    border:none;
                    border-radius:6px;
                    font-size:14px;
                    cursor:pointer;
                    color:white;
                }

                .print { background:#00a9a5; }
                .preview { background:#ff9800; }
                .next { background:#0f4c81; }

                button:hover { opacity:0.9; }

                @media print {
                    button { display:none; }
                    body { background:white; }
                }
            </style>
        </head>
        <body>

        <div class='box'>

            <div class='logo'>
                <img src='./image-removebg-preview.png'>
            </div>

            <h2>Lot No: $lot_no</h2>

            <div class='qr'>
                <img src='https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://qr-system.rf.gd/view.php?id=$last_id'>
            </div>

            <div class='btns'>
                <button class='print' onclick='window.print()'>🖨️ Print</button>

                <button class='preview' onclick=\"window.location.href='view.php?id=$last_id'\">👁 Preview</button>

                <button class='next' onclick=\"window.location.href='index.php'\">➡️ Next</button>
            </div>

        </div>

        </body>
        </html>
        ";
        exit();

    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>QR System</title>

<style>
body {
    font-family: Arial;
    background: linear-gradient(135deg, #0f4c81, #00a9a5);
    margin:0;
    display:flex;
    justify-content:center;
    align-items:flex-start;
    min-height:100vh;
    padding:20px 0;
}

.card {
    background:white;
    padding:25px;
    border-radius:15px;
    width:340px;
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
    text-align:center;
    margin-top:20px;
}

.logo img {
    width:150px;
    margin-bottom:10px;
}

h2 {
    color:#0f4c81;
}

label {
    display:block;
    text-align:left;
    margin-top:10px;
    font-weight:bold;
}

input {
    width:100%;
    padding:8px;
    margin-top:5px;
    border-radius:5px;
    border:1px solid #ccc;
}

button {
    margin-top:20px;
    width:100%;
    padding:10px;
    background:#00a9a5;
    color:white;
    border:none;
    border-radius:5px;
    font-size:16px;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="card">

<div class="logo">
<img src="./image-removebg-preview.png">
</div>

<h2>BP - Hood Assembling</h2>

<form method="POST">

<label>Reporting Person</label>
<input type="text" name="reporting_person" required>

<label>Fabric Type</label>
<input type="text" name="fabric_type" required>

<label>MO 1</label>
<input type="text" name="mo1" required>

<label>MO 2</label>
<input type="text" name="mo2" required>

<label>MO 3</label>
<input type="text" name="mo3" required>

<label>QTY</label>
<input type="number" name="qty" required>

<label>Line No</label>
<input type="text" name="line_no" required>

<label>PSO No</label>
<input type="text" name="pso_no" required>

<label>Line MO</label>
<input type="text" name="line_mo" required>

<button type="submit">Submit</button>

</form>

</div>

</body>
</html>