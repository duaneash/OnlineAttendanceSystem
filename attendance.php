<?php
session_start();
include 'connectToDatabase.php';
$conn = connectToDatabase();

if (!isset($_GET['course_id'])) {
    exit('No course ID provided');
}

$course_id = $_GET['course_id'];

$sql = "SELECT students.name, attendance.status, attendance.date
        FROM attendance
        JOIN students ON attendance.student_id = students.id
        WHERE attendance.course_id = '$course_id'
        ORDER BY attendance.date DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="CSS/styles.css">
</head>
<body>
    <h2>Attendance Infomation</h2>
    <table>
        <tr><th>Student Name</th><th>Status</th><th>Date</th></tr>
        <?php
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['status']}</td>";
            echo "<td>{$row['date']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <a href="course.php">Course Page</a>
</body>
</html>
