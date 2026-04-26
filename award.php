<?php
session_start();
include "config.php";

$message = "";

if(isset($_POST['award'])){

    $student_id = $_POST['student_id'];

    $data = explode("|", $_POST['achievement']);
    $achievement = $data[0];
    $points = $data[1];

    // INSERT TO AWARDS TABLE
    $conn->query("INSERT INTO awards (student_id, achievement, points)
                  VALUES ('$student_id', '$achievement', '$points')");

    // UPDATE STUDENT TOTAL POINTS
    $conn->query("UPDATE students
                  SET points = points + $points
                  WHERE student_id='$student_id'");

    $message = "✅ Award successfully given!";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Award Student Incentive</title>

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

<div class="container mt-4">

<div class="card-box">

<h3>🏆 Award Student Incentive</h3>

<p class="text-muted">Select achievement to give points</p>

<?php if($message != ""){ ?>

<div class="alert alert-success">
<?php echo $message; ?>
</div>

<?php } ?>

<form method="POST">

<div class="row">

<!-- STUDENT ID -->
<div class="col-md-3">

<label>Student ID</label>

<input type="text" name="student_id" class="form-control" placeholder="e.g. S004" required>

</div>

<!-- ACHIEVEMENT -->
<div class="col-md-6">

<label>Achievement</label>

<select name="achievement" class="form-control" required>

<option value="">Select Achievement</option>
<option value="Basketball Champion|30">🏀 Basketball Champion (+30 pts)</option>
<option value="Volleyball Champion|30">🏐 Volleyball Champion (+30 pts)</option>
<option value="Leadership Award|40">🎯 Leadership Award (+40 pts)</option>
<option value="Academic Excellence|50">📚 Academic Excellence (+50 pts)</option>

</select>

</div>

<!-- BUTTON -->
<div class="col-md-3">

<label>Action</label>

<button type="submit" name="award" class="btn btn-success w-100">
Give Award
</button>

</div>

</div>

</form>

<hr>

<p class="text-muted">
✔ Points are automatically added to student records
</p>

<!-- 🔥 BACK BUTTON ADDED -->
<a href="teacher_dashboard.php" class="btn btn-secondary mt-2">
⬅ Back to Dashboard
</a>

</div>

</div>

</body>
</html>

