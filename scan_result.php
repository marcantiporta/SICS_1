<?php
include "config.php";

if (!isset($_GET['data'])) {
    die("No QR data received");
}

$data = explode("|", $_GET['data']);

if (count($data) < 4) {
    die("Invalid QR format");
}

$name = $data[0];
$student_id = $data[1];
$course = $data[2];
$year = $data[3];

// check student exists
$check = $conn->query("SELECT * FROM students WHERE student_id='$student_id'");

if ($check->num_rows == 0) {
    die("Student not found in database");
}

echo "
<div class='card p-3'>

<h4>🎓 Student Info</h4>

<p><b>Name:</b> $name</p>
<p><b>ID:</b> $student_id</p>
<p><b>Course:</b> $course</p>
<p><b>Year:</b> $year</p>

<hr>

<a href='confirm.php?id=$student_id' class='btn btn-success'>✅ Confirm Incentive</a>
<a href='scan_qr.php' class='btn btn-danger'>❌ Cancel</a>

</div>
";
?>