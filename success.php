<?php
include "config.php";

$data = explode("|", $_GET['data']);

$name = $data[0];
$id = $data[1];
$course = $data[2];
$year = $data[3];
$points = $data[4];

// UPDATE STUDENT POINTS (IMPORTANT FIX)
$conn->query("UPDATE students 
SET points = points + $points 
WHERE student_id='$id'");
?>

<!DOCTYPE html>
<html>
<head>

<title>Success</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="alert alert-success">

<h3>✅ Incentive Successfully Applied</h3>

<p><b>Name:</b> <?php echo $name; ?></p>
<p><b>Student ID:</b> <?php echo $id; ?></p>

<p><b>Points Added:</b> <?php echo $points; ?> PTS</p>

<hr>

<a href="teacher_dashboard.php" class="btn btn-primary">
⬅ Return to Dashboard
</a>

</div>

</div>

</body>
</html>

