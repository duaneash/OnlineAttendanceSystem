<?php
session_start();
include 'connectToDatabase.php';

$conn = connectToDatabase();

// Check if it's an AJAX request to view attendance records
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['view_attendance'])) {
    $course_id = $_POST['course_id'];

    $sql = "SELECT students.name, attendance.status, attendance.date
            FROM attendance
            JOIN students ON attendance.student_id = students.id
            WHERE attendance.course_id = ? 
            ORDER BY attendance.date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $course_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $records = array();
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }

        echo json_encode($records);
        exit;
    } else {
        echo 'Failed to fetch attendance records: ' . $conn->error;
        exit;
    }
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['course_id']) && isset($_POST['update_course'])) {
        // User wants to update a course
        $courseId = $_POST['course_id'];
        $newName = $_POST['update_course'];
        
        $sql = "UPDATE courses SET course_name = ? WHERE id = ? AND teacher_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sii', $newName, $courseId, $_SESSION['teacher_id']);

        if ($stmt->execute()) {
            echo 'Course updated successfully.';
            header("Location: teacher_course.php");
        } else {
            echo 'Failed to update course: ' . $conn->error;
            header("Location: teacher_course.php");
        }
    } elseif (isset($_POST['add_course'])) {
        // User wants to add a course
        $courseName = $_POST['add_course'];
        
        $sql = "INSERT INTO courses (course_name, teacher_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $courseName, $_SESSION['teacher_id']);

        if ($stmt->execute()) {
            echo 'Course added successfully.';
            header("Location: teacher_course.php");
        } else {
            echo 'Failed to add course: ' . $conn->error;
            header("Location: teacher_course.php");
        }
    } else {
        echo 'Invalid request.';
    }
}

// Check if it's a GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['course_id'])) {
        // User wants to delete a course
        $courseId = $_GET['course_id'];
        
        $sql = "DELETE FROM courses WHERE id = ? AND teacher_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $courseId, $_SESSION['teacher_id']);

        if ($stmt->execute()) {
            echo 'Course deleted successfully.';
            header("Location: teacher_course.php");
        } else {
            echo 'Failed to delete course: ' . $conn->error;
            header("Location: teacher_course.php");
        }
    } else {
        echo 'Invalid request.';
    }
}
?>
