<?php
session_start();
include "config.php";

if (!isset($_SESSION['student_id']) || $_SESSION['role'] !== "student") {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$student = $conn->query("SELECT * FROM students WHERE student_id='$student_id'")->fetch_assoc();

$total = $conn->query("
    SELECT SUM(points) as total_points 
    FROM awards 
    WHERE student_id='$student_id'
")->fetch_assoc();

$total_points = $total['total_points'] ?? 0;

$qr_data = implode("|", [
    $student['name'],
    $student['student_id'],
    $student['course'],
    $student['year_level'],
    $total_points
]);

$qr_image = "https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=" . urlencode($qr_data);
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{background:#f4f6f9;font-family:Segoe UI;}
.card-box{background:white;padding:20px;border-radius:12px;box-shadow:0 0 10px rgba(0,0,0,0.1);}
</style>
</head>

<body>

<div class="container mt-4">

<h3>Welcome, <?php echo $student['name']; ?></h3>

<div class="row mt-3">

<div class="col-md-6">
<div class="card-box">
<h5>⭐ Total Points</h5>
<h2><?php echo $total_points; ?> PTS</h2>
</div>
</div>

<div class="col-md-6 text-center">
<div class="card-box">
<h5>📱 QR Code</h5>
<img src="<?php echo $qr_image; ?>" width="180">
</div>
</div>

</div>

<br>

<div class="d-flex gap-2">

<a href="redeem_points.php" class="btn btn-primary">🎁 Redeem Points</a>

<!-- 🔥 SAFE BACK (NO LOGIN LOOP) -->
<a href="student_dashboard.php" class="btn btn-secondary">⬅ Back</a>

<a href="logout.php" class="btn btn-danger">🚪 Logout</a>

</div>

</div>

</body>
</html>

