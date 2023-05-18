<?php
session_start();
include 'connectToDatabase.php';

$conn = connectToDatabase();

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
            header("Location: course.php");
        } else {
            echo 'Failed to update course: ' . $conn->error;
            header("Location: course.php");
        }
    } elseif (isset($_POST['add_course'])) {
        
        $courseName = $_POST['add_course'];
        
        $sql = "INSERT INTO courses (course_name, teacher_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $courseName, $_SESSION['teacher_id']);

        if ($stmt->execute()) {
            echo 'Course added successfully.';
            header("Location: course.php");
        } else {
            echo 'Failed to add course: ' . $conn->error;
            header("Location: course.php");
        }
    } else {
        echo 'Invalid request.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['course_id'])) {
        
        $courseId = $_GET['course_id'];
        
        $sql = "DELETE FROM courses WHERE id = ? AND teacher_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $courseId, $_SESSION['teacher_id']);

        if ($stmt->execute()) {
            echo 'Course deleted successfully.';
            header("Location: course.php");
        } else {
            echo 'Failed to delete course: ' . $conn->error;
            header("Location: course.php");
        }
    } else {
        echo 'Invalid request.';
    }
} else {
    echo 'Invalid request.';
}

?>
