`<?php
include "config.php";

$student_id = $_GET['student_id'];

$sql = "SELECT * FROM students WHERE student_id='$student_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    echo "
    <h5>Name: {$row['name']}</h5>
    <p>Student ID: {$row['student_id']}</p>
    <p>Course: {$row['course']}</p>
    <p>Year Level: {$row['year_level']}</p>
    <p><b>Points: {$row['points']}</b></p>

    <hr>

    <a href='award.php?id={$row['student_id']}' class='btn btn-success'>Give Award / Points</a>
    ";

} else {
    echo "Student not found";
}
?>