<?php
session_start();
include "config.php";

if (!isset($_SESSION['student_id']) || $_SESSION['role'] !== "student") {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$total = $conn->query("
    SELECT SUM(points) as total_points 
    FROM awards 
    WHERE student_id='$student_id'
")->fetch_assoc();

$current_points = $total['total_points'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Redeem Points</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{background:#f4f6f9;font-family:Segoe UI;}
.card-box{background:white;padding:20px;border-radius:12px;box-shadow:0 0 10px rgba(0,0,0,0.1);}
</style>
</head>

<body>

<div class="container mt-4">

<h3>🎁 Student Redeem Points</h3>

<p><b>Current Points:</b> <?php echo $current_points; ?> PTS</p>

<div class="card-box">

<table class="table table-bordered text-center">

<tr class="table-dark">
<th>Required Points</th>
<th>Grade Bonus</th>
<th>Description</th>
<th>Status</th>
</tr>

<tr>
<td>50 PTS</td>
<td>+0.5</td>
<td>Minor Achievement</td>
<td><?php echo ($current_points>=50)?"Eligible":"Not Eligible"; ?></td>
</tr>

<tr>
<td>100 PTS</td>
<td>+1.0</td>
<td>Good Performance</td>
<td><?php echo ($current_points>=100)?"Eligible":"Not Eligible"; ?></td>
</tr>

<tr>
<td>150 PTS</td>
<td>+1.5</td>
<td>Outstanding</td>
<td><?php echo ($current_points>=150)?"Eligible":"Not Eligible"; ?></td>
</tr>

</table>

</div>

<br>

<a href="student_dashboard.php" class="btn btn-primary">
⬅ Back to Dashboard
</a>

</div>

</body>
</html>
