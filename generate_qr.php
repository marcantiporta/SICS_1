<?php
include "config.php";

$student_id = $_GET['id'];

$sql = "SELECT * FROM students WHERE student_id='$student_id'";
$result = $conn->query($sql);

$row = $result->fetch_assoc();

$data = $row['name']."|".$row['student_id']."|".$row['course']."|".$row['year_level'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student QR Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-5">

<div class="card p-4 text-center">

    <h3>🎓 Student QR Code</h3>

    <p><b><?php echo $row['name']; ?></b></p>
    <p><?php echo $row['student_id']; ?></p>
    <p><?php echo $row['course']; ?> - <?php echo $row['year_level']; ?></p>

    <hr>

    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo urlencode($data); ?>">

</div>

</body>
</html>