<?php
session_start();
include 'connectToDatabase.php';
$conn = connectToDatabase();

if (!isset($_POST['course_id']) || !isset($_POST['attendance'])) {
    exit('Invalid request');
}

$course_id = $_POST['course_id'];
$attendance = $_POST['attendance'];

foreach ($attendance as $student_id => $status) {
    $sql = "INSERT INTO attendance (student_id, course_id, status, date)
            VALUES ('$student_id', '$course_id', '$status', NOW())";
    mysqli_query($conn, $sql);
}

header('Location: course.php');
?>
