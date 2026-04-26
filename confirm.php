<?php
session_start();
include "config.php";

if (!isset($_GET['data'])) {
    header("Location: scan_qr.php");
    exit();
}

$data = explode("|", $_GET['data']);

/* SAFE ASSIGNMENT (IMPORTANT FIX) */
$name   = $data[0] ?? '';
$id     = $data[1] ?? '';
$course = $data[2] ?? '';
$year   = $data[3] ?? '';
$points = isset($data[4]) ? intval($data[4]) : 0;

/* SAFETY: if QR has no points, get from DB */
if ($points == 0 && !empty($id)) {
    $res = $conn->query("SELECT SUM(points) as total FROM awards WHERE student_id='$id'");
    $row = $res->fetch_assoc();
    $points = $row['total'] ?? 0;
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Confirm Incentive</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f9;
font-family:Segoe UI;
}

.card-box{
background:white;
padding:25px;
border-radius:12px;
box-shadow:0 0 10px rgba(0,0,0,0.1);
}

</style>

</head>

<body>

<div class="container mt-5">

<div class="card-box">

<h3>🔎 Confirm Student Incentive</h3>

<hr>

<h5>Student Information</h5>

<p><b>Name:</b> <?php echo $name; ?></p>
<p><b>Student ID:</b> <?php echo $id; ?></p>
<p><b>Course:</b> <?php echo $course; ?></p>
<p><b>Year Level:</b> <?php echo $year; ?></p>

<hr>

<h5>Incentive Details</h5>

<p>
<b>Points to be Added:</b>
<span class="badge bg-success">
<?php echo $points; ?> PTS
</span>
</p>

<hr>

<div class="d-flex gap-2">

<a href="success.php?data=<?php echo urlencode($_GET['data']); ?>" class="btn btn-success">
✅ Confirm Incentive
</a>

<a href="scan_qr.php" class="btn btn-danger">
❌ Cancel
</a>

</div>

</div>

</div>

</body>
</html>

