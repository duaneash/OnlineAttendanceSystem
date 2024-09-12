<?php
session_start();
include 'connectToDatabase.php';
$conn = connectToDatabase();

if (isset($_POST['mark_attendance'])) {
    $student_id = $_SESSION['student_id'];
    $course_id = $_POST['course_id'];
    $attendance_date = date("Y-m-d"); // current date

    // Check if an attendance record already exists for the current date
    $check_sql = "SELECT * FROM attendance WHERE student_id = '$student_id' AND course_id = '$course_id' AND date = '$attendance_date'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if(mysqli_num_rows($check_result) > 0) {
        // If the query returns a result, an attendance record already exists for the current date
        header("Location: student_course.php?message=You've already marked attendance for today in this course.");
    } else {
        // Insert the attendance record into the database
        $sql = "INSERT INTO attendance (student_id, course_id, date) VALUES ('$student_id', '$course_id', '$attendance_date')";
    
        if (mysqli_query($conn, $sql)) {
            // If the query is successful, redirect back to the student course page with a success message
            header("Location: student_course.php?message=Attendance marked successfully!");
        } else {
            // If the query fails, redirect back to the student course page with an error message
            header("Location: student_course.php?message=Failed to mark attendance: " . mysqli_error($conn));
        }
    }
}

if (isset($_POST['view_attendance'])) {
    $student_id = $_SESSION['student_id'];
    $course_id = $_POST['course_id'];

    $sql = "SELECT courses.id as course_id, courses.course_name, attendance.date FROM courses INNER JOIN attendance ON courses.id = attendance.course_id WHERE attendance.student_id = '$student_id' AND attendance.course_id = '$course_id' ORDER BY attendance.date DESC";
    $result = mysqli_query($conn, $sql);

    $records = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    }
  
    echo json_encode($records);
}  
if (isset($_POST['register_course'])) {
    $course_id = $_POST['course_id'];
    $student_id = $_SESSION['student_id'];

    $sql = "INSERT INTO registrations (student_id, course_id) VALUES ('$student_id', '$course_id')";

    if (mysqli_query($conn, $sql)) {
        header("Location: student_course.php?message=Register successfully.");
    } else {
        header("Location: student_course.php?message=Register failed!");
    }
}
?>
