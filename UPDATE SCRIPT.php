<?php
include "config.php";

$sql = "SELECT * FROM students";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {

    $points = $row['points'];

    $bonus = floor($points / 100) * 0.5;

    // update all grades of student
    $conn->query("UPDATE grades 
    SET bonus = $bonus,
    final_grade = base_grade + $bonus
    WHERE student_id='{$row['student_id']}'");

}
?>