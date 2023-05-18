<?php
session_start();
include 'connectToDatabase.php';
$conn = connectToDatabase();

if (!isset($_GET['course_id'])) {
    echo 'Course not selected.';
    exit;
}

$courseId = $_GET['course_id'];


$sql = "SELECT id, status, date FROM attendance WHERE course_id = '$courseId' AND student_id = '{$_SESSION['student_id']}'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="CSS/styles.css">
    <script src="JS/main.js" defer></script>
</head>
<body>
    <table>
        <tr><th>Attendance ID</th><th>Status</th><th>Date</th></tr>
        <?php
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['status']}</td>";
            echo "<td>{$row['date']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <a href="student_course.php">Back to Course List</a>
    <a href="logout.php">Logout</a>
</body>
</html>
