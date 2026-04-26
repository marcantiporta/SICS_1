<?php
session_start();
include "config.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>LMS Gradebook</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
    </style>
</head>

<body>

<div class="container mt-4">

    <h2>🎓 LMS GRADEBOOK</h2>

    <div class="box mt-3">

        <table class="table table-bordered">
            <tr>
                <th>Student ID</th>
                <th>Subject</th>
                <th>Base Grade</th>
                <th>Bonus</th>
                <th>Final Grade</th>
                <th>Status</th>
            </tr>

            <?php
            $sql = "SELECT * FROM grades";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {

                echo "<tr>
                    <td>{$row['student_id']}</td>
                    <td>{$row['subject']}</td>
                    <td>{$row['base_grade']}</td>
                    <td>{$row['bonus']}</td>
                    <td><b>{$row['final_grade']}</b></td>
                    <td><span class='badge bg-success'>Confirmed</span></td>
                </tr>";
            }
            ?>

        </table>

    </div>

</div>

</body>
</html>