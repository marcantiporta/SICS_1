<?php
session_start();
include "config.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "teacher") {
    header("Location: login.php");
    exit();
}

/* 🔥 TOTAL AWARDS GIVEN */
$total_awards = $conn->query("
    SELECT COUNT(*) as total 
    FROM awards
")->fetch_assoc();

/* 🔥 TOTAL STUDENTS WHO RECEIVED INCENTIVES */
$total_students = $conn->query("
    SELECT COUNT(DISTINCT student_id) as total 
    FROM awards
")->fetch_assoc();

/* 🔥 RECENT QR SCANS (based on latest confirmations) */
$recent_scans = $conn->query("
    SELECT COUNT(*) as total 
    FROM awards
    WHERE DATE(date_awarded) = CURDATE()
")->fetch_assoc();

/* 🔥 LATEST 5 AWARDS (for activity feed) */
$latest = $conn->query("
    SELECT students.name, awards.achievement, awards.points, awards.id
    FROM awards
    INNER JOIN students ON students.student_id = awards.student_id
    ORDER BY awards.id DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>

<title>Teacher Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f9;
font-family:Segoe UI;
}

.sidebar{
height:100vh;
width:220px;
background:#1f2d3d;
position:fixed;
padding-top:20px;
color:white;
}

.sidebar a{
display:block;
color:#cfd8dc;
padding:12px;
text-decoration:none;
}

.sidebar a:hover{
background:#34495e;
color:white;
}

.content{
margin-left:220px;
padding:30px;
}

.card-box{
background:white;
padding:20px;
border-radius:12px;
box-shadow:0 0 10px rgba(0,0,0,0.1);
}

.stat-box{
background:#fff;
padding:20px;
border-radius:12px;
text-align:center;
box-shadow:0 0 10px rgba(0,0,0,0.1);
}

.stat-box h2{
margin:0;
}

</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

<h4 class="text-center">👨‍🏫 Teacher Panel</h4>

<hr>

<a href="teacher_dashboard.php">🏠 Dashboard</a>
<a href="award.php">🏆 Award Points</a>
<a href="scan_qr.php">📷 Scan QR</a>
<a href="student_records.php">📊 Student Records</a>
<a href="logout.php">🚪 Logout</a>

</div>

<!-- CONTENT -->
<div class="content">

<h3>📊 Dashboard Overview</h3>

<div class="row mt-4">

<!-- TOTAL AWARDS -->
<div class="col-md-4">
<div class="stat-box">
<h5>🏆 Total Incentives</h5>
<h2><?php echo $total_awards['total']; ?></h2>
</div>
</div>

<!-- TOTAL STUDENTS -->
<div class="col-md-4">
<div class="stat-box">
<h5>🎓 Students Rewarded</h5>
<h2><?php echo $total_students['total']; ?></h2>
</div>
</div>

<!-- QR SCANS TODAY -->
<div class="col-md-4">
<div class="stat-box">
<h5>📷 QR Scans Today</h5>
<h2><?php echo $recent_scans['total']; ?></h2>
</div>
</div>

</div>

<br>

<!-- RECENT ACTIVITY -->
<div class="card-box">

<h5>📌 Recent Awards</h5>

<table class="table table-striped text-center">

<thead class="table-dark">
<tr>
<th>Student</th>
<th>Achievement</th>
<th>Points</th>
</tr>
</thead>

<tbody>

<?php while($row = $latest->fetch_assoc()){ ?>

<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['achievement']; ?></td>
<td><span class="badge bg-success"><?php echo $row['points']; ?> PTS</span></td>
</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</body>
</html>

