<?php
session_start();
include "config.php";

/* 🔐 TEACHER ONLY ACCESS */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "teacher") {
    header("Location: login.php");
    exit();
}

/* 🔥 SAFE QUERY */
$sql = "
SELECT 
    s.student_id,
    s.name,
    s.course,
    s.year_level,
    IFNULL(a.achievement, 'No Record') AS achievement,
    IFNULL(a.points, 0) AS points
FROM students s
LEFT JOIN awards a 
ON s.student_id = a.student_id
ORDER BY s.student_id ASC
";

$result = $conn->query($sql);

if(!$result){
    die("SQL ERROR: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Student Records</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f9;
font-family:Segoe UI;
}

.card-box{
background:white;
padding:20px;
border-radius:12px;
box-shadow:0 0 10px rgba(0,0,0,0.1);
}

</style>

</head>

<body>

<div class="container mt-4">

<div class="card-box">

<h3>📊 Student Records (Incentives)</h3>

<table class="table table-bordered table-striped text-center mt-3">

<thead class="table-dark">
<tr>
<th>Student ID</th>
<th>Name</th>
<th>Course</th>
<th>Year Level</th>
<th>Achievement</th>
<th>Points</th>
</tr>
</thead>

<tbody>

<?php if($result->num_rows > 0){ ?>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>
<td><?php echo $row['student_id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['course']; ?></td>
<td><?php echo $row['year_level']; ?></td>
<td><?php echo $row['achievement']; ?></td>
<td>
<span class="badge bg-success">
<?php echo $row['points']; ?> PTS
</span>
</td>
</tr>

<?php } ?>

<?php } else { ?>

<tr>
<td colspan="6">No records found</td>
</tr>

<?php } ?>

</tbody>

</table>

<!-- 🔥 BACK BUTTON ADDED -->
<a href="teacher_dashboard.php" class="btn btn-secondary mt-3">
⬅ Back to Dashboard
</a>

</div>

</div>

</body>
</html>

