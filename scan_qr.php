<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>QR Scanner</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        body {
            background: #f4f6f9;
        }

        .box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        #reader {
            width: 300px;
            margin: auto;
        }

        .result-box {
            margin-top: 20px;
        }
    </style>
</head>

<body>

<div class="container mt-4">

    <h2>📷 QR Scanner</h2>

    <div class="box mt-3 text-center">

        <!-- QR SCANNER -->
        <div id="reader"></div>

        <div class="result-box">

            <h5>Scanned Result</h5>

            <div id="result" class="alert alert-info">
                Waiting for scan...
            </div>

            <!-- ACTION BUTTONS -->
            <button class="btn btn-success" id="confirmBtn" disabled>
                ✅ Confirm Incentive
            </button>

            <button class="btn btn-danger" id="cancelBtn" disabled>
                ❌ Cancel
            </button>

        </div>

    </div>

</div>

<script>

let scannedData = "";

// QR SCAN SUCCESS
function onScanSuccess(decodedText) {

    scannedData = decodedText;

    document.getElementById("result").innerHTML =
        "<b>Student Data:</b><br>" + decodedText;

    document.getElementById("confirmBtn").disabled = false;
    document.getElementById("cancelBtn").disabled = false;
}

// INIT SCANNER
let html5QrcodeScanner = new Html5Qrcode("reader");

html5QrcodeScanner.start(
    { facingMode: "environment" },
    { fps: 10, qrbox: 200 },
    onScanSuccess
);

// CONFIRM BUTTON
document.getElementById("confirmBtn").addEventListener("click", function() {

    window.location.href = "confirm.php?data=" + encodeURIComponent(scannedData);

});

// CANCEL BUTTON
document.getElementById("cancelBtn").addEventListener("click", function() {

    document.getElementById("result").innerHTML = "Scan cancelled.";
    scannedData = "";

    document.getElementById("confirmBtn").disabled = true;
    document.getElementById("cancelBtn").disabled = true;

});

</script>

</body>
</html>